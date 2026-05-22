<?php $__env->startSection('pagetitle','Client Attachment | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">View All Attachment</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="<?php echo e(url('admin/clients')); ?>">Client</a></li>
                <li class="breadcrumb-item active">View All Attachment</li>
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
                                <th>Date</th>
                                <th>Client Name</th>
                                <th>Agent Name</th>
                                <th>Document Name</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            <?php $__empty_1 = true; $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($attachment->created_at->format('Y-m-d')); ?></td>
                                    <td><?php echo e($attachment->lead->first_name.' '. $attachment->lead->last_name); ?></td>
                                    <td><?php echo e($attachment->note->user->name); ?></td>
                                    <td>
                                        <?php if($attachment->type == 'image'): ?>
                                            <i class="ri-image-line me-1"></i>
                                        <?php elseif($attachment->type == 'audio'): ?>
                                            <i class="ri-file-music-line me-1"></i>
                                        <?php elseif($attachment->type == 'application'): ?>
                                            <i class="ri-file-pdf-line me-1"></i>
                                        <?php else: ?>
                                            <i class="ri-file-line me-1"></i>
                                        <?php endif; ?>
                                        <?php echo e($attachment->attachment); ?>

                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="<?php echo e(asset($attachment->attachment)); ?>" class="btn-sm edit-icon-btn" download title="Download">
                                                <i class="ri-download-2-line"></i>
                                            </a>
                                            <a href="<?php echo e(asset($attachment->attachment)); ?>" target="_blank" class="view-icon-btn btn-sm btn-action mr-1" title="View">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <form action="<?php echo e(url('admin/leads/attachment/delete/' . $attachment->id)); ?>" id="deleteForm_<?php echo e($attachment->id); ?>" method="POST" style="display:inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-title="Delete Attachment" data-description="Are you sure you want to delete this attachment?" onclick="deleteAccount(this, <?php echo e($attachment->id); ?>)">
                                                    <i class="ri-delete-bin-6-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5">No attachments found for this lead.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/clients/all-attachment.blade.php ENDPATH**/ ?>