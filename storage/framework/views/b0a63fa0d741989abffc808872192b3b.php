<?php $__env->startSection('pagetitle','Agent | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
    <div class="row py-3 align-items-sm-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">Agents</h4>
            
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Agents</a></li>
                <li class="breadcrumb-item active">View All Agents</li>
            </ol>
        </div>
        <div class="col-auto">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add_agent')): ?>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"  data-bs-target="#exampleModalPopovers">
                    + Add Agent
                </button>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            
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
            <div class="card">
                <div class="card-body card-body2">
                    <table id="datatable" class="table table-responsive nowrap">
                        <thead class="table-info">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $agent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item->name); ?></td>
                                    <td><?php echo e($item->email); ?></td>
                                    <td><?php echo e($item->phone ?? 'N/A'); ?></td>
                                    <td class="text-capitalize"><?php echo e($item->roles->pluck('name')->first()); ?></td>
                                    <td>
                                        <?php if($item->status === 'active'): ?>
                                            <span class="active-btn">Active</span>
                                        <?php else: ?>
                                            <span class="inactive-btn">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_agent')): ?>
                                                <a href="<?php echo e(url('admin/agents/view/' . $item->id)); ?>" data-value="<?php echo e($item->id); ?>" class="view-icon-btn btn-sm btn-action mr-1 view" data-bs-toggle="modal" data-bs-target="#viewModalPopovers<?php echo e($item->id); ?>"><i class="ri-eye-line"></i></a>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_agent')): ?>
                                                <a data-value="<?php echo e($item->id); ?>" class="edit-icon-btn btn-sm btn-action mr-1 editbtn"><i class="ri-edit-line"></i></a>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_agent')): ?>
                                                <form action="<?php echo e(url('admin/agents/delete/' . $item->id)); ?>" method="POST" id="deleteForm_<?php echo e($item->id); ?>" style="display:inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-bs-toggle="tooltip" title="delete" data-title="Delete Agent" data-description="Are you sure you want to delete this agent? Deleting this agent will remove all related data." onclick="deleteAccount(this, <?php echo e($item->id); ?>)">
                                                        <i class="ri-delete-bin-6-line"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php echo $__env->make('admin.agents.view_agent', ['agent' => $item], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('admin.agents.add_agent', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('admin.agents.edit_agent', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script>
        $(document).ready(function() {
            // Password Match Validation
            function handlePasswordValidation(formSelector, passwordSelector, confirmPasswordSelector, errorSelector, submitBtnSelector) {
                $(formSelector).on('input', `${passwordSelector}, ${confirmPasswordSelector}`, function() {
                    const password = $(formSelector + ' ' + passwordSelector).val().trim();
                    const confirmPassword = $(formSelector + ' ' + confirmPasswordSelector).val().trim();
                    const $error = $(formSelector + ' ' + errorSelector);
                    const $submitBtn = $(formSelector + ' ' + submitBtnSelector);

                    if (!confirmPassword) {
                        $error.text('').hide();
                        $submitBtn.prop('disabled', true);
                        return;
                    }

                    if (password !== confirmPassword) {
                        $error.text('Passwords do not match').show();
                        $submitBtn.prop('disabled', true);
                    } else {
                        $error.text('').hide();
                        $submitBtn.prop('disabled', false);
                    }
                });
            }

            handlePasswordValidation(
                '#agentForm',
                '.password',
                '#confirm_password',
                '#password_error',
                '#agentAddSubmit'
            );

            handlePasswordValidation(
                '#agentEditForm',
                '.edit-password',
                '.confirm_password',
                '.password_error',
                '#agentEditSubmit'
            );

            // AJAX Form Submission (Both Create & Edit)
            $('#agentForm, #agentEditForm').on('submit', function(e) {
                e.preventDefault();

                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');
                let originalText = $submitBtn.text();

                $submitBtn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        $form[0].reset();
                        $form.find('.text-danger').not('.req-star').text('');
                        $form.find('.password_error, #password_error').text('');

                        $('.modal').modal('hide');
                        // alert(response.message || 'Success!');

                        // Optionally reload or update UI here
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            timer: 5000,
                        }).then(() => {
                            location.reload(); // reloads the current page after alert is dismissed
                        });

                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        $form.find('.text-danger').not('.req-star').text('');
                        $form.find('.password_error, #password_error').text('');

                        if (errors) {
                            $.each(errors, function(field, messages) {
                                $form.find(`[name="${field}"]`).next('.text-danger').text(messages[0]);
                                if (field === 'password') {
                                    $form.find('.password_error, #password_error').text(messages[0]);
                                }
                            });
                        }
                        $submitBtn.prop('disabled', false).text(originalText);
                    }
                });
            });

            // Populate Edit Modal via AJAX
            $('.editbtn').on('click', function() {
                const agentId = $(this).data('value');
                $('#editAgentModal').modal('show');

                $.ajax({
                    url: "<?php echo e(url('admin/agents/edit')); ?>/" + agentId,
                    type: 'GET',
                    success: function(response) {
                        $('#agent_id').val(response.id);
                        $('#name').val(response.name);
                        $('#email').val(response.email);
                        $('#phone').val(response.phone);
                        $('#role').val(response.roles[0]?.name);
                        $('#status').val(response.status);
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/agents/index.blade.php ENDPATH**/ ?>