<?php $__env->startSection('pagetitle', 'Create Bill | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">Create Bill</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="" class="text-muted">Bill</a></li>
                <li class="breadcrumb-item active"><a href="<?php echo e(url('admin/bills')); ?>" class="text-muted">View All Bills</a></li>
                <li class="breadcrumb-item active">Create Bill</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <form action="<?php echo e(url('admin/bills/store')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="client_id" id="client_id_field">
                    <input type="hidden" id="client_country" value="">
                    <input type="hidden" id="client_state" value="">
                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col-lg-4 col-md-6 mb-2">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="name_field"
                                       value="<?php echo e(old('name')); ?>">
                                       
                            </div>

                            <div class="col-lg-4 col-md-6 mb-2">
                                <label class="form-label">Create Date</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control  pe-5"
                                           name="created_at" id="created_at" value="<?php echo e(old('created_at', now()->format('d-m-Y'))); ?>"
                                           placeholder="dd-mm-yyyy">
                                    <i class="ri-calendar-2-line calendar-icon"></i>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-2">
                                <label class="form-label">Kulvriksh ID <span class="text-danger">*</span></label>
                                <input type="hidden" name="kulvrisk_id" id="kulvrisk_id">
                                <div class="position-relative" id="kulvriksh_wrapper">
                                    <input type="text"
                                        class="form-control"
                                        id="kulvrisk_search"
                                        placeholder="Search Kulvriksh ID..."
                                        autocomplete="off">
                                    <span id="kulvriksh_spinner" class="position-absolute top-50 end-0 translate-middle-y pe-2" style="display:none;">
                                        <span class="spinner-border spinner-border-sm text-secondary"></span>
                                    </span>
                                    <div id="kulvriksh_dropdown"
                                        class="position-absolute w-100 bg-white border rounded shadow-sm"
                                        style="display:none; max-height:220px; overflow-y:auto; z-index:9999; top:100%;">
                                        
                                    </div>
                                    <?php $__errorArgs = ['client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-2">
                                <label class="form-label">Phone No</label>
                                <div class="input-group">
                                    <input type="hidden" name="phonecode" id="phonecode_hidden" value="+91">
                                    <span class="input-group-text" id="phonecode_display">+91</span>
                                    <input type="text" class="form-control" name="phone" id="phone_field"
                                           maxlength="10" value="<?php echo e(old('phone')); ?>"
                                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                           placeholder="Enter phone number">
                                    <span class="input-group-text" id="phone_spinner" style="display:none;">
                                        <span class="spinner-border spinner-border-sm text-secondary"></span>
                                    </span>
                                </div>
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-2">
                                <label class="form-label">Invoice No</label>
                                <input type="text" class="form-control" name="invoice_number"
                                        value="<?php echo e(generate_invoice_number()); ?>" readonly>
                            </div>
                      

                            <div class="col-lg-4 col-md-6 mb-2">
                                <label for="validationDefault01" class="form-label">Email </label>
                                <input type="email" class="form-control" value="" name="email" id="email_field">
                                <span class="text-danger">
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <?php echo e($message); ?>

                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </span>
                             </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-4 col-md-6 mb-2">
                                <label class="form-label">Type</label>
                                <select class="form-select" name="type">
                                    <option value="tax_invoice" <?php echo e(old('type')==='tax_invoice'?'selected':''); ?>>Tax Invoice</option>
                                    <option value="proformance_invoice" <?php echo e(old('type')==='proformance_invoice'?'selected':''); ?>>Proformance Invoice</option>
                                    
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-6 mb-2">
                                <label class="form-label">Payment Terms</label>
                                <input type="text" class="form-control" name="payment_terms"
                                       value="<?php echo e(old('payment_terms')); ?>" placeholder="Enter payment terms">
                            </div>
                            <div class="col-lg-4 col-md-6 mb-2">
                                            <label for="validationDefault04" class="form-label">Payment Mode <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7 = $attributes; } ?>
<?php $component = App\View\Components\RequiredStar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\RequiredStar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $attributes = $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $component = $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?></label>
                                            <select class="form-select" id="payment_mode" required name="payment_mode">
                                                <option selected disabled>Select Mode</option>
                                                <option value="neft">NEFT</option>
                                                <option value="dbf">Direct Bank Transfer</option>
                                                <option value="cheque">Cheque</option>
                                                <option value="upi">UPI</option>
                                                <option value="credit">Credit Card</option>
                                                <option value="debit">Debit Card</option>
                                                <option value="cash">Cash</option>
                                                <option value="razorpay">Razorpay</option>
                                                <option value="stripe">Stripe</option>
                                                <option value="op">Online Payment</option>
                                                 <option value="pp">Pending Payment</option>
                                            </select>
                                            <span class="text-danger">
                                                <?php $__errorArgs = ['payment_mode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <?php echo e($message); ?>

                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </span>
                                        </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Address / Notes</label>
                                <input type="text" class="form-control" name="address" id="address_notes"
                                       value="<?php echo e(old('address')); ?>" placeholder="Enter address / notes">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Full Address</label>
                                <small class="text-danger">(Auto-filled — not editable)</small>
                                <input type="text" readonly class="form-control bg-light" id="address_full" value="">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Select Bank <span class="text-danger">*</span></label>
                                <select class="form-select" name="bank_account_id" id="bank_account_id" required>
                                    <option value="">Select Bank</option>
                                    <?php $__currentLoopData = $bankAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($account->id); ?>"
                                            <?php echo e(old('bank_account_id') == $account->id ? 'selected' : ''); ?>>
                                            <?php echo e($account->account_holder_name ?? $account->bank_name); ?>

                                            - <?php echo e($account->account_number); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <?php $__errorArgs = ['bank_account_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-danger"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                              <div class="col-md-6">
                                <label class="form-label">GST Number</label>
                                <input type="text" class="form-control" placeholder="Enter GST Number"
                                       name="gst_number" value="">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h5 class="view-edit-sertitle">Services</h5>
                                <div class="table-responsive">
                                    <table class="table bill-viewtable" id="createBillServicesTable">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Project Name </th>
                                                <th>Sub Project Name </th>
                                                <th>HSN</th>
                                                <th>Qty</th>
                                                <th class="text-center">Total Amount</th>
                                                <th class="text-end" style="width:100px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="createBillServicesTbody"></tbody>
                                    </table>
                                </div>
                                <div class="mt-2">
                                    <button type="button" id="addMoreService" class="btn btn-sm btn-primary">+ Add More</button>
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
                                    <div class="bank-details-box" id="bankDetailsPreview">
                                        <p><span>Bank:</span> <span id="previewBankName">—</span></p>
                                        <p><span>Account No:</span> <span id="previewAccountNo">—</span></p>
                                        <p><span>Account Holder:</span> <span id="previewAccountHolder">—</span></p>
                                        <p><span>Branch:</span> <span id="previewBranch">—</span></p>
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
                                                        <span class="total-number" id="subtotal">₹0.00</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                        <span class="title">CGST <span class="text-danger">(9%)</span> :</span>
                                                        <span class="total-number" id="cgst">₹0.00</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                        <span class="title">SGST <span class="text-danger">(9%)</span> :</span>
                                                        <span class="total-number" id="sgst">₹0.00</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                        <span class="total-title">Total Amount :</span>
                                                        <span class="total-title" id="total">₹0.00</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody> -->
                                         <!-- mansi add -->
                                         <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                        <span class="title">Sub-total :</span>
                                                        <span class="total-number" id="subtotal">₹0.00</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr id="cgst-row">
                                                <td>
                                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                        <span class="title">CGST <span class="text-danger">(9%)</span> :</span>
                                                        <span class="total-number" id="cgst">₹0.00</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr id="sgst-row">
                                                <td>
                                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                        <span class="title">SGST <span class="text-danger">(9%)</span> :</span>
                                                        <span class="total-number" id="sgst">₹0.00</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr id="igst-row" style="display:none;">
                                                <td>
                                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                        <span class="title">IGST <span class="text-danger">(18%)</span> :</span>
                                                        <span class="total-number" id="igst">₹0.00</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                        <span class="total-title">Total Amount :</span>
                                                        <span class="total-title" id="total">₹0.00</span>
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
                        <a href="<?php echo e(url('admin/bills')); ?>" class="btn btn-light">Cancel</a>
                        <button type="button" class="btn btn-primary" id="saveBillBtn">Save Bill</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script>

    
document.addEventListener('DOMContentLoaded', function () {

    document.querySelector('form').addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
            e.preventDefault();
        }
    });

    const parentProjects = <?php echo json_encode($parentProjects, 15, 512) ?>;
    const bankAccounts   = <?php echo json_encode($bankAccounts, 15, 512) ?>;
    let   serviceRowIndex = 0;


    function formatRupee(n) {
        return '₹' + (Number(n) || 0).toLocaleString('en-IN', {
            minimumFractionDigits: 2, maximumFractionDigits: 2
        });
    }
    //mansi add
    function clearClientFields() {
        document.getElementById('client_id_field').value          = '';
        document.getElementById('kulvrisk_id').value              = '';
        document.getElementById('kulvrisk_search').value          = '';  // ← this line added
        document.getElementById('name_field').value               = '';
        document.getElementById('email_field').value              = '';
        document.getElementById('phone_field').value              = '';
        document.getElementById('phonecode_display').textContent  = '+91';
        document.getElementById('phonecode_hidden').value         = '+91';
        document.getElementById('address_notes').value            = '';
        document.getElementById('address_full').value             = '';
        document.getElementById('client_country').value           = '';
        document.getElementById('client_state').value             = '';
        updateSummaryTotals();
    }


    // function fillClientFields(data) {
    //     document.getElementById('client_id_field').value         = data.client_id    || '';
    //     document.getElementById('kulvrisk_id').value             = data.kulvrisk_id  || '';
    //     document.getElementById('kulvrisk_search').value         = data.kulvrisk_id  || '';
    //     document.getElementById('name_field').value              = data.name         || '';
    //     document.getElementById('email_field').value             = data.email        || ''; 
    //     document.getElementById('phone_field').value             = data.phone        || '';
    //     document.getElementById('phonecode_display').textContent = data.phonecode    || '+91';
    //     document.getElementById('phonecode_hidden').value        = data.phonecode    || '+91';
    //     document.getElementById('address_notes').value           = data.address      || '';
    //     document.getElementById('address_full').value            = data.address_full || '';
    //     kulvrikshDropdown.style.display = 'none';
    // }
     //mansi add
    function fillClientFields(data) {
    document.getElementById('client_id_field').value         = data.client_id    || '';
    document.getElementById('kulvrisk_id').value             = data.kulvrisk_id  || '';
    document.getElementById('kulvrisk_search').value         = data.kulvrisk_id  || '';
    document.getElementById('name_field').value              = data.name         || '';
    document.getElementById('email_field').value             = data.email        || '';
    document.getElementById('phone_field').value             = data.phone        || '';
    document.getElementById('phonecode_display').textContent = data.phonecode    || '+91';
    document.getElementById('phonecode_hidden').value        = data.phonecode    || '+91';
    document.getElementById('address_notes').value           = data.address      || '';
    document.getElementById('address_full').value            = data.address_full || '';
    document.getElementById('client_country').value          = data.country      || '';
    document.getElementById('client_state').value            = data.state        || '';
    kulvrikshDropdown.style.display = 'none';
    updateSummaryTotals();
}


const kulvrikshSearch   = document.getElementById('kulvrisk_search');
const kulvrikshHidden   = document.getElementById('kulvrisk_id');
const kulvrikshDropdown = document.getElementById('kulvriksh_dropdown');
const kulvrikshSpinner  = document.getElementById('kulvriksh_spinner');
let   isSelectingOption = false;
let   searchTimer       = null;

kulvrikshSearch.addEventListener('input', function () {
    const query = this.value.trim();
    kulvrikshHidden.value = '';
    clearTimeout(searchTimer);

    if (query.length < 1) {
        kulvrikshDropdown.style.display = 'none';
        kulvrikshDropdown.innerHTML = '';
        clearClientFields();
        return;
    }

    // Debounce — 300ms wait
    searchTimer = setTimeout(function () {
        kulvrikshSpinner.style.display = '';
        fetch('<?php echo e(url("admin/bills/search-kulvriksh")); ?>?q=' + encodeURIComponent(query), {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(results => {
            kulvrikshSpinner.style.display = 'none';
            kulvrikshDropdown.innerHTML = '';

            if (!results.length) {
                kulvrikshDropdown.innerHTML = '<div class="px-3 py-2 text-muted">No results found</div>';
                kulvrikshDropdown.style.display = 'block';
                return;
            }

            results.forEach(function (client) {
                const div = document.createElement('div');
                div.className = 'kulvriksh-option px-3 py-2';
                div.style.cursor = 'pointer';
                div.dataset.value    = client.kulvrisk_id;
                div.dataset.clientId = client.id;
                div.innerHTML = '<strong>' + client.kulvrisk_id + '</strong>' +
                    (client.name ? '<small class="text-muted ms-1">— ' + client.name + '</small>' : '');
                div.addEventListener('mouseover', function () { this.style.background = '#f0f0f0'; });
                div.addEventListener('mouseout',  function () { this.style.background = '#fff'; });
                kulvrikshDropdown.appendChild(div);
            });

            kulvrikshDropdown.style.display = 'block';
        })
        .catch(() => {
            kulvrikshSpinner.style.display = 'none';
        });
    }, 300);
});

kulvrikshSearch.addEventListener('blur', function () {
    if (isSelectingOption) return;
    setTimeout(() => { kulvrikshDropdown.style.display = 'none'; }, 150);
});

kulvrikshDropdown.addEventListener('mousedown', function () { isSelectingOption = true; });

kulvrikshDropdown.addEventListener('click', function (e) {
    const opt = e.target.closest('.kulvriksh-option');
    isSelectingOption = false;
    if (!opt) return;
    const val = opt.dataset.value;
    kulvrikshSearch.value           = val;
    kulvrikshHidden.value           = val;
    kulvrikshDropdown.style.display = 'none';
    fetchByKulvrikshId(val);
});

document.addEventListener('click', function (e) {
    if (!e.target.closest('#kulvriksh_wrapper')) {
        kulvrikshDropdown.style.display = 'none';
    }
});


    function fetchByKulvrikshId(val) {
        if (!val) {
            ['client_id_field','name_field','phone_field','address_notes','address_full']
                .forEach(id => document.getElementById(id).value = '');
            kulvrikshSearch.value = '';
            return;
        }
        kulvrikshSpinner.style.display = '';
        fetch('<?php echo e(url("admin/bills/get-client-by-kulvriksh")); ?>?kulvrisk_id=' + encodeURIComponent(val), {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            kulvrikshSpinner.style.display = 'none';
            if (data.found) {
                fillClientFields(data);
            } else {
                document.getElementById('client_id_field').value = '';
                document.getElementById('name_field').value      = '';
                document.getElementById('phone_field').value     = '';
                document.getElementById('address_notes').value   = '';
                document.getElementById('address_full').value    = '';
                document.getElementById('kulvrisk_id').value     = '';
                alert('No client found with this Kulvriksh ID.');
            }
        })
        .catch(() => {
            kulvrikshSpinner.style.display = 'none';
            alert('Error fetching client details. Please try again.');
        });
    }

    const phoneInput   = document.getElementById('phone_field');
    const phoneSpinner = document.getElementById('phone_spinner');
    let   phoneTimer   = null;

    function fetchByPhone() {
        const val = phoneInput.value.trim();
        if (val.length < 10) return;
        phoneSpinner.style.display = '';
        fetch('<?php echo e(url("admin/bills/get-client-by-phone")); ?>?phone=' + encodeURIComponent(val), {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            phoneSpinner.style.display = 'none';
            if (data.found) fillClientFields(data);
        })
        .catch(() => { phoneSpinner.style.display = 'none'; });
    }

    
    phoneInput.addEventListener('input', function () {
        clearTimeout(phoneTimer);
        if (this.value.trim().length === 10) {
            phoneTimer = setTimeout(fetchByPhone, 300);
        }else {
        clearClientFields();
    }
    });

    phoneInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === 'Tab') {
            e.preventDefault();
            e.stopPropagation();
            clearTimeout(phoneTimer);
            fetchByPhone();
        }
    });
   
     const emailInput = document.getElementById('email_field');
let emailTimer = null;

emailInput.addEventListener('input', function () {
    clearTimeout(emailTimer);
    const val = this.value.trim();
    if (!val){
         clearClientFields();
         return;
    } 

    emailTimer = setTimeout(function () {
        fetchByEmail(val);
    }, 300);
});

emailInput.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' || e.key === 'Tab') {
        e.preventDefault();
        e.stopPropagation();
        clearTimeout(emailTimer);
        fetchByEmail(this.value.trim());
    }
});

