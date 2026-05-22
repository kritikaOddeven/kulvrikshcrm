<?php $__env->startSection('pagetitle', 'Archive Report | Kulvriksh'); ?>
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
            <h4 class="page-title">Researcher Report</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="">Researcher Report</a></li>
                <li class="breadcrumb-item active">Archive Report</li>
            </ol>
        </div>
    </div>


    <div class="row">
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
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <?php $__currentLoopData = $researchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <?php
                                    $assign_researchers = getResearchersWithNames(json_decode($report->researcher_ids ?? '[]', true))['researchers'];
                                    $projectData = getProjectsWithNames('parent', json_decode($report->project_ids ?? '[]', true));

                                ?>
                                <td><?php echo e($report->kulvrisk_id); ?></td>
                                <td><?php echo e($report->lead->first_name ?? ''); ?> <?php echo e($report->lead->middle_name ?? ''); ?> <?php echo e($report->lead->last_name ?? ''); ?></td>
                                <td><?php echo e($report->lead->email ?? ''); ?></td>
                                <td>
                                    <div class="avatar-group avatar-list-stack">
                                        <?php $__currentLoopData = $assign_researchers->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="avatar avatar-xs rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 12px;" title="<?php echo e($data->name); ?>">
                                                <?php echo e(get_initials($data->name)); ?>

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
                                <td><?php echo e($report->start_date ?? ''); ?></td>
                                <td><?php echo e($report->end_date ?? ''); ?></td>
                                <td style="width: 150px">
                                    <div class="d-flex gap-2">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('download_archive_report')): ?>
                                        <a href="<?php echo e(url('admin/research-reports/' . $report->id . '/restore')); ?>" class="btn-sm convert-icon-btn" title="Restore"><i class="ri-reset-left-line"></i></a>
                                        <?php endif; ?>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_archive_report')): ?>
                                        <a href="<?php echo e(url('admin/research-reports/view/' . $report->id)); ?>" class="view-icon-btn btn-sm btn-action rounded-pill mr-1" title="view"><i class="ri-eye-line"></i></a>
                                        <?php endif; ?>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_archive_report')): ?>
                                        <form action="<?php echo e(url('admin/research-reports/delete/' . $report->id . '?force=true')); ?>" method="POST" id="deleteForm_<?php echo e($report->id); ?>" style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-bs-toggle="tooltip" title="delete" data-title="Delete Researcher Report" data-description="Are you sure you want to delete this Researcher Report ?" onclick="deleteAccount(this, <?php echo e($report->id); ?>)">
                                                <i class="ri-delete-bin-6-line"></i>
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/researchers/reports/archive.blade.php ENDPATH**/ ?>