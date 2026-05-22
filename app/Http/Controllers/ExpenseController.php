<?php
namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {

        $expenses = Expense::with(['expensesCategory', 'bankAccount'])->get();
        // if (auth()->user()->is_admin == 1) {
        // } else {

        //     $expenses = Expense::with(['expensesCategory', 'bankAccount'])->whereHas('bankAccount', function ($query) {
        //         $query->where('user_id', auth()->user()->id);
        //     })->get();
        // }

        $category = ExpenseCategory::where('status', 'active')->get();
        $accoount = BankAccount::where('status', 'active')->get();
        // dd($category);
        return view('admin.expense.index', compact('expenses', 'category', 'accoount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'  => 'required',
            'payment_mode' => 'required',
            'account_id'   => 'required',
            'subject'      => 'required',
            'amount'       => 'required|numeric',
            'date'         => 'required',
            'description'  => 'required|string',
        ]);

        // Check if account has sufficient balance
        // if ($request->payment_mode == 'dbf') {
            $account = BankAccount::findOrFail($request->account_id);
            if ($account->opening_balance < $request->amount) {
                return response()->json([
                    'message' => 'Insufficient balance in the selected account.',
                ], 422);
            }
        // }

        try {
            \DB::beginTransaction();

            // Create expense
            $expense = Expense::create([
                'category_id'  => $request->category_id,
                'account_id'   => $request->account_id ?? null,
                'payment_mode' => $request->payment_mode,
                'subject'      => $request->subject,
                'amount'       => $request->amount,
                'date'         => $request->date,
                'description'  => $request->description,
                'status'       => $request->status,
            ]);

            // Update account balance
            // if ($request->payment_mode == 'dbf') {
                $account->opening_balance -= $request->amount;
                $account->save();
            // }
            \DB::commit();

            log_activity('Expense', 'create', "New expense created: {$expense->subject} - Amount: {$expense->amount}");

            return response()->json(['message' => 'Expense created successfully.']);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['message' => 'Failed to create expense. Please try again.'], 500);
        }
    }

    public function edit($id)
    {
        $expense = Expense::where('id', $id)->with('bankAccount', 'expensesCategory')->first();
        // dd($expense);
        return response()->json($expense, 200);
    }

    public function update(Request $request)
    {
        $request->validate([
            'category_id'  => 'required',
            'account_id'   => 'nullable',
            'payment_mode' => 'required',
            'subject'      => 'required',
            'amount'       => 'required|numeric',
            'date'         => 'required',
            'description'  => 'required|string',
        ]);

        try {
            \DB::beginTransaction();

            $expense   = Expense::findOrFail($request->id);
            $oldAmount = $expense->amount;

            // if ($request->payment_mode == 'dbf') {
                $oldAccount = BankAccount::findOrFail($expense->account_id);
                $newAccount = BankAccount::findOrFail($request->account_id);

                // If amount or account changed, check balance
                if ($request->amount != $oldAmount || $request->account_id != $oldAccount->id) {
                    // If same account, add back old amount and check new amount
                    if ($request->account_id == $oldAccount->id) {
                        $availableBalance = $oldAccount->opening_balance + $oldAmount;
                        if ($availableBalance < $request->amount) {
                            return response()->json([
                                'message' => 'Insufficient balance in the selected account.',
                            ], 422);
                        }
                    } else {
                        // If different account, check new account balance
                        if ($newAccount->opening_balance < $request->amount) {
                            return response()->json([
                                'message' => 'Insufficient balance in the selected account.',
                            ], 422);
                        }
                    }
                }
            // }
            // Update expense
            $expense->update([
                'category_id'  => $request->category_id,
                'account_id'   => $request->account_id ?? null,
                'payment_mode' => $request->payment_mode,
                'subject'      => $request->subject,
                'amount'       => $request->amount,
                'date'         => $request->date,
                'description'  => $request->description,
                'status'       => $request->status,
            ]);

            // if ($request->payment_mode == 'dbf') {
                // Update account balances
                if ($request->account_id == $oldAccount->id) {
                    // Same account: adjust balance
                    $oldAccount->opening_balance = $oldAccount->opening_balance + $oldAmount - $request->amount;
                    $oldAccount->save();
                } else {
                    // Different account: refund old account and deduct from new account
                    $oldAccount->opening_balance += $oldAmount;
                    $oldAccount->save();

                    $newAccount->opening_balance -= $request->amount;
                    $newAccount->save();
                }
            // }
            \DB::commit();

            log_activity('Expense', 'update', "Expense updated: {$expense->subject} - Amount: {$expense->amount}");

            return response()->json(['message' => 'Expense updated successfully.']);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['message' => 'Failed to update expense. Please try again.'], 500);
        }
    }

    public function destroy($id)
    {
        $expense       = Expense::findOrFail($id);
        $expenseName   = $expense->subject;
        $expenseAmount = $expense->amount;
        $expense->delete();

        log_activity('Expense', 'delete', "Expense deleted: {$expenseName} - Amount: {$expenseAmount}");

        return redirect()->route('admin.expenses.list')->with('success', 'Expense deleted successfully.');
    }

    // expense category
    public function catIndex()
    {
        $expense = ExpenseCategory::all();
        return view('admin.expense.category.index', compact('expense'));
    }

    public function catStore(Request $request)
    {
        $request->validate([
            'category'    => 'required',
            'description' => 'required',
            'status'      => 'required',
        ]);

        $data              = new ExpenseCategory();
        $data->category    = $request->category;
        $data->description = $request->description;
        $data->status      = $request->status;
        $data->save();

        log_activity('Expense category', 'create', "New expense category created");

        return redirect()->route('admin.expenses.category.list')
            ->with('success', 'Expense category added successfully');
    }

    public function catEdit($id)
    {
        $expense  = ExpenseCategory::where('id', $id)->first();
        $response = [
            'expense' => $expense,
        ];
        return response()->json($expense, 200);
    }

    public function catUpdate(Request $request)
    {
        $request->validate([
            'category'    => 'required',
            'description' => 'required',
        ]);

        $data              = ExpenseCategory::find($request->expense_id);
        $data->category    = $request->category;
        $data->description = $request->description;
        $data->status      = $request->status;
        $data->save();
        log_activity('Expense category', 'update', "New expense category updated");

        return redirect()->route('admin.expenses.category.list')
            ->with('success', 'Expense category updated successfully');
    }

    public function catDestory($id)
    {
        $data = ExpenseCategory::findOrFail($id);

        $expense_count = Expense::where('category_id', $id)->count();
        if ($expense_count > 0) {
            return redirect()->back()->with('error', 'Unable to delete: This category is being used in expenses');
        }
        $data->delete();
        log_activity('Expense category', 'delete', "New expense category deleted");

        return redirect('admin/expenses/category/')->with('success', 'Expense category deleted successfully');
    }

}