function fetchByEmail(val) {
    if (!val) return;

    fetch('<?php echo e(url("admin/bills/get-client-by-email")); ?>?email=' + encodeURIComponent(val), {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        if (data.found) {
            fillClientFields(data);
        }
    })
    .catch(() => {
        console.error('Error fetching client by email.');
    });
}

    document.getElementById('bank_account_id').addEventListener('change', function () {
        const account = bankAccounts.find(acc => acc.id == this.value);
        document.getElementById('previewBankName').textContent      = account?.bank_name           || '—';
        document.getElementById('previewAccountNo').textContent     = account?.account_number      || '—';
        document.getElementById('previewAccountHolder').textContent = account?.account_holder_name || '—';
        document.getElementById('previewBranch').textContent        = account?.branch              || '—';
    });

  
    function updateRowAmount(row) {
        const subSelect  = row.querySelector('.subproject-select');
        const qtyInput   = row.querySelector('input[name="qty[]"]');
        const amountCell = row.querySelector('.service-amount');
        if (!amountCell || !subSelect) return;
        const amount = subSelect?.selectedOptions[0]?.dataset?.amount
            ? parseFloat(subSelect.selectedOptions[0].dataset.amount) : 0;
        const qty    = qtyInput && qtyInput.value ? parseFloat(qtyInput.value) : 1;
        const total  = amount * qty;
        amountCell.textContent = total > 0 ? formatRupee(total) : '—';
        updateSummaryTotals();
    }


    // function updateSummaryTotals() {
    //     let subTotal = 0;

      
    //     document.querySelectorAll('#createBillServicesTbody .dynamic-service-row').forEach(function (row) {
    //         const subSelect = row.querySelector('.subproject-select');
    //         const qtyInput  = row.querySelector('input[name="qty[]"]');
    //         const amount    = subSelect?.selectedOptions[0]?.dataset?.amount
    //             ? parseFloat(subSelect.selectedOptions[0].dataset.amount) : 0;
    //         const qty       = qtyInput && qtyInput.value ? parseFloat(qtyInput.value) : 1;
    //         subTotal += amount * qty;
    //     });

    //     document.querySelectorAll('#createBillServicesTbody .dynamic-service-detail-row').forEach(function (row) {
    //         const amountInput = row.querySelector('input[name="service_amount[]"]');
    //         const val = amountInput && amountInput.value
    //             ? parseFloat(amountInput.value.replace(/[^0-9.]/g, '')) : 0;
    //         subTotal += val;
    //     });

    //     const cgst  = subTotal * 0.09;
    //     const sgst  = subTotal * 0.09;
    //     const total = subTotal + cgst + sgst;

    //     document.getElementById('subtotal').textContent = formatRupee(subTotal);
    //     document.getElementById('cgst').textContent     = formatRupee(cgst);
    //     document.getElementById('sgst').textContent     = formatRupee(sgst);
    //     document.getElementById('total').textContent    = formatRupee(total);
    // }
    //mansi add
    function updateSummaryTotals() {
        let subTotal = 0;

        document.querySelectorAll('#createBillServicesTbody .dynamic-service-row').forEach(function (row) {
            const subSelect = row.querySelector('.subproject-select');
            const qtyInput  = row.querySelector('input[name="qty[]"]');
            const amount    = subSelect?.selectedOptions[0]?.dataset?.amount
                ? parseFloat(subSelect.selectedOptions[0].dataset.amount) : 0;
            const qty       = qtyInput && qtyInput.value ? parseFloat(qtyInput.value) : 1;
            subTotal += amount * qty;
        });

        document.querySelectorAll('#createBillServicesTbody .dynamic-service-detail-row').forEach(function (row) {
            const amountInput = row.querySelector('input[name="service_amount[]"]');
            const val = amountInput && amountInput.value
                ? parseFloat(amountInput.value.replace(/[^0-9.]/g, '')) : 0;
            subTotal += val;
        });

        const country   = document.getElementById('client_country')?.value || '';
        const state     = document.getElementById('client_state')?.value   || '';
        const isIndia   = country === 'india';
        const isGujarat = isIndia && state === 'gujarat';

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

        document.getElementById('subtotal').textContent = formatRupee(subTotal);
        document.getElementById('cgst').textContent     = formatRupee(cgst);
        document.getElementById('sgst').textContent     = formatRupee(sgst);
        document.getElementById('igst').textContent     = formatRupee(igst);
        document.getElementById('total').textContent    = formatRupee(total);

        const cgstRow = document.getElementById('cgst-row');
        const sgstRow = document.getElementById('sgst-row');
        const igstRow = document.getElementById('igst-row');
        if (cgstRow) cgstRow.style.display = isGujarat ? '' : 'none';
        if (sgstRow) sgstRow.style.display = isGujarat ? '' : 'none';
        if (igstRow) igstRow.style.display = (isIndia && !isGujarat) ? '' : 'none';
    }


    function toggleRowDeleteButtons() {
        const rows = document.querySelectorAll('#createBillServicesTbody .dynamic-service-row');
        rows.forEach(row => {
            const btn = row.querySelector('.btn-remove-service-row');
            if (btn) btn.style.display = rows.length > 1 ? '' : 'none';
        });
    }

 
    function loadSubprojects(projectSelect, subSelect, selectedId, row) {
        const projectId = projectSelect.value;
        if (!projectId) {
            subSelect.innerHTML = '<option value="">Select Sub Project</option>';
            subSelect.disabled  = true;
            if (row) updateRowAmount(row);
            return;
        }
        fetch('<?php echo e(url("admin/get-subprojects")); ?>/' + projectId, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(subs => {
            subSelect.innerHTML = '<option value="">Select Sub Project</option>' +
                subs.map(s => `<option value="${s.id}" data-amount="${s.amount || 0}">${s.name}</option>`).join('');
            subSelect.disabled = false;
            if (selectedId) subSelect.value = selectedId;
            if (row) updateRowAmount(row);
        })
        .catch(() => {
            subSelect.innerHTML = '<option value="">Error loading</option>';
            subSelect.disabled  = true;
        });
    }


    function buildProjectOptions() {
        return parentProjects.map(p => `<option value="${p.id}">${p.name}</option>`).join('');
    }


    function initServiceRow(i) {
        const tbody = document.getElementById('createBillServicesTbody');

        const r1 = document.createElement('tr');
        r1.className     = 'dynamic-service-row';
        r1.dataset.index = i;
        r1.innerHTML = `
            <td>
                <select class="form-select form-select-sm project-select" name="project_ids[]" data-index="${i}">
                    <option value="">Select Project</option>
                    ${buildProjectOptions()}
                </select>
            </td>
            <td>
                <select class="form-select form-select-sm subproject-select" name="sub_project_ids[]" data-index="${i}" disabled>
                    <option value="">Select Sub Project</option>
                </select>
            </td>
            <td><input type="text"   class="form-control form-control-sm" name="hsn[]"  placeholder="Enter HSN"></td>
            <td><input type="number" class="form-control form-control-sm qty-input" name="qty[]"  min="1"  placeholder="Enter Qty" min="1"></td>
            <td class="text-center align-middle service-amount">—</td>
            <td class="text-end align-middle">
                <button type="button" class="btn btn-sm btn-danger btn-remove-service-row" title="Delete row" style="display:none;">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </td>`;

        const r2 = document.createElement('tr');
        r2.className     = 'dynamic-service-detail-row';
        r2.dataset.index = i;
        r2.innerHTML = `
            <td><input type="text"   class="form-control form-control-sm" name="service_name[]"  placeholder="Enter Services Name"></td>
            <td><input type="text"   class="form-control form-control-sm" name="description[]"   placeholder="Enter Description"></td>
            <td><input type="text"   class="form-control form-control-sm" name="hsn_detail[]"    placeholder="Enter HSN"></td>
            <td><input type="number" class="form-control form-control-sm qty-detail-input" name="qty_detail[]"  min="1"  placeholder="Enter Qty" min="1"></td>
            <td colspan="2">
                <input type="text" class="form-control form-control-sm" name="service_amount[]" placeholder="Enter Services Amount">
            </td>`;

        tbody.append(r1, r2);
    }

    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('project-select')) {
            const row = e.target.closest('tr.dynamic-service-row');
            const sub = row?.querySelector('.subproject-select');
            if (sub) loadSubprojects(e.target, sub, null, row);
        }
        if (e.target.classList.contains('subproject-select')) {
            const row = e.target.closest('tr.dynamic-service-row');
            if (row) updateRowAmount(row);
        }
    });

    document.addEventListener('input', function (e) {


        if (e.target.name === 'qty[]') {
            const row = e.target.closest('tr.dynamic-service-row');
            if (row) updateRowAmount(row);
        }


        if (e.target.name === 'qty_detail[]') {
            const row         = e.target.closest('tr.dynamic-service-detail-row');
            if (!row) return;
            const amountInput = row.querySelector('input[name="service_amount[]"]');
            if (!amountInput) return;

      
            if (!amountInput.dataset.base) {
                amountInput.dataset.base = amountInput.value || 0;
            }

            const baseAmount = parseFloat(amountInput.dataset.base) || 0;
            const qty        = parseFloat(e.target.value) || 1;

            amountInput.value = (baseAmount * qty).toFixed(2);
            updateSummaryTotals();
        }


        if (e.target.name === 'service_amount[]') {

            e.target.dataset.base = e.target.value;
            updateSummaryTotals();
        }
    });

    document.getElementById('addMoreService').addEventListener('click', function () {
        serviceRowIndex++;
        initServiceRow(serviceRowIndex);
        toggleRowDeleteButtons();
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.btn-remove-service-row')) return;
        e.preventDefault();
        const row = e.target.closest('tr.dynamic-service-row');
        if (!row) return;
        if (document.querySelectorAll('#createBillServicesTbody .dynamic-service-row').length <= 1) return;
        const idx       = row.dataset.index;
        const detailRow = document.querySelector(`tr.dynamic-service-detail-row[data-index="${idx}"]`);
        row.remove();
        if (detailRow) detailRow.remove();
        toggleRowDeleteButtons();
        updateSummaryTotals();
    });

    initServiceRow(serviceRowIndex);
    toggleRowDeleteButtons();
    updateSummaryTotals();
});
</script>
<script>
document.getElementById('saveBillBtn').addEventListener('click', function(e) {
    let isValid = true;


    document.querySelectorAll('.js-error').forEach(el => el.remove());
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

    // 1. Kulvriksh ID
    const clientId = document.getElementById('client_id_field').value.trim();
    if (!clientId) {
        isValid = false;
        const el = document.getElementById('kulvrisk_search');
        el.classList;
        el.insertAdjacentHTML('afterend', '<span class="text-danger js-error">Kulvriksh ID is required.</span>');
    }

    // 2. Payment Mode
    const paymentMode = document.getElementById('payment_mode').value;
    if (!paymentMode || paymentMode === 'Select Mode') {
        isValid = false;
        const el = document.getElementById('payment_mode');
        el.classList;
        el.insertAdjacentHTML('afterend', '<span class="text-danger js-error">Payment mode is required.</span>');
    }

    // 3. Bank Account
    const bankAccount = document.getElementById('bank_account_id').value;
    if (!bankAccount) {
        isValid = false;
        const el = document.getElementById('bank_account_id');
        el.classList;
        el.insertAdjacentHTML('afterend', '<span class="text-danger js-error">Please select a bank account.</span>');
    }


   let hasProject = false;
let hasService = false;

// Loop all project rows
document.querySelectorAll('#createBillServicesTbody .dynamic-service-row').forEach(function(row) {
    const projectVal = row.querySelector('.project-select')?.value;
    const subProjectVal = row.querySelector('.subproject-select')?.value;

    // If project + subproject selected → valid project row
    if (projectVal && subProjectVal) {
        hasProject = true;
    }
});

// Loop all service rows
document.querySelectorAll('#createBillServicesTbody .dynamic-service-detail-row').forEach(function(row) {
    const serviceName = row.querySelector('input[name="service_name[]"]')?.value.trim();
    const amount = row.querySelector('input[name="service_amount[]"]')?.value.trim();

    // If any service field filled → valid service row
    if (serviceName || amount) {
        hasService = true;
    }
});


if (!hasProject && !hasService) {
    isValid = false;

    const tbody = document.getElementById('createBillServicesTbody');
    const existingErr = document.getElementById('service-table-error');

    if (!existingErr) {
        tbody.closest('.table-responsive').insertAdjacentHTML('beforebegin',
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


['kulvrisk_search', 'payment_mode', 'bank_account_id'].forEach(function(id) {
    const el = document.getElementById(id);
    if (el) {
        el.addEventListener('change', function() {
            this.classList.remove('is-invalid');
            const next = this.nextElementSibling;
            if (next && next.classList.contains('js-error')) next.remove();
        });
        el.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const next = this.nextElementSibling;
            if (next && next.classList.contains('js-error')) next.remove();
        });
    }
});


document.addEventListener('change', function(e) {
    if (e.target.classList.contains('project-select') || 
        e.target.classList.contains('subproject-select')) {
        e.target.classList.remove('is-invalid');
        const next = e.target.nextElementSibling;
        if (next && next.classList.contains('js-error')) next.remove();

        const tableErr = document.getElementById('service-table-error');
        if (tableErr) tableErr.remove();
    }
});

// When project OR subproject changes → set qty = 1
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('project-select') || e.target.classList.contains('subproject-select')) {
        let row = e.target.closest('tr');
        let qtyInput = row.querySelector('.qty-input');

        if (qtyInput && !qtyInput.value) {
            qtyInput.value = 1;
        }
    }
});

// When service name OR description is typed → set qty = 1
document.addEventListener('input', function(e) {
    if (e.target.name === 'service_name[]' || e.target.name === 'description[]') {
        let row = e.target.closest('tr');
        let qtyInput = row.querySelector('.qty-detail-input');

        if (qtyInput && !qtyInput.value) {
            qtyInput.value = 1;
        }
    }
});
</script>
<script>
// Calendar initialize
flatpickr("#created_at", {
    altInput: true,
    altFormat: "d-m-Y",
    dateFormat: "Y-m-d",
    defaultDate: "today"
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/bills/create.blade.php ENDPATH**/ ?>