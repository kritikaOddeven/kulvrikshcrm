@extends('admin.layouts.app')
@section('pagetitle', 'Edit Bill | Kulvriksh')
@section('admin-content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">Edit Bill</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="" class="text-muted">Bill</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('admin/bills') }}" class="text-muted">View All Bills</a></li>
                <li class="breadcrumb-item active">Edit Bill</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <form action="{{ url('admin/bills/update') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <!-- Top Section -->
                        <input type="hidden" name="id" value="{{ $bills->id }}">
                        <div class="row mb-3">
                            <div class="col-lg-4 col-md-6 mb-2">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" id="name" class="form-control" name="name" value="{{ !empty($bills->name) ? $bills->name : trim((optional($bills->client->lead)->first_name ?? '') . ' ' . (optional($bills->client->lead)->middle_name ?? '') . ' ' . (optional($bills->client->lead)->last_name ?? '')) }}">
                             <span class="text-danger">
                                                @error('name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-2">
                                <label class="form-label">Create Date</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control basic-datepicker pe-5" name="created_at" id="created_at" value="{{ $bills->created_at }}" required placeholder="dd-mm-yyyy">
                                    <i class="ri-calendar-2-line calendar-icon"></i>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-2">
                                <label class="form-label">Kulvriksh ID</label>
                                <input type="text" class="form-control" value="{{ $bills->client->kulvrisk_id }}" readonly>
                            </div>

                        </div>

                        <!-- GST and Recipient Info -->
                        <div class="row mb-3">
                            <div class="col-lg-4 col-md-6 mb-2">
                                <label class="form-label">Phone No</label>
                                <div class="input-group">
                                    <input type="hidden" name="phonecode" id="phonecode_hidden" value="+91">
                                    <span class="input-group-text" id="phonecode_display">+91</span>
                                    <input type="text" class="form-control" name="phone" id="phone_field"
                                     maxlength="10" value="{{ $bills->client->lead->phone ?? '' }}"
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                           placeholder="Enter phone number">
                                    <span class="input-group-text" id="phone_spinner" style="display:none;">
                                        <span class="spinner-border spinner-border-sm text-secondary"></span>
                                    </span>
                                </div>
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 mb-2">
                                <label class="form-label">Invoice No</label>
                                 <input type="text" class="form-control" value="{{ $bills->invoice_number }}" readonly>
                            </div>
                              <div class="col-lg-4 col-md-6 mb-2">
                                <label for="validationDefault01" class="form-label">Email </label>
                                <input type="email" class="form-control" value="{{ $bills->client->lead->email ?? '' }}" name="email" id="email_field">
                                <span class="text-danger">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </span>
                             </div>
                            

                            

                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4 col-md-6 mb-2">
                                <label class="form-label">Type</label>
                                <select class="form-select" name="type">
                                    <option @if ($bills->type == 'tax_invoice') selected @endif value="tax_invoice">Tax Invoice</option>
                                    <option @if ($bills->type == 'proformance_invoice') selected @endif value="proformance_invoice">Proformance_invoice</option>
                                    
                                </select>
                            </div>

                            <div class="col-lg-4 col-md-12 mb-2">
                                <label class="form-label">Payment Terms</label>
                                <input type="text" class="form-control" name="payment_terms" value="{{ $bills->payment_terms ?? 'Immediate' }}" placeholder="Enter payment terms">
                            </div>
                             <div class="col-lg-4 col-md-6 mb-2">
                                            <label for="validationDefault04" class="form-label">Payment Mode <x-required-star /></label>
                                            <select class="form-select" id="payment_mode" name="payment_mode">
                                                <option disabled {{ empty($bills->payment_mode) ? 'selected' : '' }}>Select Mode</option>
                                                <option value="neft"   {{ $bills->payment_mode == 'neft'   ? 'selected' : '' }}>NEFT</option>
                                                <option value="dbf"    {{ $bills->payment_mode == 'dbf'    ? 'selected' : '' }}>Direct Bank Transfer</option>
                                                <option value="cheque" {{ $bills->payment_mode == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                                <option value="upi"    {{ $bills->payment_mode == 'upi'    ? 'selected' : '' }}>UPI</option>
                                                <option value="credit" {{ $bills->payment_mode == 'credit' ? 'selected' : '' }}>Credit Card</option>
                                                <option value="debit"  {{ $bills->payment_mode == 'debit'  ? 'selected' : '' }}>Debit Card</option>
                                                <option value="cash"   {{ $bills->payment_mode == 'cash'   ? 'selected' : '' }}>Cash</option>
                                                <option value="razorpay"   {{ $bills->payment_mode == 'razorpay'   ? 'selected' : '' }}>Razorpay</option>
                                                <option value="stripe"   {{ $bills->payment_mode == 'stripe'   ? 'selected' : '' }}>Stripe</option>
                                                <option value="op"   {{ $bills->payment_mode == 'op'   ? 'selected' : '' }}>Online Payment</option>
                                                <option value="pp"   {{ $bills->payment_mode == 'pp'   ? 'selected' : '' }}>Pending Payment</option>
                                            </select>
                                            <span class="text-danger">
                                                @error('payment_mode')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                        </div>

                        </div>
                        <div class="row mb-3">


                            <div class="col-md-6">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" name="address" value="{{ $bills->client->lead->notes ?? '' }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Address</label> <small class="text-danger">(This field is not editable.)</small>
                                <input type="text" readonly class="form-control" value="{{ implode(', ', array_filter([$bills->client->lead->villages->name ?? null, $bills->client->lead->talukas->name ?? null, $bills->client->lead->districts->name ?? null, $bills->client->lead->states->name ?? null])) }}">
                            </div>
                        </div>

                        <!-- Select Bank -->
                        <div class="row mb-3">
                            <div class="col-lg-4 col-md-6 mb-2">
                                <label class="form-label">Select Bank <span class="text-danger">*</span></label>
                                <select class="form-select" name="bank_account_id" id="bank_account_id" required>
                                    <option value="">Select Bank</option>
                                    @foreach ($bankAccounts as $account)
                                        <option value="{{ $account->id }}" @if (optional($bills->bankAccount)->id == $account->id) selected @endif>
                                            {{ $account->account_holder_name ?? $account->bank_name }} - {{ $account->account_number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-2">
                                <label class="form-label">GST Number</label>
                                <input type="text" class="form-control" placeholder="Enter Gst Number" name="gst_number" value="{{ $bills->gst_number }}">
                            </div>
                            <div class="col-lg-4 col-md-6 mb-2">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" name="status" id="bill_status">
                                    <option value="paid" {{ $bills->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="cancel" {{ $bills->status == 'cancel' ? 'selected' : '' }}>Cancel</option>
                                </select>
                            </div>

                                <div class="col-lg-8 col-md-12 mb-2" id="cancel_reason_box" 
                                    style="{{ $bills->status == 'cancel' ? 'display:block;' : 'display:none;' }}">                                <label class="form-label">Cancel Reason <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="cancel_reason" id="cancel_reason" rows="2">{{ $bills->cancel_reason ?? '' }}</textarea>
                            </div>
                        </div>

                        <!-- Services table -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h5 class="view-edit-sertitle">Services</h5>
                                @php
                                    $hasExistingServices = count($serviceRows) > 0;
                                @endphp
                                <div class="table-responsive">
                                    <table class="table bill-viewtable" id="editBillServicesTable">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Project Name </span></th>
                                                <th>Sub Project Name </span></th>
                                                <th>HSN</th>
                                                <th>Qty</th>
                                                <th class="text-center">Total Amount</th>
                                                <th class="text-end" style="width: 100px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="editBillServicesTbody">
                                            @if ($hasExistingServices)
                                                @foreach ($serviceRows as $index => $row)
                                                    <tr class="dynamic-service-row" data-index="{{ $index }}">
                                                        <td>
                                                            <select class="form-select form-select-sm edit-project-select" name="project_ids[]" data-index="{{ $index }}" data-project-id="{{ $row['project_id'] ?? '' }}" data-selected-id="{{ $row['sub_project_id'] ?? '' }}">
                                                                <option value="">Select Project</option>
                                                                @foreach ($parentProjects as $p)
                                                                    <option value="{{ $p->id }}" @if (($row['project_id'] ?? 0) == $p->id) selected @endif>{{ $p->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-select form-select-sm edit-subproject-select" name="sub_project_ids[]" data-index="{{ $index }}" data-project-id="{{ $row['project_id'] ?? '' }}" data-selected-id="{{ $row['sub_project_id'] ?? '' }}">
                                                                <option value="">Select Sub Project</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm" name="hsn[]" placeholder="Enter HSN" value="{{ $row['hsn'] ?? '' }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control form-control-sm" name="qty[]" placeholder="Enter Qty" value="{{ $row['qty'] ?? '' }}">
                                                        </td>
                                                        <td class="text-center align-middle service-amount">—</td>
                                                        <td class="text-end align-middle">
                                                            <button type="button" class="btn btn-sm btn-danger btn-remove-service-row" title="Delete row"><i class="ri-delete-bin-line"></i></button>
                                                        </td>
                                                    </tr>
                                                    <tr class="dynamic-service-detail-row" data-index="{{ $index }}">
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm" name="service_name[]" placeholder="Enter Services Name" value="{{ $row['service_name'] ?? '' }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm" name="description[]" placeholder="Enter Description" value="{{ $row['description'] ?? '' }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm" name="hsn_detail[]" placeholder="Enter HSN" value="{{ $row['hsn_detail'] ?? '' }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control form-control-sm" name="qty_detail[]" pattern="[0-9]*" inputmode="numeric" placeholder="Enter Qty" value="{{ $row['qty_detail'] ?? '' }}">
                                                        </td>
                                                        <td colspan="2">
                                                            <input type="text" class="form-control form-control-sm" name="service_amount[]" placeholder="Enter Services Amount" value="{{ $row['service_amount'] ?? '' }}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="dynamic-service-row" data-index="0">
                                                    <td>
                                                        <select class="form-select form-select-sm edit-project-select" name="project_ids[]" data-index="0">
                                                            <option value="">Select Project</option>
                                                            @foreach ($parentProjects as $p)
                                                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-select form-select-sm edit-subproject-select" name="sub_project_ids[]" data-index="0" disabled>
                                                            <option value="">Select Sub Project</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" name="hsn[]" placeholder="Enter HSN">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm" name="qty[]" placeholder="Enter Qty">
                                                    </td>
                                                    <td class="text-center align-middle service-amount">—</td>
                                                    <td class="text-end align-middle">
                                                        <button type="button" class="btn btn-sm btn-danger btn-remove-service-row" title="Delete row" style="display: none;"><i class="ri-delete-bin-line"></i></button>
                                                    </td>
                                                </tr>
                                                <tr class="dynamic-service-detail-row" data-index="0">
                                                    <td><input type="text" class="form-control form-control-sm" name="service_name[]" placeholder="Enter Services Name"></td>
                                                    <td><input type="text" class="form-control form-control-sm" name="description[]" placeholder="Enter Description"></td>
                                                    <td><input type="text" class="form-control form-control-sm" name="hsn_detail[]" placeholder="Enter HSN"></td>
                                                    <td><input type="number" class="form-control form-control-sm" name="qty_detail[]" placeholder="Enter Qty"></td>
                                                    <td colspan="2"><input type="text" class="form-control form-control-sm" name="service_amount[]" placeholder="Enter Services Amount"></td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-2">
                                    <button type="button" id="editBillAddMore" class="btn btn-sm btn-primary">+ Add More</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-md-12 mb-2">
                                <div class="p-3 bg-light rounded">
                                    <h5 class="form-label">Notes :</h5>
                                    <ul class="bill-note-ul">
                                        <li>Payment is due within 30 days from the date of the invoice.</li>
                                        <li>Please make payment to the following bank account</li>
                                    </ul>
                                    <!-- <div class="bank-details-box">
                                        <p><span>Bank:</span> {{ $bills->bankAccount->bank_name ?? 'N/A' }}</p>
                                        <p><span>Account No:</span> {{ $bills->bankAccount->account_number ?? 'N/A' }}</p>
                                        <p><span>Account Holder:</span> {{ $bills->bankAccount->account_holder_name ?? 'N/A' }}</p>
                                        <p><span>Branch:</span> {{ $bills->bankAccount->branch ?? 'N/A' }}</p>
                                    </div> -->
                                    <div class="bank-details-box">
                                        <p><span>Bank:</span> <span id="previewBankName">{{ $bills->bankAccount->bank_name ?? 'N/A' }}</span></p>
                                        <p><span>Account No:</span> <span id="previewAccountNo">{{ $bills->bankAccount->account_number ?? 'N/A' }}</span></p>
                                        <p><span>Account Holder:</span> <span id="previewAccountHolder">{{ $bills->bankAccount->account_holder_name ?? 'N/A' }}</span></p>
                                        <p><span>Branch:</span> <span id="previewBranch">{{ $bills->bankAccount->branch ?? 'N/A' }}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12 mb-2">
                                <div class="subtotal-box">
                                    <table class="table table-sm text-nowrap mb-0">
                                        <!-- <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                        <span class="title">Sub-total :</span>
                                                        <span class="total-number" id="edit-bill-subtotal">₹{{ number_format($bills->amount, 2) }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                        <span class="title">CGST<span class="text-danger">(9%)</span> :</span>
                                                        <span class="total-number" id="edit-bill-cgst">₹{{ number_format($bills->amount * 0.09, 2) }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                        <span class="title">SGST<span class="text-danger">(9%)</span> :</span>
                                                        <span class="total-number" id="edit-bill-sgst">₹{{ number_format($bills->amount * 0.09, 2) }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                        <span class="total-title">Total Amount :</span>
                                                        <span class="total-title" id="edit-bill-total">₹{{ number_format($bills->amount + $bills->amount * 0.18, 2) }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody> -->
                                          <!-- mansi addd -->
                                         @php
                                            $clientCountry = strtolower(optional($bills->client->lead->countries)->name ?? '');
                                            $clientState   = strtolower(optional($bills->client->lead->states)->name ?? '');
                                            $isIndia       = $clientCountry === 'india';
                                            $isGujarat     = $isIndia && $clientState === 'gujarat';
                                            $subAmt        = $bills->amount;
                                            $cgstAmt       = $isGujarat ? $subAmt * 0.09 : 0;
                                            $sgstAmt       = $isGujarat ? $subAmt * 0.09 : 0;
                                            $igstAmt       = ($isIndia && !$isGujarat) ? $subAmt * 0.18 : 0;
                                            $totalAmt      = $subAmt + $cgstAmt + $sgstAmt + $igstAmt;
                                        @endphp
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                        <span class="title">Sub-total :</span>
                                                        <span class="total-number" id="edit-bill-subtotal">₹{{ number_format($subAmt, 2) }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr id="edit-cgst-row" @if(!$isGujarat) style="display:none;" @endif>
                                                <td>
                                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                        <span class="title">CGST <span class="text-danger">(9%)</span> :</span>
                                                        <span class="total-number" id="edit-bill-cgst">₹{{ number_format($cgstAmt, 2) }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr id="edit-sgst-row" @if(!$isGujarat) style="display:none;" @endif>
                                                <td>
                                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                        <span class="title">SGST <span class="text-danger">(9%)</span> :</span>
                                                        <span class="total-number" id="edit-bill-sgst">₹{{ number_format($sgstAmt, 2) }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr id="edit-igst-row" @if(!($isIndia && !$isGujarat)) style="display:none;" @endif>
                                                <td>
                                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                        <span class="title">IGST <span class="text-danger">(18%)</span> :</span>
                                                        <span class="total-number" id="edit-bill-igst">₹{{ number_format($igstAmt, 2) }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                        <span class="total-title">Total Amount :</span>
                                                        <span class="total-title" id="edit-bill-total">₹{{ number_format($totalAmt, 2) }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ url('admin/bills') }}" type="button" class="btn btn-light">Cancel</a>
                        <!-- <button type="submit" class="btn btn-primary">Update</button> -->
                         <button type="button" class="btn btn-primary" id="updateBillBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script>
document.getElementById('updateBillBtn').addEventListener('click', function() {
    let isValid = true;

    // Previous errors remove
    document.querySelectorAll('.js-error').forEach(el => el.remove());
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

    // 1. Payment Mode
    const paymentMode = document.getElementById('payment_mode').value;
    if (!paymentMode || paymentMode === 'Select Mode') {
        isValid = false;
        const el = document.getElementById('payment_mode');
        el.classList;
        el.insertAdjacentHTML('afterend', '<span class="text-danger js-error">Payment mode is required.</span>');
    }
    const clientName = document.getElementById('name').value.trim();
    if (!clientName) {
        isValid = false;
        const el = document.getElementById('name');
        el.classList;
        el.insertAdjacentHTML('afterend', '<span class="text-danger js-error">Client Name is required.</span>');
    }

    // 2. Bank Account
    const bankAccount = document.getElementById('bank_account_id').value;
    if (!bankAccount) {
        isValid = false;
        const el = document.getElementById('bank_account_id');
        el.classList;
        el.insertAdjacentHTML('afterend', '<span class="text-danger js-error">Please select a bank account.</span>');
    }
    //mansi add
      const status = document.getElementById('bill_status').value;
    const reason = document.getElementById('cancel_reason').value.trim();

    if (status === 'cancel' && !reason) {
        isValid = false;

        document.getElementById('cancel_reason')
            .insertAdjacentHTML('afterend', '<span class="text-danger js-error">Cancel reason is required.</span>');
    }


  let hasProject = false;
let hasService = false;


document.querySelectorAll('#editBillServicesTbody .dynamic-service-row').forEach(function(row) {
    const projectVal = row.querySelector('.edit-project-select')?.value;

    if (projectVal) {
        hasProject = true;
    }
});


document.querySelectorAll('#editBillServicesTbody .dynamic-service-detail-row').forEach(function(row) {
    const serviceName = row.querySelector('input[name="service_name[]"]')?.value.trim();
    const amount      = row.querySelector('input[name="service_amount[]"]')?.value.trim();

    if (serviceName || amount) {
        hasService = true;
    }
});


if (!hasProject && !hasService) {
    isValid = false;

    const existingErr = document.getElementById('service-table-error');

    if (!existingErr) {
        document.querySelector('#editBillServicesTbody').closest('.table-responsive')
            .insertAdjacentHTML('beforebegin',
                '<span class="text-danger js-error" id="service-table-error">Please add at least one Project OR Service.</span>'
            );
    }
}
    if (isValid) {
        document.querySelector('form').submit();
    } else {
        const firstError = document.querySelector('.is-invalid');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
});

// Real-time error clear
['payment_mode', 'bank_account_id', 'name'].forEach(function(id) {
    const el = document.getElementById(id);
    if (el) {
        el.addEventListener('change', function() {
            this.classList.remove('is-invalid');
            const next = this.nextElementSibling;
            if (next && next.classList.contains('js-error')) next.remove();
        });
    }
});

// Project/SubProject real-time error clear
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('edit-project-select') ||
        e.target.classList.contains('edit-subproject-select')) {
        e.target.classList.remove('is-invalid');
        const next = e.target.nextElementSibling;
        if (next && next.classList.contains('js-error')) next.remove();

        const tableErr = document.getElementById('service-table-error');
        if (tableErr) tableErr.remove();
    }
});
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('edit-project-select') || 
        e.target.classList.contains('edit-subproject-select')) {

        let row = e.target.closest('tr.dynamic-service-row');
        let qtyInput = row?.querySelector('input[name="qty[]"]');

        if (qtyInput && !qtyInput.value) {
            qtyInput.value = 1;
        }
    }
});
document.addEventListener('input', function(e) {
    if (e.target.name === 'service_name[]' || e.target.name === 'description[]') {

        let row = e.target.closest('tr.dynamic-service-detail-row');
        let qtyInput = row?.querySelector('input[name="qty_detail[]"]');

        if (qtyInput && !qtyInput.value) {
            qtyInput.value = 1;
        }
    }
});

</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const parentProjects = @json($parentProjects);
    const bankAccounts   = @json($bankAccounts); 
    let editServiceRowIndex = {{ $hasExistingServices ? count($serviceRows) : 1 }};
       //mansi add
    const clientCountry = '{{ strtolower(optional($bills->client->lead->countries)->name ?? '') }}';
    const clientState   = '{{ strtolower(optional($bills->client->lead->states)->name ?? '') }}';
    //end

    function buildProjectOptions() {
        return parentProjects.map(function(p) {
            return '<option value="' + p.id + '">' + p.name + '</option>';
        }).join('');
    }

    function formatRupee(n) {
        return '₹' + (Number(n) || 0).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    document.getElementById('bank_account_id').addEventListener('change', function () {
        const account = bankAccounts.find(acc => acc.id == this.value);
        document.getElementById('previewBankName').textContent      = account?.bank_name           || '—';
        document.getElementById('previewAccountNo').textContent     = account?.account_number      || '—';
        document.getElementById('previewAccountHolder').textContent = account?.account_holder_name || '—';
        document.getElementById('previewBranch').textContent        = account?.branch              || '—';
    });
    // ── Project row amount cell update ────────────────────────────────────────
    function updateRowAmount(row) {
        const subSelect  = row.querySelector('.edit-subproject-select');
        const qtyInput   = row.querySelector('input[name="qty[]"]');
        const amountCell = row.querySelector('.service-amount');
        if (!amountCell) return;
        const unitPrice = subSelect && subSelect.selectedOptions[0]?.dataset?.amount
            ? parseFloat(subSelect.selectedOptions[0].dataset.amount) : 0;
        const qty       = qtyInput && qtyInput.value ? parseFloat(qtyInput.value) : 1;
        const lineTotal = unitPrice * qty;
        amountCell.textContent = lineTotal > 0 ? formatRupee(lineTotal) : '—';
    }

    // ── Summary totals ────────────────────────────────────────────────────────
    // function updateSummaryTotals() {
    //     let subTotal = 0;

    //     // Project rows: subproject unit price × qty
    //     document.querySelectorAll('tr.dynamic-service-row').forEach(function(row) {
    //         const subSelect = row.querySelector('.edit-subproject-select');
    //         const qtyInput  = row.querySelector('input[name="qty[]"]');
    //         const unitPrice = subSelect && subSelect.selectedOptions[0]?.dataset?.amount
    //             ? parseFloat(subSelect.selectedOptions[0].dataset.amount) : 0;
    //         const qty = qtyInput && qtyInput.value ? parseFloat(qtyInput.value) : 1;
    //         subTotal += unitPrice * qty;
    //     });

    //     // Detail rows: service_amount already = base × qty (direct value)
    //     document.querySelectorAll('tr.dynamic-service-detail-row').forEach(function(row) {
    //         const amountInput = row.querySelector('input[name="service_amount[]"]');
    //         const val = amountInput && amountInput.value
    //             ? parseFloat(amountInput.value.replace(/[^0-9.]/g, '')) || 0 : 0;
    //         subTotal += val;
    //     });

    //     const cgst  = subTotal * 0.09;
    //     const sgst  = subTotal * 0.09;
    //     const total = subTotal + cgst + sgst;

    //     document.getElementById('edit-bill-subtotal').textContent = formatRupee(subTotal);
    //     document.getElementById('edit-bill-cgst').textContent     = formatRupee(cgst);
    //     document.getElementById('edit-bill-sgst').textContent     = formatRupee(sgst);
    //     document.getElementById('edit-bill-total').textContent    = formatRupee(total);
    // }
    //mansi add
    function updateSummaryTotals() {
        let subTotal = 0;

        document.querySelectorAll('tr.dynamic-service-row').forEach(function(row) {
            const subSelect = row.querySelector('.edit-subproject-select');
            const qtyInput  = row.querySelector('input[name="qty[]"]');
            const unitPrice = subSelect && subSelect.selectedOptions[0]?.dataset?.amount
                ? parseFloat(subSelect.selectedOptions[0].dataset.amount) : 0;
            const qty = qtyInput && qtyInput.value ? parseFloat(qtyInput.value) : 1;
            subTotal += unitPrice * qty;
        });

        document.querySelectorAll('tr.dynamic-service-detail-row').forEach(function(row) {
            const amountInput = row.querySelector('input[name="service_amount[]"]');
            const val = amountInput && amountInput.value
                ? parseFloat(amountInput.value.replace(/[^0-9.]/g, '')) || 0 : 0;
            subTotal += val;
        });

        const isIndia   = clientCountry === 'india';
        const isGujarat = isIndia && clientState === 'gujarat';

        let cgst = 0, sgst = 0, igst = 0;

        if (isIndia) {
            if (isGujarat) {
                cgst = subTotal * 0.09;
                sgst = subTotal * 0.09;
            } else {
                igst = subTotal * 0.18;
            }
        }

        const total = subTotal + cgst + sgst + igst;

        document.getElementById('edit-bill-subtotal').textContent = formatRupee(subTotal);
        document.getElementById('edit-bill-cgst').textContent     = formatRupee(cgst);
        document.getElementById('edit-bill-sgst').textContent     = formatRupee(sgst);
        document.getElementById('edit-bill-igst').textContent     = formatRupee(igst);
        document.getElementById('edit-bill-total').textContent    = formatRupee(total);

        const cgstRow = document.getElementById('edit-cgst-row');
        const sgstRow = document.getElementById('edit-sgst-row');
        const igstRow = document.getElementById('edit-igst-row');
        if (cgstRow) cgstRow.style.display = isGujarat ? '' : 'none';
        if (sgstRow) sgstRow.style.display = isGujarat ? '' : 'none';
        if (igstRow) igstRow.style.display = (isIndia && !isGujarat) ? '' : 'none';
    }

    function toggleRowDeleteButtons() {
        const rows = document.querySelectorAll('.dynamic-service-row');
        const showDelete = rows.length > 1;
        rows.forEach(function(row) {
            const btn = row.querySelector('.btn-remove-service-row');
            if (btn) btn.style.display = showDelete ? '' : 'none';
        });
    }

    function loadSubprojects(projectId, subSelect, selectedId, currentRow) {
        if (!projectId) {
            subSelect.innerHTML = '<option value="">Select Sub Project</option>';
            subSelect.disabled  = true;
            if (currentRow) updateRowAmount(currentRow);
            updateSummaryTotals();
            return;
        }
        fetch('{{ url("admin/get-subprojects") }}/' + projectId, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(function(r) { return r.json(); })
        .then(function(subprojects) {
            let html = '<option value="">Select Sub Project</option>';
            subprojects.forEach(function(sub) {
                const sel = (selectedId && sub.id == selectedId) ? ' selected' : '';
                html += '<option value="' + sub.id + '" data-amount="' + (sub.amount || 0) + '"' + sel + '>' + sub.name + '</option>';
            });
            subSelect.innerHTML = html;
            subSelect.disabled  = false;
            if (selectedId) subSelect.value = selectedId;
            subSelect.removeAttribute('data-project-id');
            subSelect.removeAttribute('data-selected-id');
            if (currentRow) updateRowAmount(currentRow);
            updateSummaryTotals();
        })
        .catch(function() {
            subSelect.innerHTML = '<option value="">Error loading subprojects</option>';
            subSelect.disabled  = true;
            updateSummaryTotals();
        });
    }

    function refreshOtherRowsSubprojects(exceptRow) {
        document.querySelectorAll('.dynamic-service-row').forEach(function(row) {
            if (row === exceptRow) return;
            const projectSelect = row.querySelector('.edit-project-select');
            const subSelect     = row.querySelector('.edit-subproject-select');
            const projectId     = projectSelect && projectSelect.value;
            if (projectId && subSelect && !subSelect.disabled) {
                const currentVal = subSelect.value;
                loadSubprojects(projectId, subSelect, currentVal || null, row);
            }
        });
    }

    // ── Page load: populate subproject dropdowns ──────────────────────────────
    document.querySelectorAll('.edit-subproject-select[data-project-id][data-selected-id]').forEach(function(subSelect) {
        const projectId  = subSelect.getAttribute('data-project-id');
        const selectedId = subSelect.getAttribute('data-selected-id');
        const row        = subSelect.closest('tr.dynamic-service-row');
        if (projectId && selectedId) loadSubprojects(projectId, subSelect, selectedId, row);
    });

    // ── Page load: set data-base for existing service_amount inputs ───────────
 document.querySelectorAll('tr.dynamic-service-detail-row').forEach(function(row) {
    const amountInput = row.querySelector('input[name="service_amount[]"]');
    const qtyInput    = row.querySelector('input[name="qty_detail[]"]');

    if (amountInput && amountInput.value) {
        const amount = parseFloat(amountInput.value) || 0;
        const qty    = qtyInput && qtyInput.value ? parseFloat(qtyInput.value) : 1;

        // ✅ Correct base calculation
        amountInput.dataset.base = qty > 0 ? (amount / qty) : amount;
    }
});
    // ── Unified input listener ────────────────────────────────────────────────
    document.addEventListener('input', function(e) {

        // Project row qty → update amount cell
        if (e.target.name === 'qty[]') {
            const row = e.target.closest('tr.dynamic-service-row');
            if (row) { updateRowAmount(row); updateSummaryTotals(); }
        }

        // Detail row qty → auto update service_amount (base × qty)
        if (e.target.name === 'qty_detail[]') {
            const row = e.target.closest('tr.dynamic-service-detail-row');
            if (!row) return;
            const amountInput = row.querySelector('input[name="service_amount[]"]');
            if (!amountInput) return;
            if (!amountInput.dataset.base) {
    const currentAmount = parseFloat(amountInput.value) || 0;
    const currentQty    = parseFloat(e.target.value) || 1;

    amountInput.dataset.base = currentQty > 0 ? (currentAmount / currentQty) : currentAmount;
}
            const baseAmount  = parseFloat(amountInput.dataset.base) || 0;
            const qty         = parseFloat(e.target.value) || 1;
            amountInput.value = (baseAmount * qty).toFixed(2);
            updateSummaryTotals();
        }

        // Service amount manually typed → reset base & update summary
        if (e.target.name === 'service_amount[]') {
            e.target.dataset.base = e.target.value;
            updateSummaryTotals();
        }
    });

    // ── Change listener ───────────────────────────────────────────────────────
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('edit-project-select')) {
            const row       = e.target.closest('tr.dynamic-service-row');
            const subSelect = row && row.querySelector('.edit-subproject-select');
            if (subSelect) loadSubprojects(e.target.value, subSelect, null, row);
        }
        if (e.target.classList.contains('edit-subproject-select')) {
            const row = e.target.closest('tr.dynamic-service-row');
            if (row) { updateRowAmount(row); updateSummaryTotals(); }
            refreshOtherRowsSubprojects(e.target.closest('tr.dynamic-service-row'));
        }
    });

    // ── Add More ──────────────────────────────────────────────────────────────
    document.getElementById('editBillAddMore').addEventListener('click', function() {
        const tbody = document.getElementById('editBillServicesTbody');
        const tr    = document.createElement('tr');
        tr.className = 'dynamic-service-row';
        tr.setAttribute('data-index', editServiceRowIndex);
        tr.innerHTML =
            '<td><select class="form-select form-select-sm edit-project-select" name="project_ids[]" data-index="' + editServiceRowIndex + '"><option value="">Select Project</option>' + buildProjectOptions() + '</select></td>' +
            '<td><select class="form-select form-select-sm edit-subproject-select" name="sub_project_ids[]" data-index="' + editServiceRowIndex + '" disabled><option value="">Select Sub Project</option></select></td>' +
            '<td><input type="text" class="form-control form-control-sm" name="hsn[]" placeholder="Enter HSN"></td>' +
            '<td><input type="number" class="form-control form-control-sm" name="qty[]" placeholder="Enter Qty" min="1"></td>' +
            '<td class="text-center align-middle service-amount">—</td>' +
            '<td class="text-end align-middle"><button type="button" class="btn btn-sm btn-danger btn-remove-service-row" title="Delete row"><i class="ri-delete-bin-line"></i></button></td>';
        const tr2 = document.createElement('tr');
        tr2.className = 'dynamic-service-detail-row';
        tr2.setAttribute('data-index', editServiceRowIndex);
        tr2.innerHTML =
            '<td><input type="text" class="form-control form-control-sm" name="service_name[]" placeholder="Enter Services Name"></td>' +
            '<td><input type="text" class="form-control form-control-sm" name="description[]" placeholder="Enter Description"></td>' +
            '<td><input type="text" class="form-control form-control-sm" name="hsn_detail[]" placeholder="Enter HSN"></td>' +
            '<td><input type="number" class="form-control form-control-sm" name="qty_detail[]" placeholder="Enter Qty" min="1"></td>' +
            '<td colspan="2"><input type="text" class="form-control form-control-sm" name="service_amount[]" placeholder="Enter Services Amount"></td>';
        tbody.appendChild(tr);
        tbody.appendChild(tr2);
        editServiceRowIndex++;
        toggleRowDeleteButtons();
    });

    // ── Delete row ────────────────────────────────────────────────────────────
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.btn-remove-service-row')) return;
        e.preventDefault();
        const row  = e.target.closest('tr.dynamic-service-row');
        if (!row) return;
        const rows = document.querySelectorAll('tr.dynamic-service-row');
        if (rows.length <= 1) return;
        const nextRow = row.nextElementSibling;
        row.remove();
        if (nextRow) nextRow.remove();
        toggleRowDeleteButtons();
        refreshOtherRowsSubprojects(null);
        updateSummaryTotals();
    });

    // ── Init ──────────────────────────────────────────────────────────────────
    toggleRowDeleteButtons();
    document.querySelectorAll('tr.dynamic-service-row').forEach(updateRowAmount);
    updateSummaryTotals();


    //mansi add
    function toggleCancelReason() {
    const status = document.getElementById('bill_status').value;
    const box = document.getElementById('cancel_reason_box');

    box.style.display = (status === 'cancel') ? 'block' : 'none';
        }

        // Page load
        document.addEventListener('DOMContentLoaded', function () {
            toggleCancelReason();
        });

        // On change
        document.getElementById('bill_status').addEventListener('change', toggleCancelReason);
        
});
</script>
@endpush