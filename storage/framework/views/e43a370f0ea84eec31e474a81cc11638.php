<?php $__env->startSection('pagetitle', 'Role | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
    <div class="row py-3 align-items-sm-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">Roles</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="<?php echo e(url('admin/roles')); ?>">Roles</a></li>
                <li class="breadcrumb-item active">View All Roles</li>
            </ol>
        </div>
        <div class="col-auto">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add_role')): ?>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#role">
                    + Add Role
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
                                <th>Role Name</th>
                                <th>Role Type</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th style="width: 200px important!" data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-capitalize"><?php echo e($role->name); ?></td>
                                    <td>
                                        <?php
                                            $roleClass = match ($role->role_type) {
                                                'agent' => 'high-lead',
                                                'researcher' => 'done-lead',
                                                'admin_team' => 'low-lead',
                                                'none' => 'default-lead',
                                            };
                                        ?>

                                        <span class="status-lead-btn <?php echo e($roleClass); ?>">
                                            <?php echo e(ucwords(str_replace('_', ' ', $role->role_type))); ?>

                                        </span>

                                        
                                    </td>
                                    <td><?php echo e($role->created_at->format('d-m-Y')); ?></td>
                                    <td>
                                        <?php if($role->status === 'active'): ?>
                                            <span class="active-btn">Active</span>
                                        <?php else: ?>
                                            <span class="inactive-btn">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('assign_permission')): ?>
                                                <a href="<?php echo e(url('admin/roles/permission/' . $role->id)); ?>" class="btn-sm view-icon-btn"><i class="ri-user-settings-line"></i></a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_role')): ?>
                                                <button class="edit-icon-btn btn-sm btn-action mr-1" data-bs-toggle="modal" data-bs-target="#editRole<?php echo e($role->id); ?>"><i class="ri-edit-line"></i></button>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_role')): ?>
                                                <form action="<?php echo e(url('admin/roles/' . $role->id)); ?>" method="POST" id="deleteForm_<?php echo e($role->id); ?>" style="display:inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-bs-toggle="tooltip" title="delete" data-title="Delete Role" data-description="Are you sure you want to delete this Role ?" onclick="deleteAccount(this, <?php echo e($role->id); ?>)">
                                                        <i class="ri-delete-bin-6-line"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php echo $__env->make('admin.role-permissions.edit', ['role' => $role], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('admin.role-permissions.add', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {

            // Handle Role Create
            $('#addRoleForm').on('submit', function(e) {
                e.preventDefault();

                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');
                let originalText = $submitBtn.text();


                $submitBtn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: '<?php echo e(route('admin.roles.store')); ?>',
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        $form.find('.text-danger').not('.req-star').text('');

                        if (errors) {
                            $.each(errors, function(field, message) {
                                if (field == 'name') {
                                    $form.find(`[name="${field}"]`).next('.text-danger').text(message[0]);
                                }
                                if (field == 'role_type') {
                                    $form.find(`[name="${field}"]`).closest('.col-md-12').find('.text-danger').text(message[0]);
                                }
                            });
                        }

                        $submitBtn.prop('disabled', false).text(originalText);
                    }
                });
            });

            // Handle Role Edit (Multiple dynamic forms)
            $('.editRoleForm').on('submit', function(e) {
                e.preventDefault();

                let $form = $(this);
                let roleId = $form.data('role-id');
                let $submitBtn = $form.find('button[type="submit"]');
                let originalText = $submitBtn.text();

                $submitBtn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: `/admin/roles/${roleId}`,
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        $form.find('.text-danger').not('.req-star').text('');

                        if (errors) {
                            $.each(errors, function(field, message) {
                                if (field == 'name') {
                                    $('.name-errorr' + roleId).text(message[0]);
                                }
                                if (field == 'role_type') {
                                    $('.role-type-errorr' + roleId).text(message[0]);
                                }
                            });
                        }

                        $submitBtn.prop('disabled', false).text(originalText);
                    }
                });
            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/role-permissions/role.blade.php ENDPATH**/ ?>