<?php $__env->startSection('pagetitle','Bank Accounts | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
    <div class="row py-3 align-items-sm-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">Bank Accounts</h4>
            
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="<?php echo e(url('admin/dashboard')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">View Bank Accounts</li>
            </ol>
        </div>
        <div class="d-flex flex-wrap gap-2 col-auto">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add_account')): ?>
                
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBankAccount">
                + Add Account
            </button>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        
            <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
        <div class="col-12">
            <div class="card">

                <div class="card-body card-body2">
                    <table id="datatable" class="table table-responsive">
                        <thead class="table-info">
                            <tr>
                                <th>Bank Name</th>
                                <th>A/c Holder Name</th>
                                <th>A/c Number</th>
                                <th>IFSC Code</th>
                                <th>Opening Balance </th>
                                <th>Branch</th>
                                <th>Status</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $bankAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item->bank_name); ?></td>
                                    <td><?php echo e($item->account_holder_name); ?></td>
                                    <td><?php echo e($item->account_number); ?></td>
                                    <td><?php echo e($item->ifsc_code); ?></td>
                                    <td><?php echo e($item->opening_balance); ?></td>
                                    <td><?php echo e($item->branch); ?></td>
                                    <td class="text-center">
                                        <?php if($item->status === 'active'): ?>
                                            <span class="active-btn">Active</span>
                                        <?php else: ?>
                                            <span class="inactive-btn">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_account')): ?>
                                            <a data-value="<?php echo e($item->id); ?>" class="edit-icon-btn btn-sm btn-action mr-1 editbtn" data-bs-toggle="modal" data-bs-target="#editBankAccount" data-bs-toggle="tooltip" title="edit"><i class="ri-edit-line"></i></a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_account')): ?>
                                            <form action="<?php echo e(url('admin/settings/accounts/' . $item->id)); ?>" method="POST" id="deleteForm_<?php echo e($item->id); ?>" style="display:inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-bs-toggle="tooltip" title="delete" data-title="Delete Bank Account" data-description="Are you sure you want to delete this Bank ?" onclick="deleteAccount(this, <?php echo e($item->id); ?>)">
                                                    <i class="ri-delete-bin-6-line"></i>
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('admin.settings.partials.add-edit_account_modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Edit button logic
    $('.editbtn').on('click', function() {
        const id = $(this).data('value');
        const editUrl = "<?php echo e(url('admin/settings/accounts')); ?>/" + id;
        $('#accountEditForm').attr('action', editUrl);
        
        $.ajax({
            url: `/admin/settings/accounts/${id}/edit`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#account_id').val(response.id);
                $('#bank_name').val(response.bank_name);
                $('#account_holder_name').val(response.account_holder_name);
                $('#account_number').val(response.account_number);
                $('#ifsc_code').val(response.ifsc_code);
                $('#swift_code').val(response.swift_code);
                $('#upi_number').val(response.upi_number);
                $('#opening_balance').val(response.opening_balance);
                $('#branch').val(response.branch);
                $('#status').val(response.status);
                $('#editBankAccount').modal('show');
            },
            error: function(xhr) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to load account details',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    // Form submission handler for both add and edit forms
    $('#accountAddForm, #accountEditForm').on('submit', function(e) {
        e.preventDefault();

        let $form = $(this);
        let $submitBtn = $form.find('button[type="submit"]');
        let originalText = $submitBtn.text();
        let isEditForm = $form.attr('id') === 'accountEditForm';

        // Disable submit button
        $submitBtn.prop('disabled', true).text('Saving...');

        // Prepare form data
        let formData = new FormData($form[0]);
        if (isEditForm) {
            formData.append('_method', 'PUT');
        }

        // Make AJAX request
        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                $form[0].reset();
                $form.find('.text-danger').text('');
                $('.modal').modal('hide');

                Swal.fire({
                    title: 'Success!',
                    text: response.message || 'Bank Account saved successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 5000,
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                const errors = xhr.responseJSON?.errors;
                $form.find('.text-danger').not('.req-star').text('');
                
                if (errors) {
                    console.log(errors);
                    $.each(errors, function(field, messages) {
                        $form.find(`[name="${field}"]`).next('.text-danger').text(messages[0]);
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while saving the account',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
                $submitBtn.prop('disabled', false).text(originalText);
            }
        });

        return false;
    });

    // Delete account function
    function deleteAccount(button, id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('deleteForm_' + id);
                const formData = new FormData(form);

                $.ajax({
                    url: form.action,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: response.message || 'Bank Account has been deleted.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to delete bank account',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    }
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/settings/bank_account.blade.php ENDPATH**/ ?>