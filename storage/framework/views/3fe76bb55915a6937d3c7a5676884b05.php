<?php $__env->startSection('pagetitle','View Template | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">View Template</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">WhatsApp Message</a></li>
                <li class="breadcrumb-item active"><a href="<?php echo e(url('admin/whatsapp/template')); ?>">View All Template</a></li>
                <li class="breadcrumb-item active">View Template</li>
            </ol>
        </div>

    </div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body mb-0">
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <p class="form-label">Template Name :<span class="text-light1"> <?php echo e($template->template_name); ?> </span></p>
                    </div>
                    <div class="col-md-12 mb-1">
                        <p class="form-label">Template API Name :<span class="text-light1"> <?php echo e($template->template_api_name ?? 'N/A'); ?> </span></p>
                    </div>
                    <div class="col-md-12 mb-1">
                        <p class="form-label">Template Type :<span class="text-light1"> <?php echo e($template->template_type ?? 'Text Message Only'); ?> </span></p>
                    </div>
                    <div class="col-md-12 mb-1">
                       <p class="form-label">Message Text :</p>
                       <p><?php echo nl2br(e($template->message_text)); ?></p>
                    </div>
                    <?php if($template->template_footer): ?>
                    <div class="col-md-12 mb-1">
                        <p class="form-label">Template Footer :</p>
                        <p><?php echo nl2br(e($template->template_footer)); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?> 
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/whatsapp/template/view.blade.php ENDPATH**/ ?>