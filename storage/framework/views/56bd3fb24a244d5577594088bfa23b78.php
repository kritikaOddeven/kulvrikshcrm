<?php $__env->startSection('pagetitle', 'Researcher | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
    <style>
        .avatar-list-stack {
            display: flex;
            align-items: center;
        }

        .avatar-list-stack .avatar {
            border: 2px solid #fff;
            z-index: 1;
            position: relative;
        }

        .avatar-list-stack .avatar:first-child {
            margin-left: 0;
        }

        .avatar-list-stack .avatar.more {
            background-color: #3394df;
            color: #fff;
        }
    </style>
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">Researcher</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="<?php echo e(url('admin/dashboard')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">View All Researchers</li>
            </ol>
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
                                <th>KV ID</th>
                                <th>Client Name</th>
                                <th>Email Id</th>
                                <th>Researcher Name</th>
                                <th>Project Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $researchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $researcher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <?php
                                        $assign_researchers = getResearchersWithNames(json_decode($researcher->researcher_ids ?? '[]', true))['researchers'];
                                        $projectData = getProjectsWithNames('parent', json_decode($researcher->project_ids ?? '[]', true));

                                    ?>
                                    <td><?php echo e($researcher->kulvrisk_id); ?></td>
                                    <td><?php echo e($researcher->lead->first_name ?? ''); ?> <?php echo e($researcher->lead->middle_name ?? ''); ?> <?php echo e($researcher->lead->last_name ?? ''); ?></td>
                                    <td><?php echo e($researcher->lead->email ?? ''); ?></td>
                                    <td>
                                        <div class="avatar-group avatar-list-stack">
                                            <?php $__currentLoopData = $assign_researchers->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="avatar avatar-xs rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 12px;" title="<?php echo e($item->name); ?>">
                                                    <?php echo e(get_initials($item->name)); ?>

                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <?php if($assign_researchers->count() > 3): ?>
                                                <div class="avatar avatar-xs rounded-circle d-inline-flex align-items-center justify-content-center more" style="width: 32px; height: 32px; font-size: 12px;">
                                                    +<?php echo e($assign_researchers->count() - 3); ?>

                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td><?php echo e($projectData['names']); ?></td>
                                    <td><?php echo e($researcher->start_date ?? ''); ?></td>
                                    <td><?php echo e($researcher->end_date ?? ''); ?></td>
                                    <?php
                                        $statusClass = match ($researcher->research_status) {
                                            'running' => 'high-lead',
                                            'pending' => 'low-lead',
                                            default => 'done-lead',
                                        };
                                    ?>
                                    <td>
                                        
                                        <a class="status-lead-btn <?php echo e($statusClass); ?>" <?php if($researcher->research_status == 'running'): ?> data-value="<?php echo e($researcher->id); ?>" data-bs-toggle="modal" data-bs-target=".research-status-modal-<?php echo e($researcher->id); ?>" <?php endif; ?>>
                                            <?php echo e($researcher->research_status == 'completed' ? 'Submitted' : ucfirst($researcher->research_status)); ?>


                                            <?php if($researcher->research_status == 'running'): ?>
                                                <i class="ri-edit-line"></i>
                                            <?php endif; ?>
                                        </a>

                                    </td>


                                    
                                    <td style="width: 150px">
                                        <div class="d-flex gap-2">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_researcher')): ?>
                                                <a href="<?php echo e(url('admin/researcher/view/' . $researcher->id)); ?>" class="view-icon-btn btn-sm btn-action rounded-pill mr-1" title="view"><i class="ri-eye-line"></i></a>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('researcher_edit_client')): ?>
                                                <a href="<?php echo e(url('admin/clients/edit/' . $researcher->id)); ?>" class="edit-icon-btn btn-sm btn-action rounded-pill mr-1" title="edit"><i class="ri-edit-line"></i></a>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_researcher')): ?>
                                                <form action="<?php echo e(url('admin/researcher/delete/' . $researcher->id)); ?>" method="POST" id="deleteForm_<?php echo e($researcher->id); ?>" style="display:inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-bs-toggle="tooltip" title="delete" data-title="Delete Researcher" data-description="Are you sure you want to delete this Researcher ?" onclick="deleteAccount(this, <?php echo e($researcher->id); ?>)">
                                                        <i class="ri-delete-bin-6-line"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php echo $__env->make('admin.researchers.modals.status-update', ['researchers' => $researcher], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/researchers/index.blade.php ENDPATH**/ ?>