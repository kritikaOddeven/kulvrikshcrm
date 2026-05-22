<?php
namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Expense;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->is_admin == 1) {
            $bankAccounts = BankAccount::latest()->get();
        } else {
            $bankAccounts = BankAccount::where('user_id', $user->id)->latest()->get();
        }
        return view('admin.settings.bank_account', compact('bankAccounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name'           => 'required|string|max:255',
            'account_holder_name' => 'required|string|max:255',
            'account_number'      => 'required|string|max:50',
            'ifsc_code'           => 'required|string|max:20',
            'swift_code'           => 'nullable|string|max:20',
            'upi_number'           => 'nullable|string|max:20',
            'opening_balance'     => 'required|string|max:20',
            'branch'              => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        BankAccount::create(array_merge($request->only([
            'bank_name',
            'account_holder_name',
            'account_number',
            'ifsc_code',
            'swift_code',
            'upi_number',
            'opening_balance',
            'branch',
            'status',
        ]), [
            'user_id' => $user->id,
        ]));

        log_activity('Bank account', 'created', "Bank account created");


        return redirect()->route('admin.settings.accounts.index')
            ->with('success', 'Bank account created successfully.');
    }

    public function edit($id)
    {
        $account = BankAccount::where('id', $id)->get()->first();
        return response()->json($account, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bank_name'           => 'required|string|max:255',
            'account_holder_name' => 'required|string|max:255',
            'account_number'      => 'required|string|max:50',
            'ifsc_code'           => 'required|string|max:20',
            'swift_code'           => 'nullable|string|max:20',
            'upi_number'           => 'nullable|string|max:20',
            'opening_balance'     => 'required|string|max:20',
            'branch'              => 'nullable|string|max:255',
        ]);
        $bankAccount = BankAccount::find($id);

        $bankAccount->update($request->only([
            'bank_name',
            'account_holder_name',
            'account_number',
            'ifsc_code',
            'swift_code',
            'upi_number',
            'opening_balance',
            'branch',
            'status',
        ]));
        log_activity('Bank account', 'updated', "Bank account updated");

        return redirect()->route('admin.settings.accounts.index')
            ->with('success', 'Bank account updated successfully.');
    }

    public function destroy($id)
    {
        $bankAccount = BankAccount::where('id', $id)->get()->first();
        $expense_count = Expense::where('account_id', $id)->count();
        if ($expense_count > 0) {
            return redirect()->back()->with('error', 'Unable to delete: This account is being used in expenses');
        }
        $bankAccount->delete();
        log_activity('Bank account', 'deleted', "Bank account deleted");

        return redirect()->route('admin.settings.accounts.index')
            ->with('success', 'Bank account deleted successfully.');
    }
}