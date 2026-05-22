<?php $__env->startSection('pagetitle','View Template | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">View Template</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Mass Email</a></li>
                <li class="breadcrumb-item active"><a href="<?php echo e(url('admin/mass-email/template')); ?>">View All Template</a></li>
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
                        <p class="form-label">Subject :<span class="text-light1"> <?php echo e($template->subject); ?> </span></p>
                    </div>
                    <div class="col-md-12 mb-1">
                        <p class="form-label">Basic Information</p>
                    </div>
                    <div class="col-md-12 mb-1">
                        <p class="form-label">Subject:<span class="text-light1"> <?php echo e($template->subject); ?> </span></p>
                        <p><?php echo $template->description; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/mass-email/template/view.blade.php ENDPATH**/ ?>