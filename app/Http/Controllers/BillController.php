<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Bill;
use App\Models\BillService;
use App\Models\ClientService;
use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class BillController extends Controller
{
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'client_id'         => 'required|exists:clients,id',
    //         'created_at'        => 'required',
    //         'name'              => 'nullable|string',
    //         'invoice_number'    => 'nullable|string',
    //         'gst_number'        => 'nullable|string|max:15',
    //         'sac_number'        => 'nullable|string|max:15',
    //         'address'           => 'nullable|string',
    //         'type'              => 'nullable|string',
    //         'payment_terms'     => 'nullable|string',
    //         'bank_account_id'   => 'required|exists:bank_accounts,id',
    //         'project_ids'       => 'nullable|array',
    //         'project_ids.*'     => 'nullable|integer|exists:projects,id',
    //         'sub_project_ids'   => 'nullable|array',
    //         'sub_project_ids.*' => 'nullable|integer|exists:projects,id',
    //         'hsn'               => 'nullable|array',
    //         'qty'               => 'nullable|array',
    //         'service_name'      => 'nullable|array',
    //         'description'       => 'nullable|array',
    //         'hsn_detail'        => 'nullable|array',
    //         'qty_detail'        => 'nullable|array',
    //         'service_amount'    => 'nullable|array',
    //     ]);

    //     try {
    //         $client    = Client::with('lead')->findOrFail($request->client_id);
    //         $createdAt = \Carbon\Carbon::parse($request->created_at)->format('Y-m-d');

    //         // Convert empty strings to null for validation
    //         $request->merge([
    //             'project_ids'     => array_map(fn($v) => ($v === '' || $v === null) ? null : (int) $v, $request->project_ids ?? []),
    //             'sub_project_ids' => array_map(fn($v) => ($v === '' || $v === null) ? null : (int) $v, $request->sub_project_ids ?? []),
    //         ]);

    //         $bill = Bill::create([
    //             'client_id'       => $request->client_id,
    //             'created_at'      => $createdAt,
    //             'name'            => $request->name,
    //             'invoice_number'  => $request->invoice_number,
    //             'gst_number'      => $request->gst_number,
    //             'sac_number'      => $request->sac_number,
    //             'address'         => $request->address ?? '',
    //             'type'            => $request->type,
    //             'payment_terms'   => $request->payment_terms,
    //             'bank_account_id' => $request->bank_account_id,
    //             'status'          => 'paid',
    //             'amount'          => 0,
    //             'project_ids'     => null,
    //             'sub_project_ids' => null,
    //         ]);

    //         $amount       = 0;
    //         $projectIds   = $request->project_ids ?? [];
    //         $subProjectIds = $request->sub_project_ids ?? [];
    //         $hsnArr       = $request->hsn ?? [];
    //         $qtyArr       = $request->qty ?? [];
    //         $serviceNames = $request->service_name ?? [];
    //         $descriptions = $request->description ?? [];
    //         $hsnDetailArr = $request->hsn_detail ?? [];
    //         $qtyDetailArr = $request->qty_detail ?? [];
    //         $serviceAmounts = $request->service_amount ?? [];
    //         $maxBlocks     = max(
    //             count($projectIds),
    //             count($subProjectIds),
    //             count($serviceNames),
    //             count($serviceAmounts),
    //             1
    //         );

    //         $projectsById = null;
    //         if (!empty($subProjectIds)) {
    //             $projectsById = Project::whereIn('id', array_unique(array_map('intval', $subProjectIds)))->get()->keyBy('id');
    //         }

    //         for ($i = 0; $i < $maxBlocks; $i++) {
    //             $projectId   = isset($projectIds[$i]) ? (int) $projectIds[$i] : 0;
    //             $subProjectId = isset($subProjectIds[$i]) ? (int) $subProjectIds[$i] : 0;
    //             $hasProject  = $projectId > 0 && $subProjectId > 0;
    //             $hasService  = !empty(trim($serviceNames[$i] ?? '')) || !empty(trim($descriptions[$i] ?? '')) || !empty(trim($serviceAmounts[$i] ?? ''));

    //             if ($hasProject) {
    //                 $subAmount = $projectsById ? (float) ($projectsById->get($subProjectId)?->amount ?? 0) : 0;
    //                 BillService::create([
    //                     'bill_id'         => $bill->id,
    //                     'block_index'     => $i,
    //                     'project_id'      => $projectId,
    //                     'sub_project_id'  => $subProjectId,
    //                     'service_name'    => null,
    //                     'description'     => null,
    //                     'hsn'             => $hsnArr[$i] ?? null,
    //                     'quantity'        => (float) ($qtyArr[$i] ?? 0),
    //                     'amount'          => $subAmount,
    //                     'type'            => 'project',
    //                 ]);
    //                 $amount += $subAmount;
    //             }
    //             if ($hasService) {
    //                 $svcAmount = (float) preg_replace('/[^0-9.]/', '', $serviceAmounts[$i] ?? 0);
    //                 BillService::create([
    //                     'bill_id'         => $bill->id,
    //                     'block_index'     => $i,
    //                     'project_id'      => null,
    //                     'sub_project_id'  => null,
    //                     'service_name'    => trim($serviceNames[$i] ?? ''),
    //                     'description'     => trim($descriptions[$i] ?? ''),
    //                     'hsn'             => $hsnDetailArr[$i] ?? null,
    //                     'quantity'        => (float) ($qtyDetailArr[$i] ?? 0),
    //                     'amount'          => $svcAmount,
    //                     'type'            => 'service',
    //                 ]);
    //                 $amount += $svcAmount;
    //             }
    //         }

    //         if ($amount <= 0) {
    //             $bill->delete();
    //             return redirect()->back()->with('error', 'Please add at least one project or service with amount.')->withInput();
    //         }

    //         $bill->amount = $amount;
    //         $bill->project_ids = !empty($projectIds) ? json_encode(array_map('intval', $projectIds)) : null;
    //         $bill->sub_project_ids = !empty($subProjectIds) ? json_encode(array_map('intval', $subProjectIds)) : null;
    //         $bill->save();

    //         $bankAccount = BankAccount::findOrFail($request->bank_account_id);
    //         $bankAccount->opening_balance += $amount;
    //         $bankAccount->save();

    //         if ($client->lead) {
    //             $client->lead->notes = $request->address ?? '';
    //             $client->lead->save();
    //         }

    //         log_activity('Bill', 'create', "Bill created: ID {$bill->id} - Status: {$bill->status}");

    //         return redirect('/admin/bills')->with('success', 'Bill has been created successfully.');

    //     } catch (\Exception $e) {
    //         $errorMessage = 'Unable to create the bill. ';

    //         if (str_contains($e->getMessage(), 'date')) {
    //             $errorMessage .= 'Please ensure the date is in the correct format (dd-mm-yyyy).';
    //         } else {
    //             $errorMessage .= 'Please try again or contact support if the issue persists.';
    //         }

    //         return redirect()->back()->with('error', $errorMessage)->withInput();
    //     }
    // }

    public function store(Request $request)
    {
        $request->validate([
            'client_id'         => 'required|exists:clients,id',
            'created_at'        => 'required',
            'payment_mode' => 'required|string|in:neft,dbf,cheque,upi,credit,debit,cash,razorpay,stripe,op,pp',
            'name'              => 'nullable|string',
            'invoice_number'    => 'nullable|string',
            'gst_number'        => 'nullable|string|max:15',
            'sac_number'        => 'nullable|string|max:15',
            'address'           => 'nullable|string',
            'type'              => 'nullable|string',
            'payment_terms'     => 'nullable|string',
            'bank_account_id'   => 'required|exists:bank_accounts,id',
            'project_ids'       => 'nullable|array',
            'project_ids.*'     => 'nullable|integer|exists:projects,id',
            'sub_project_ids'   => 'nullable|array',
            'sub_project_ids.*' => 'nullable|integer|exists:projects,id',
            'hsn'               => 'nullable|array',
            'qty'               => 'nullable|array',
            'service_name'      => 'nullable|array',
            'description'       => 'nullable|array',
            'hsn_detail'        => 'nullable|array',
            'qty_detail'        => 'nullable|array',
            'service_amount'    => 'nullable|array',
        ]);

        try {
            $client    = Client::with('lead')->findOrFail($request->client_id);
            $createdAt = \Carbon\Carbon::parse($request->created_at)->format('Y-m-d');

            $request->merge([
                'project_ids'     => array_map(fn($v) => ($v === '' || $v === null) ? null : (int) $v, $request->project_ids ?? []),
                'sub_project_ids' => array_map(fn($v) => ($v === '' || $v === null) ? null : (int) $v, $request->sub_project_ids ?? []),
            ]);

            $bill = Bill::create([
                'client_id'       => $request->client_id,
                'created_at'      => $createdAt,
                'name'            => $request->name,
                'invoice_number'  => $request->invoice_number,
                'gst_number'      => $request->gst_number,
                'sac_number'      => $request->sac_number,
                'address'         => $request->address ?? '',
                'type'            => $request->type,
                 'payment_mode'    => $request->payment_mode,
                'payment_terms'   => $request->payment_terms,
                'bank_account_id' => $request->bank_account_id,
                'status'          => 'paid',
                'amount'          => 0,
                'project_ids'     => null,
                'sub_project_ids' => null,
            ]);

            $amount         = 0;
            $projectIds     = $request->project_ids ?? [];
            $subProjectIds  = $request->sub_project_ids ?? [];
            $hsnArr         = $request->hsn ?? [];
            $qtyArr         = $request->qty ?? [];
            $serviceNames   = $request->service_name ?? [];
            $descriptions   = $request->description ?? [];
            $hsnDetailArr   = $request->hsn_detail ?? [];
            $qtyDetailArr   = $request->qty_detail ?? [];
            $serviceAmounts = $request->service_amount ?? [];

            $maxBlocks = max(
                count($projectIds),
                count($subProjectIds),
                count($serviceNames),
                count($serviceAmounts),
                1
            );

            $projectsById = null;
            if (!empty($subProjectIds)) {
                $projectsById = Project::whereIn('id', array_unique(array_map('intval', array_filter($subProjectIds))))
                    ->get()->keyBy('id');
            }

            for ($i = 0; $i < $maxBlocks; $i++) {
                $projectId    = isset($projectIds[$i]) ? (int) $projectIds[$i] : 0;
                $subProjectId = isset($subProjectIds[$i]) ? (int) $subProjectIds[$i] : 0;
                $hasProject   = $projectId > 0 && $subProjectId > 0;

                $serviceName   = trim($serviceNames[$i] ?? '');
                $description   = trim($descriptions[$i] ?? '');
                $serviceAmount = trim($serviceAmounts[$i] ?? '');
                $hasService    = $serviceName !== '' || $description !== '' || $serviceAmount !== '';

                // ── Project row ───────────────────────────────────────────────────
                if ($hasProject) {
                    $unitPrice = $projectsById ? (float) ($projectsById->get($subProjectId)?->amount ?? 0) : 0;
                    $qty       = (float) ($qtyArr[$i] ?? 1);
                    $lineTotal = $unitPrice * $qty; // ✅ unit price × qty

                    BillService::create([
                        'bill_id'        => $bill->id,
                        'block_index'    => $i,
                        'project_id'     => $projectId,
                        'sub_project_id' => $subProjectId,
                        'service_name'   => null,
                        'description'    => null,
                        'hsn'            => $hsnArr[$i] ?? null,
                        'quantity'       => $qty,
                        'amount'         => $lineTotal,
                        'type'           => 'project',
                    ]);
                    $amount += $lineTotal;
                }

                // ── Service row ───────────────────────────────────────────────────
                if ($hasService) {
                    // ✅ JS already sent final amount (base × qty) — direct store, NO multiply
                    $rawAmount = preg_replace('/[^0-9.-]/', '', $serviceAmount);
                    $lineTotal = $rawAmount === '' ? 0 : (float) $rawAmount;
                    $qtyDetail = (float) ($qtyDetailArr[$i] ?? 1);

                    BillService::create([
                        'bill_id'        => $bill->id,
                        'block_index'    => $i,
                        'project_id'     => null,
                        'sub_project_id' => null,
                        'service_name'   => $serviceName,
                        'description'    => $description,
                        'hsn'            => $hsnDetailArr[$i] ?? null,
                        'quantity'       => $qtyDetail,
                        'amount'         => $lineTotal, // ✅ direct
                        'type'           => 'service',
                    ]);
                    $amount += $lineTotal;
                }
            }

            if ($amount <= 0) {
                $bill->delete();
                return redirect()->back()
                    ->with('error', 'Please add at least one project or service with amount.')
                    ->withInput();
            }

            $bill->amount          = $amount;
            $bill->project_ids     = !empty($projectIds)    ? json_encode(array_map('intval', $projectIds))    : null;
            $bill->sub_project_ids = !empty($subProjectIds) ? json_encode(array_map('intval', $subProjectIds)) : null;
            $bill->save();

            $bankAccount = BankAccount::findOrFail($request->bank_account_id);
            $bankAccount->opening_balance += $amount;
            $bankAccount->save();

            if ($client->lead) {
                $client->lead->notes = $request->address ?? '';
                $client->lead->save();
            }

            log_activity('Bill', 'create', "Bill created: ID {$bill->id} - Status: {$bill->status}");

            return redirect('/admin/bills')->with('success', 'Bill has been created successfully.');

        } catch (\Exception $e) {
            $errorMessage = 'Unable to create the bill. ';
            if (str_contains($e->getMessage(), 'date')) {
                $errorMessage .= 'Please ensure the date is in the correct format (dd-mm-yyyy).';
            } else {
                $errorMessage .= 'Please try again or contact support if the issue persists.';
            }
            return redirect()->back()->with('error', $errorMessage)->withInput();
        }
    }
     public function create()
    {
        $bankAccounts   = BankAccount::where('status', 'active')->orderBy('bank_name')->get();
        $parentProjects = Project::parent()->status('active')->orderBy('name')->get();
        $serviceRows    = [];

        // Fetch all clients that have a kulvrisk_id and a lead
        $clients = Client::with('lead')
            ->whereNotNull('kulvrisk_id')
            ->whereHas('lead')
            ->orderBy('kulvrisk_id')
            ->get();

        return view('admin.bills.create', compact('bankAccounts', 'serviceRows', 'parentProjects', 'clients'));
    }
    public function index()
    {
        $bills = Bill::whereNotNull(['client_id'])->whereHas('client', function ($q) {
            $q->whereNotNull('lead_id');
        })
        // ->with('client')->latest()->get();
        ->with(['client', 'billServices.subProject'])->latest()->get();
        return view('admin.bills.index', compact('bills'));
    }

    // public function edit($id)
    // {
    //     $bills = Bill::with(['client', 'bankAccount', 'billServices' => fn($q) => $q->orderBy('updated_at', 'desc')])->findOrFail($id);        // $bills = Bill::with(['client', 'bankAccount', 'billServices' => fn($q) => $q->orderBy('block_index')->orderBy('type')])->where('id', $id)->first();
    //     $bankAccounts = BankAccount::where('status', 'active')->orderBy('bank_name')->get();

    //     // Build service rows from bill_services (grouped by block_index)
    //     $serviceRows = [];
    //     $byBlock = $bills->billServices->groupBy('block_index');
    //     foreach ($byBlock->sortKeys() as $blockIndex => $items) {
    //         $row = [
    //             'project_id'       => null,
    //             'sub_project_id'   => null,
    //             'hsn'              => '',
    //             'qty'              => '',
    //             'service_name'     => '',
    //             'description'      => '',
    //             'hsn_detail'       => '',
    //             'qty_detail'       => '',
    //             'service_amount'   => '',
    //         ];
    //         // foreach ($items as $svc) {
    //         //     if ($svc->type === 'project') {
    //         //         $row['project_id'] = $svc->project_id;
    //         //         $row['sub_project_id'] = $svc->sub_project_id;
    //         //         $row['hsn'] = $svc->hsn ?? '';
    //         //         $row['qty'] = $svc->quantity ?? '';
    //         //     } else {
    //         //         $row['service_name'] = $svc->service_name ?? '';
    //         //         $row['description'] = $svc->description ?? '';
    //         //         $row['hsn_detail'] = $svc->hsn ?? '';
    //         //         $row['qty_detail'] = $svc->quantity ?? '';
    //         //         $row['service_amount'] = $svc->amount ?? '';
    //         //     }
    //         // }
    //         foreach ($items as $svc) {
    //         if ($svc->type === 'project') {
    //             $row['project_id']     = $svc->project_id;
    //             $row['sub_project_id'] = $svc->sub_project_id;
    //             $row['hsn']            = $svc->hsn ?? '';
    //             $row['qty']            = $svc->quantity ?? '';
    //         } else {
    //             $row['service_name'] = $svc->service_name ?? '';
    //             $row['description']  = $svc->description ?? '';
    //             $row['hsn_detail']   = $svc->hsn ?? '';
    //             $row['qty_detail']   = $svc->quantity ?? '';
    //             // Derive unit price from stored line total and quantity
    //             $row['service_amount'] = $svc->quantity > 0
    //                 ? $svc->amount / $svc->quantity
    //                 : $svc->amount;   // fallback if quantity is zero
    //         }
    //     }
    //         $serviceRows[] = $row;
    //     }
    //     if (empty($serviceRows)) {
    //         $serviceRows = [['project_id' => null, 'sub_project_id' => null, 'hsn' => '', 'qty' => '', 'service_name' => '', 'description' => '', 'hsn_detail' => '', 'qty_detail' => '', 'service_amount' => '']];
    //     }

    //     $parentProjects = Project::parent()->status('active')->orderBy('name')->get();

    //     return view('admin.bills.edit', compact('bills', 'bankAccounts', 'serviceRows', 'parentProjects'));
    // }
    //mansi add new
    public function edit($id)
    {
        $bills = Bill::with([
            'client.lead',
            'bankAccount',
            'billServices' => fn($q) => $q->orderBy('block_index')->orderBy('type')
        ])->findOrFail($id);

        $bankAccounts = BankAccount::where('status', 'active')->orderBy('bank_name')->get();

        $serviceRows = [];
        $byBlock = $bills->billServices->groupBy('block_index');

        foreach ($byBlock->sortKeys() as $blockIndex => $items) {
            $row = [
                'project_id'     => null,
                'sub_project_id' => null,
                'hsn'            => '',
                'qty'            => '',
                'service_name'   => '',
                'description'    => '',
                'hsn_detail'     => '',
                'qty_detail'     => '',
                'service_amount' => '',
            ];

            foreach ($items as $svc) {
                if ($svc->type === 'project') {
                    $row['project_id']     = $svc->project_id;
                    $row['sub_project_id'] = $svc->sub_project_id;
                    $row['hsn']            = $svc->hsn ?? '';
                    $row['qty']            = $svc->quantity ?? 1;
                } else {
                    $row['service_name']   = $svc->service_name ?? '';
                    $row['description']    = $svc->description ?? '';
                    $row['hsn_detail']     = $svc->hsn ?? '';
                    $row['qty_detail']     = $svc->quantity ?? 1;
                    $row['service_amount'] = $svc->amount ?? '';
                }
            }

            $serviceRows[] = $row;
        }

        if (empty($serviceRows)) {
            $serviceRows = [[
                'project_id'     => null,
                'sub_project_id' => null,
                'hsn'            => '',
                'qty'            => '',
                'service_name'   => '',
                'description'    => '',
                'hsn_detail'     => '',
                'qty_detail'     => '',
                'service_amount' => '',
            ]];
        }

    
        $hasExistingServices = count($serviceRows) > 0 &&
            collect($serviceRows)->contains(fn($r) =>
                $r['project_id'] || $r['service_name'] || $r['service_amount']
            );

        $parentProjects = Project::parent()->status('active')->orderBy('name')->get();

        return view('admin.bills.edit', compact(
            'bills',
            'bankAccounts',
            'serviceRows',
            'parentProjects',
            'hasExistingServices' 
        ));
    }

    // public function update(Request $request)
    // {
    //     // Convert empty strings to null for service-only rows
    //     $request->merge([
    //         'project_ids'     => array_map(fn($v) => ($v === '' || $v === null) ? null : (int) $v, $request->project_ids ?? []),
    //         'sub_project_ids' => array_map(fn($v) => ($v === '' || $v === null) ? null : (int) $v, $request->sub_project_ids ?? []),
    //     ]);

    //     $request->validate([
    //         'id' => 'required|exists:bills,id',
    //         'created_at' => 'required',
    //         'name' => 'nullable|string|',
    //         'payment_mode'    => 'required|string|in:neft,dbf,cheque,upi,credit,debit,cash,razorpay,stripe,op,pp',
    //         'gst_number' => 'nullable|string|max:15',
    //         'sac_number' => 'nullable|string|max:15',
    //         'address' => 'nullable',
    //         'type' => 'nullable',
    //         'payment_terms' => 'nullable',
    //         'bank_account_id' => 'nullable|exists:bank_accounts,id',
    //         'project_ids' => 'nullable|array',
    //         'project_ids.*' => 'nullable|integer|exists:projects,id',
    //         'sub_project_ids' => 'nullable|array',
    //         'sub_project_ids.*' => 'nullable|integer|exists:projects,id',
    //         'hsn' => 'nullable|array',
    //         'qty' => 'nullable|array',
    //         'service_name' => 'nullable|array',
    //         'description' => 'nullable|array',
    //         'hsn_detail' => 'nullable|array',
    //         'qty_detail' => 'nullable|array',
    //         'service_amount' => 'nullable|array',
    //     ]);

    //     try {
    //         $bill = Bill::findOrFail($request->id);
    //         $createdAt = \Carbon\Carbon::parse($request->created_at)->format('Y-m-d');
    //         $lead = $bill->client->lead;

    //         $bill->created_at = $createdAt;
    //         $bill->name = $request->name;
    //         $bill->gst_number = $request->gst_number;
    //         $bill->address = $request->address ?? '';
    //         $bill->sac_number = $request->sac_number;
    //         $bill->type = $request->type;
    //         $bill->payment_terms = $request->payment_terms;

    //         if ($request->filled('bank_account_id')) {
    //             $bill->bank_account_id = $request->bank_account_id;
    //         }

    //         // Delete existing bill_services and recreate from form
    //         $bill->billServices()->delete();

    //         $amount         = 0;
    //         $projectIds     = $request->project_ids ?? [];
    //         $subProjectIds  = $request->sub_project_ids ?? [];
    //         $hsnArr         = $request->hsn ?? [];
    //         $qtyArr         = $request->qty ?? [];
    //         $serviceNames   = $request->service_name ?? [];
    //         $descriptions   = $request->description ?? [];
    //         $hsnDetailArr   = $request->hsn_detail ?? [];
    //         $qtyDetailArr   = $request->qty_detail ?? [];
    //         $serviceAmounts = $request->service_amount ?? [];
    //         $maxBlocks       = max(
    //             count($projectIds),
    //             count($subProjectIds),
    //             count($serviceNames),
    //             count($serviceAmounts),
    //             1
    //         );

    //         $projectsById = null;
    //         if (!empty(array_filter($subProjectIds))) {
    //             $projectsById = Project::whereIn('id', array_unique(array_map('intval', array_filter($subProjectIds))))->get()->keyBy('id');
    //         }

    //         for ($i = 0; $i < $maxBlocks; $i++) {
    //             $projectId    = isset($projectIds[$i]) ? (int) ($projectIds[$i] ?? 0) : 0;
    //             $subProjectId = isset($subProjectIds[$i]) ? (int) ($subProjectIds[$i] ?? 0) : 0;
    //             $hasProject   = $projectId > 0 && $subProjectId > 0;
    //             $hasService   = !empty(trim($serviceNames[$i] ?? '')) || !empty(trim($descriptions[$i] ?? '')) || !empty(trim($serviceAmounts[$i] ?? ''));

    //             if ($hasProject) {
    //                 $unitPrice = $projectsById ? (float) ($projectsById->get($subProjectId)?->amount ?? 0) : 0;
    //                 $qty       = (float) ($qtyArr[$i] ?? 1);
    //                 $lineTotal = $unitPrice * $qty; // ✅

    //                 BillService::create([
    //                     'bill_id'        => $bill->id,
    //                     'block_index'    => $i,
    //                     'project_id'     => $projectId,
    //                     'sub_project_id' => $subProjectId,
    //                     'service_name'   => null,
    //                     'description'    => null,
    //                     'hsn'            => $hsnArr[$i] ?? null,
    //                     'quantity'       => $qty,
    //                     'amount'         => $lineTotal, // ✅
    //                     'type'           => 'project',
    //                 ]);
    //                 $amount += $lineTotal; // ✅
    //             }

    //             if ($hasService) {
    //                 $lineTotal = (float) preg_replace('/[^0-9.]/', '', (string)($serviceAmounts[$i] ?? '0')); // ✅ FINAL amount
    //                 $qtyDetail = (float) ($qtyDetailArr[$i] ?? 1);

    //                 BillService::create([
    //                     'bill_id'        => $bill->id,
    //                     'block_index'    => $i,
    //                     'project_id'     => null,
    //                     'sub_project_id' => null,
    //                     'service_name'   => trim($serviceNames[$i] ?? ''),
    //                     'description'    => trim($descriptions[$i] ?? ''),
    //                     'hsn'            => $hsnDetailArr[$i] ?? null,
    //                     'quantity'       => $qtyDetail,
    //                     'amount'         => $lineTotal, // ✅
    //                     'type'           => 'service',
    //                 ]);
    //                 $amount += $lineTotal; // ✅
    //             }
    //         }

    //         if ($amount <= 0) {
    //             return redirect()->back()->with('error', 'Please add at least one project or service with amount.')->withInput();
    //         }
    //         $bill->payment_mode = $request->payment_mode;
    //         $bill->amount = $amount;
    //         $bill->project_ids = !empty(array_filter($projectIds)) ? json_encode(array_values(array_map('intval', array_filter($projectIds)))) : null;
    //         $bill->sub_project_ids = !empty(array_filter($subProjectIds)) ? json_encode(array_values(array_map('intval', array_filter($subProjectIds)))) : null;
    //         $bill->save();
    //         // // Store only the notes part (after 4th comma) in bill's address field
    //         // // The first 4 parts (state, district, village, taluka) are already stored in lead relationships
    //         // $addressParts = explode(',', $request->address);
    //         // $addressParts = array_slice($addressParts, 4);
    //         // $address = implode(', ', $addressParts);
    //         // $lead->notes = $address ?? '';
    //         // $lead->save();
            
    //         $lead->notes = $request->address ?? '';
    //         $lead->save();


    //         log_activity('Bill', 'update', "Bill updated: ID {$bill->id} - Status: {$bill->status}");

    //         return redirect('/admin/bills')->with('success', 'Bill has been updated successfully.');
    //     } catch (\Exception $e) {
    //           \Log::error('Bill update error: ' . $e->getMessage()); 

    //         $errorMessage = 'Unable to update the bill. ';

    //         if (str_contains($e->getMessage(), 'date')) {
    //             $errorMessage .= 'Please ensure the date is in the correct format (dd-mm-yyyy).';
    //         } else {
    //             $errorMessage .= 'Please try again or contact support if the issue persists.';
    //         }

    //         return redirect()->back()->with('error', $errorMessage);
    //     }
    // }
     //mansi add new
    public function update(Request $request)
    {
        // Convert empty strings to null for service-only rows
        $request->merge([
            'project_ids'     => array_map(fn($v) => ($v === '' || $v === null) ? null : (int) $v, $request->project_ids ?? []),
            'sub_project_ids' => array_map(fn($v) => ($v === '' || $v === null) ? null : (int) $v, $request->sub_project_ids ?? []),
        ]);

        $request->validate([
            'id' => 'required|exists:bills,id',
            'created_at' => 'required',
            'name' => 'nullable|string|',
            'payment_mode' => 'required|string|in:neft,dbf,cheque,upi,credit,debit,cash,razorpay,stripe,op,pp',
            'gst_number' => 'nullable|string|max:15',
            'sac_number' => 'nullable|string|max:15',
            // 'invoice_number' => 'nullable|string',
            'address' => 'nullable',
            'type' => 'nullable',
            'payment_terms' => 'nullable',
            'bank_account_id' => 'nullable|exists:bank_accounts,id',
            'project_ids' => 'nullable|array',
            'project_ids.*' => 'nullable|integer|exists:projects,id',
            'sub_project_ids' => 'nullable|array',
            'sub_project_ids.*' => 'nullable|integer|exists:projects,id',
            'hsn' => 'nullable|array',
            'qty' => 'nullable|array',
            'service_name' => 'nullable|array',
            'description' => 'nullable|array',
            'hsn_detail' => 'nullable|array',
            'qty_detail' => 'nullable|array',
            'service_amount' => 'nullable|array',
            'status' => 'required|in:paid,cancel',
            'cancel_reason' => 'nullable|string',
        ]);

        try {
            $bill = Bill::findOrFail($request->id);
            $createdAt = \Carbon\Carbon::parse($request->created_at)->format('Y-m-d');
            $lead = $bill->client->lead;

            $bill->created_at = $createdAt;
            $bill->name = $request->name;
            //  $bill->invoice_number = $request->invoice_number;
            $bill->gst_number = $request->gst_number;
            $bill->address = $request->address ?? '';
            $bill->sac_number = $request->sac_number;
            $bill->type = $request->type;
            $bill->payment_terms = $request->payment_terms;

            if ($request->filled('bank_account_id')) {
                $bill->bank_account_id = $request->bank_account_id;
            }

            // Delete existing bill_services and recreate from form
            $bill->billServices()->delete();

            $amount         = 0;
            $projectIds     = $request->project_ids ?? [];
            $subProjectIds  = $request->sub_project_ids ?? [];
            $hsnArr         = $request->hsn ?? [];
            $qtyArr         = $request->qty ?? [];
            $serviceNames   = $request->service_name ?? [];
            $descriptions   = $request->description ?? [];
            $hsnDetailArr   = $request->hsn_detail ?? [];
            $qtyDetailArr   = $request->qty_detail ?? [];
            $serviceAmounts = $request->service_amount ?? [];
            $maxBlocks       = max(
                count($projectIds),
                count($subProjectIds),
                count($serviceNames),
                count($serviceAmounts),
                1
            );

            $projectsById = null;
            if (!empty(array_filter($subProjectIds))) {
                $projectsById = Project::whereIn('id', array_unique(array_map('intval', array_filter($subProjectIds))))->get()->keyBy('id');
            }

            for ($i = 0; $i < $maxBlocks; $i++) {
                $projectId    = isset($projectIds[$i]) ? (int) ($projectIds[$i] ?? 0) : 0;
                $subProjectId = isset($subProjectIds[$i]) ? (int) ($subProjectIds[$i] ?? 0) : 0;
                $hasProject   = $projectId > 0 && $subProjectId > 0;
                $hasService   = !empty(trim($serviceNames[$i] ?? '')) || !empty(trim($descriptions[$i] ?? '')) || !empty(trim($serviceAmounts[$i] ?? ''));

                if ($hasProject) {
                    $unitPrice = $projectsById ? (float) ($projectsById->get($subProjectId)?->amount ?? 0) : 0;
                    $qty       = (float) ($qtyArr[$i] ?? 1);
                    $lineTotal = $unitPrice * $qty; // ✅

                    BillService::create([
                        'bill_id'        => $bill->id,
                        'block_index'    => $i,
                        'project_id'     => $projectId,
                        'sub_project_id' => $subProjectId,
                        'service_name'   => null,
                        'description'    => null,
                        'hsn'            => $hsnArr[$i] ?? null,
                        'quantity'       => $qty,
                        'amount'         => $lineTotal, // ✅
                        'type'           => 'project',
                    ]);
                    $amount += $lineTotal; // ✅
                }

                if ($hasService) {
                    $lineTotal = (float) preg_replace('/[^0-9.]/', '', (string)($serviceAmounts[$i] ?? '0')); // ✅ FINAL amount
                    $qtyDetail = (float) ($qtyDetailArr[$i] ?? 1);

                    BillService::create([
                        'bill_id'        => $bill->id,
                        'block_index'    => $i,
                        'project_id'     => null,
                        'sub_project_id' => null,
                        'service_name'   => trim($serviceNames[$i] ?? ''),
                        'description'    => trim($descriptions[$i] ?? ''),
                        'hsn'            => $hsnDetailArr[$i] ?? null,
                        'quantity'       => $qtyDetail,
                        'amount'         => $lineTotal, // ✅
                        'type'           => 'service',
                    ]);
                    $amount += $lineTotal; // ✅
                }
            }

            if ($amount <= 0) {
                return redirect()->back()->with('error', 'Please add at least one project or service with amount.')->withInput();
            }
            $bill->payment_mode = $request->payment_mode;
            $bill->amount = $amount;
            // ✅ STATUS LOGIC
            $bill->status = $request->status;

            if ($request->status == 'cancel') {
                $bill->cancel_reason = $request->cancel_reason;
            } else {
                $bill->cancel_reason = null;
            }
            $bill->project_ids = !empty(array_filter($projectIds)) ? json_encode(array_values(array_map('intval', array_filter($projectIds)))) : null;
            $bill->sub_project_ids = !empty(array_filter($subProjectIds)) ? json_encode(array_values(array_map('intval', array_filter($subProjectIds)))) : null;
            $bill->save();
            // // Store only the notes part (after 4th comma) in bill's address field
            // // The first 4 parts (state, district, village, taluka) are already stored in lead relationships
            // $addressParts = explode(',', $request->address);
            // $addressParts = array_slice($addressParts, 4);
            // $address = implode(', ', $addressParts);
            // $lead->notes = $address ?? '';
            // $lead->save();

            
            $client = $bill->client;
            $client->clientServices()->delete();

            for ($i = 0; $i < $maxBlocks; $i++) {
                $projectId    = isset($projectIds[$i]) ? (int)($projectIds[$i] ?? 0) : 0;
                $subProjectId = isset($subProjectIds[$i]) ? (int)($subProjectIds[$i] ?? 0) : 0;
                $hasProject   = $projectId > 0 && $subProjectId > 0;
                $hasService   = !empty(trim($serviceNames[$i] ?? '')) || !empty(trim($descriptions[$i] ?? '')) || !empty(trim($serviceAmounts[$i] ?? ''));

                if ($hasProject) {
                    $unitPrice = $projectsById ? (float)($projectsById->get($subProjectId)?->amount ?? 0) : 0;
                    $qty       = (float)($qtyArr[$i] ?? 1);

                    ClientService::create([
                        'client_id'      => $client->id,
                        'block_index'    => $i,
                        'project_id'     => $projectId,
                        'sub_project_id' => $subProjectId,
                        'service_name'   => null,
                        'description'    => null,
                        'quantity'       => $qty,
                        'amount'         => $unitPrice * $qty,
                        'type'           => 'project',
                    ]);
                }

                if ($hasService) {
                    $lineTotal = (float)preg_replace('/[^0-9.]/', '', (string)($serviceAmounts[$i] ?? '0'));
                    $qtyDetail = (float)($qtyDetailArr[$i] ?? 1);

                    ClientService::create([
                        'client_id'      => $client->id,
                        'block_index'    => $i,
                        'project_id'     => null,
                        'sub_project_id' => null,
                        'service_name'   => trim($serviceNames[$i] ?? ''),
                        'description'    => trim($descriptions[$i] ?? ''),
                        'quantity'       => $qtyDetail,
                        'amount'         => $lineTotal,
                        'type'           => 'service',
                    ]);
                }
            }
            $lead->notes = $request->address ?? '';
            $lead->save();


            log_activity('Bill', 'update', "Bill updated: ID {$bill->id} - Status: {$bill->status}");

            return redirect('/admin/bills')->with('success', 'Bill has been updated successfully.');
        } catch (\Exception $e) {
            $errorMessage = 'Unable to update the bill. ';

            if (str_contains($e->getMessage(), 'date')) {
                $errorMessage .= 'Please ensure the date is in the correct format (dd-mm-yyyy).';
            } else {
                $errorMessage .= 'Please try again or contact support if the issue persists.';
            }

            return redirect()->back()->with('error', $errorMessage);
        }
    }
    public function show($id)
    {
        $bill = Bill::with(['client.lead.states', 'client.lead.countries', 'bankAccount', 'billServices' => fn($q) => $q->with('subProject')->orderBy('updated_at', 'desc')])->findOrFail($id);
 
        $projects = collect();
        if ($bill->billServices->isNotEmpty()) {
            foreach ($bill->billServices as $svc) {
                $projects->push((object)[
                    'name'   => $svc->type === 'project' ? ($svc->subProject?->name ?? '-') : ($svc->service_name ?? '-'),
                    'amount' => (float) $svc->amount,
                    'hsn'    => $svc->hsn ?? $bill->sac_number,
                    'description' => $svc->type === 'service' ? ($svc->description ?? '') : '',                        
                ]);
            }
        } else {
            $subProjectIds = json_decode($bill->sub_project_ids ?? $bill->client->sub_project_ids ?? '[]', true) ?: [];
            $projectsById = Project::whereIn('id', array_unique($subProjectIds))->get()->keyBy('id');
            foreach ($subProjectIds as $subId) {
                if ($projectsById->has($subId)) {
                    $projects->push($projectsById->get($subId));
                }
            }
        }
        $subTotal = $projects->sum('amount');
        // Check if country is India
        $countryName = strtolower($bill->client->lead->countries->name ?? '');
        $isIndia = $countryName === 'india';
        $isGujarat = false;
        if ($isIndia) {
            // Check if state is Gujarat
            $stateName = strtolower($bill->client->lead->states->name ?? '');
            $isGujarat = $stateName === 'gujarat';

            if ($isGujarat) {
                $cgst = $subTotal * 0.09;
                $sgst = $subTotal * 0.09;
                $igst = 0;
            } else {
                $cgst = 0;
                $sgst = 0;
                $igst = $subTotal * 0.18;
            }
        } else {
            // Calculate CGST and SGST for other countries but don't show in frontend/PDF
            $cgst = $subTotal * 0.09;
            $sgst = $subTotal * 0.09;
            $igst = 0;
        }

        $grossAmount = round($subTotal + $cgst + $sgst + $igst, 2);
        $totalAmount = floor($grossAmount);
        $roundOffDiscount = round($grossAmount - $totalAmount, 2);

        return view('admin.bills.view', compact('bill', 'projects', 'subTotal', 'cgst', 'sgst', 'igst', 'totalAmount', 'isGujarat', 'isIndia', 'grossAmount', 'roundOffDiscount'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'bank_account_id' => 'required',
            'sub_project_ids' => 'nullable|array',
            'sub_project_ids.*' => 'integer|exists:projects,id',
        ]);

        // $bankAccount = BankAccount::where('user_id', auth()->user()->id)->first();
        // if (!$bankAccount) {
        //     return redirect()->back()->with('failed', 'No bank account found. Please add a bank account first.');
        // }

        $bankAccount = BankAccount::where('id', $request->bank_account_id)->first();

        $amount = (float) $request->amount;

        if ($request->filled('sub_project_ids')) {
            $subProjectIds = array_map('intval', $request->sub_project_ids);
            $projectsById = Project::whereIn('id', array_unique($subProjectIds))->get()->keyBy('id');
            $amount = (float) collect($subProjectIds)->sum(fn ($id) => $projectsById->get($id)?->amount ?? 0);
        }

        $bill = Bill::create([
            'client_id' => $request->client_id,
            'invoice_number' => $request->invoice_number,
            'status' => 'paid',
            'amount' => $amount,
            'bank_account_id' => $request->bank_account_id,
            'project_ids' => $request->filled('project_ids') ? json_encode(array_map('intval', $request->project_ids)) : null,
            'sub_project_ids' => $request->filled('sub_project_ids') ? json_encode($subProjectIds) : null,
        ]);
        $bankAccount->opening_balance += $amount;
        $bankAccount->save();

        // $client = Client::find($request->client_id);
        // $client->kulvrisk_id = $request->kulvrisk_id;
        // if ($request->filled('sub_project_ids')) {
        //     $client->sub_project_ids = json_encode(array_map('intval', $request->sub_project_ids));
        // }
        // $client->save();

        log_activity('Bill', 'generate', "Bill generated: ID {$bill->id} - Status: {$bill->status}");

        return redirect('admin/bills')->with('success', 'Bill generated successfully.');
    }

    public function destroy($id)
    {
        $bill = Bill::findOrFail($id);
        $billId = $bill->id;
        $bill->delete();

        log_activity('Bill', 'delete', "Bill deleted: ID {$billId}");

        return redirect('/admin/bills')->with('success', 'Bill has been deleted successfully.');
    }
    public function getClientByKulvrikshId(Request $request)
    {
        $kulvrikshId = $request->query('kulvrisk_id');

        if (!$kulvrikshId) {
            return response()->json(['found' => false]);
        }

        $client = Client::with([
            'lead.states', 'lead.cities', 'lead.districts',
            'lead.talukas', 'lead.villages', 'lead.countries',
        ])->where('kulvrisk_id', $kulvrikshId)->first();

        if (!$client || !$client->lead) {
            return response()->json(['found' => false]);
        }

        return response()->json($this->buildClientResponse($client));
    }
      public function getClientByPhone(Request $request)
    {
        $phone = $request->query('phone');

        if (!$phone) {
            return response()->json(['found' => false]);
        }

        $client = Client::with([
            'lead.states', 'lead.cities', 'lead.districts',
            'lead.talukas', 'lead.villages', 'lead.countries',
        ])->whereHas('lead', fn($q) => $q->where('phone', $phone))->first();

        if (!$client || !$client->lead) {
            return response()->json(['found' => false]);
        }

        return response()->json($this->buildClientResponse($client));
    }
    public function getClientByEmail(Request $request)
    {
        $email = $request->query('email');

        if (!$email) {
            return response()->json(['found' => false]);
        }

        $client = Client::with([
            'lead.states', 'lead.cities', 'lead.districts',
            'lead.talukas', 'lead.villages', 'lead.countries',
        ])->whereHas('lead', function ($q) use ($email) {
            $q->where('email', $email);
        })->first();

        if (!$client || !$client->lead) {
            return response()->json(['found' => false]);
        }

        return response()->json($this->buildClientResponse($client));
    }
     private function buildClientResponse(Client $client): array
    {
        $lead = $client->lead;

        $addressParts = array_filter([
            optional($lead->villages)->name,
            optional($lead->talukas)->name,
            optional($lead->districts)->name,
            optional($lead->cities)->name,
            optional($lead->states)->name,
            optional($lead->countries)->name,
        ]);

        $fullAddress = implode(', ', $addressParts);
        $name        = trim(collect([$lead->first_name, $lead->middle_name, $lead->last_name])->filter()->implode(' '));

        // return [
        //     'found'       => true,
        //     'client_id'   => $client->id,           // ← added so the form can post client_id
        //     'kulvrisk_id' => $client->kulvrisk_id,
        //     'name'        => $name,
        //     'phone'       => $lead->phone,
        //     'phonecode'   => $lead->phonecode ?? '+91',
        //      'email'       => $lead->email ?? '', 
        //     'address'     => $lead->notes ?? '',
        //     'address_full'=> $fullAddress,
        // ];
         // mansi add
        return [
            'found'        => true,
            'client_id'    => $client->id,
            'kulvrisk_id'  => $client->kulvrisk_id,
            'name'         => $name,
            'phone'        => $lead->phone,
            'phonecode'    => $lead->phonecode ?? '+91',
            'email'        => $lead->email ?? '',
            'address'      => $lead->notes ?? '',
            'address_full' => $fullAddress,
            'country'      => strtolower(optional($lead->countries)->name ?? ''),
            'state'        => strtolower(optional($lead->states)->name ?? ''),
        ];
    }
    public function searchKulvriksh(Request $request)
    {
        $q = $request->get('q', '');

        $clients = \App\Models\Client::where('kulvrisk_id', 'like', '%' . $q . '%')
            ->with('lead')
            ->limit(10)
            ->get()
            ->map(function ($client) {
                return [
                    'id'          => $client->id,
                    'kulvrisk_id' => $client->kulvrisk_id,
                    'name'        => trim(
                        ($client->lead->first_name ?? '') . ' ' .
                        ($client->lead->last_name  ?? '')
                    ),
                ];
            });

        return response()->json($clients);
    }
}
