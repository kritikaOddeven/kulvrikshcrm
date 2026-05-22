<!-- Add Bank Account Modal -->
<div class="modal fade" id="addBankAccount" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Account Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="accountAddForm" action="{{ route('admin.settings.accounts.store') }}" method="POST" novalidate>
                @csrf
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Bank Name <x-required-star /></label>
                        <input type="text" class="form-control" name="bank_name" >
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Account Holder Name <x-required-star /></label>
                        <input type="text" class="form-control" name="account_holder_name" >
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Account Number <x-required-star /></label>
                        <input type="text" class="form-control" name="account_number" maxlength="18" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">IFSC Code <x-required-star /></label>
                        <input type="text" class="form-control" name="ifsc_code" >
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">SWIFT Code</label>
                        <input type="text" class="form-control" name="swift_code" >
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">UPI Number</label>
                        <input type="text" class="form-control" name="upi_number" >
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Opening Balance <x-required-star /></label>
                        <input type="number" class="form-control" name="opening_balance" maxlength="12" step="0.01">
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" >
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Branch</label>
                        <textarea name="branch" class="form-control" ></textarea>
                        <span class="text-danger"></span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Bank Account Modal -->
<div class="modal fade" id="editBankAccount" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Account Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="accountEditForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="account_id" id="account_id">
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Bank Name <x-required-star /></label>
                        <input type="text" class="form-control" name="bank_name" id="bank_name" >
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Account Holder Name <x-required-star /></label>
                        <input type="text" class="form-control" name="account_holder_name" id="account_holder_name" >
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Account Number <x-required-star /></label>
                        <input type="text" class="form-control" name="account_number" id="account_number" maxlength="18" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">IFSC Code <x-required-star /></label>
                        <input type="text" class="form-control" name="ifsc_code" id="ifsc_code" >
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">SWIFT Code</label>
                        <input type="text" class="form-control" name="swift_code" id="swift_code" >
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">UPI Number</label>
                        <input type="text" class="form-control" name="upi_number" id="upi_number">
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Opening Balance <x-required-star /></label>
                        <input type="number" class="form-control" name="opening_balance" id="opening_balance" maxlength="12" step="0.01">
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" id="status" >
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Branch</label>
                        <textarea name="branch" id="branch" class="form-control" ></textarea>
                        <span class="text-danger"></span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

