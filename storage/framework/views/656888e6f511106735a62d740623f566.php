<?php $__env->startSection('pagetitle','View Lead | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
    <style>
        .info-table th, .info-table td { border: none; }
        .avatar-initials {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #6c757d;
            color: #fff;
            font-weight: bold;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            font-size: 14px;
            text-transform: uppercase;
        }
    </style>

    <?php echo $__env->make('admin.leads.details.header-actions', ['data' => $data], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="row">
        <div class="col-xl-12">
            <div class="card lead-view-box">
                <div class="accordion" id="accordionPanelsStayOpenExample">
                    <?php echo $__env->make('admin.leads.details.lead-info', ['data' => $data], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('admin.leads.details.lineage-info', ['data' => $data], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('admin.leads.details.family-info', ['data' => $data], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('admin.leads.details.wife-info', ['data' => $data], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('admin.leads.details.wife-lineage-info', ['data' => $data], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('admin.leads.details.wife-family-info', ['data' => $data], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('admin.leads.details.children-info', ['data' => $data], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('admin.leads.details.lead-notes', ['data' => $data], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->make('admin.leads.modals.lead-to-client-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/leads/view.blade.php ENDPATH**/ ?>