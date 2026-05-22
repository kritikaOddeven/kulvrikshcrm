
<div class="accordion-item">

    <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseEight" aria-expanded="true" aria-controls="panelsStayOpen-collapseEight">
            Notes
        </button>
    </h2>
    <div id="panelsStayOpen-collapseEight" class="accordion-collapse collapse show">
        <div class="accordion-body">
            <div class="text-end mb-2">
                <a href="<?php echo e(url('admin/leads/' . $data->id . '/attachment')); ?>" class="text-end view-all-attachment-text">View All Attachment</a>
            </div>
            <div class="row mt-1">
                <?php $__currentLoopData = $data->leadNote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-12 mb-2">
                        <div class="d-flex justify-content-between mb-1">
                            <label class="d-flex align-items-center mb-2 form-label">
                                <img src="<?php echo e(asset(get_profile_image($item->user->profile_image, $item->user->name))); ?>" class="avatar avatar-sm rounded-circle me-2">
                                <?php echo e($item->user->name ?? ''); ?>

                            </label>
                            <span class="text-end form-label"><?php echo e($item->created_at->format('D d F, g:i')); ?></span>
                        </div>
                        <textarea name="content" class="form-control" rows="8" readonly><?php echo $item->content; ?></textarea>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>

    </div>
</div>
<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/leads/details/lead-notes.blade.php ENDPATH**/ ?>