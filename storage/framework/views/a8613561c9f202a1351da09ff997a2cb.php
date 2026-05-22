
<style>
    .form-check-input{
        width: 20px !important;
        height: 20px !important;
        margin-top: 0 !important;
    }
</style>
<div class="modal fade" id="editRole<?php echo e($role->id); ?>" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-modal="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPopoversLabel">Edit Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form class="editRoleForm" action="<?php echo e(url('admin/roles/'.$role->id )); ?>" data-role-id="<?php echo e($role->id); ?>" method="POST">
                <?php echo method_field('PUT'); ?>  
                <?php echo csrf_field(); ?>
                <div class="modal-body row g-3">
                    <input type="hidden" name="role_id" id="role_id">
                    <div class="col-md-12">
                        <label for="validationDefault01" class="form-label">Role Name <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
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
                        <input type="text" class="form-control" id="name" value="<?php echo e($role->name); ?>" name="name">
                        <span class="text-danger name-errorr<?php echo e($role->id); ?>"></span>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Role Type<?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
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
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role_type" id="role_type_agent<?php echo e($role->id); ?>" value="agent" <?php echo e($role->role_type === 'agent' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="role_type_agent<?php echo e($role->id); ?>">
                                    Agent
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role_type" id="role_type_researcher<?php echo e($role->id); ?>" value="researcher" <?php echo e($role->role_type === 'researcher' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="role_type_researcher<?php echo e($role->id); ?>">
                                    Researcher
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role_type" id="role_type_admin_team<?php echo e($role->id); ?>" value="admin_team" <?php echo e($role->role_type === 'admin_team' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="role_type_admin_team<?php echo e($role->id); ?>">
                                    Admin Team
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role_type" id="role_type_none<?php echo e($role->id); ?>" value="none" <?php echo e($role->role_type === 'none' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="role_type_none<?php echo e($role->id); ?>">
                                    None
                                </label>
                            </div>
                        </div>
                        <span class="text-danger role-type-errorr<?php echo e($role->id); ?>"></span>
                    </div>

                    <div class="col-md-12">
                        <label for="validationDefault04" class="form-label">Status</label>
                        <select class="form-select" id="validationDefault04"id="status" name="status">
                            <option  <?php if($role->status === 'active'): ?> selected <?php endif; ?> value="active">Active</option>
                            <option <?php if($role->status === 'inactive'): ?> selected <?php endif; ?> value="inactive">Inactive</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/role-permissions/edit.blade.php ENDPATH**/ ?>