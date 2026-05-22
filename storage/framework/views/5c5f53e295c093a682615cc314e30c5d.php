<!-- Add Bank Account Modal -->
<div class="modal fade" id="addBankAccount" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Account Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="accountAddForm" action="<?php echo e(route('admin.settings.accounts.store')); ?>" method="POST" novalidate>
                <?php echo csrf_field(); ?>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Bank Name <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
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
                        <input type="text" class="form-control" name="bank_name" >
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Account Holder Name <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
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
                        <input type="text" class="form-control" name="account_holder_name" >
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Account Number <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
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
                        <input type="text" class="form-control" name="account_number" maxlength="18" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">IFSC Code <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
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
                        <label class="form-label">Opening Balance <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
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
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <input type="hidden" name="account_id" id="account_id">
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Bank Name <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
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
                        <input type="text" class="form-control" name="bank_name" id="bank_name" >
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Account Holder Name <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
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
                        <input type="text" class="form-control" name="account_holder_name" id="account_holder_name" >
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Account Number <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
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
                        <input type="text" class="form-control" name="account_number" id="account_number" maxlength="18" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <span class="text-danger"></span>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">IFSC Code <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
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
                        <label class="form-label">Opening Balance <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
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

<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/settings/partials/add-edit_account_modal.blade.php ENDPATH**/ ?>