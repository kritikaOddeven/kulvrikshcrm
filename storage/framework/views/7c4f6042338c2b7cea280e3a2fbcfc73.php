<?php $__env->startSection('pagetitle','View Project | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
    <div class="py-3 row align-items-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">View Projects</h4>
            
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="<?php echo e(url('admin/projects')); ?>">Projects</a></li>
                <li class="breadcrumb-item active">View Projects</li>
            </ol>
        </div>
        <div class="col-auto">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add_sub_project')): ?>
                
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subproject">
                + Add Sub Project
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
                    <div class="view-project-details-box">
                        <table class="table info-table mb-0">
                            <tr>
                                <th>Project Name</th>
                                <td><?php echo e($project->name); ?></td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td class="text-wrap-400"><?php echo e($project->description); ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <?php if($project->status === 'active'): ?>
                                        <span class="active-btn">Active</span>
                                    <?php else: ?>
                                        <span class="inactive-btn">Inactive</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <table id="datatable" class="table table-responsive ">
                        <thead class="table-info">
                            <tr>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th style="width:150px" data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $subProject; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item->name ?? ''); ?></td>
                                    <td class="text-wrap-400"><?php echo e($item->description ?? ''); ?></td>
                                    <td><?php echo e($item->amount ?? ''); ?></td>
                                    <td>
                                        <?php if(isset($item->status) && $item->status === 'active'): ?>
                                            <span class="active-btn">Active</span>
                                        <?php else: ?>
                                            <span class="inactive-btn">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_sub_project')): ?>
                                            <a data-value="<?php echo e($item->id ?? ''); ?>" class="edit-icon-btn btn-sm btn-action mr-1 editbtn"><i class="ri-edit-line"></i></a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_sub_project')): ?>
                                            <form action="<?php echo e(url('admin/projects/subproject/delete/' . $item->id)); ?>" method="POST" id="deleteForm_<?php echo e($item->id); ?>" style="display:inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-bs-toggle="tooltip" title="delete" data-title="Delete Sub-Project" data-description="Are you sure you want to delete this sub-project?" onclick="deleteAccount(this, <?php echo e($item->id); ?>)">
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
                </div> <!-- end card-body -->
            </div>
        </div>
    </div>

    <?php echo $__env->make('admin.projects.subAddEditProject', ['project' => $project], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/projects/view.blade.php ENDPATH**/ ?>