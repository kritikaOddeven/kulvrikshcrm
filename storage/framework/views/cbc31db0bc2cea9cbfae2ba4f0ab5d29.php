<div class="modal fade" id="viewModalPopovers<?php echo e($agent->id); ?>" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-modal="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPopoversLabel">View Agent</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body row">
                <div class="view-details-text">
                    <h2 style="width: 120px;">Agent Name :</h2>
                    <p><?php echo e($agent->name); ?></p>
                </div>
                <div class="view-details-text">
                    <h2 style="width: 120px;">Role :</h2>
                    <p>
                        <?php echo e($agent->roles->pluck('name')->first()); ?>

                    </p>
                </div>
                <div class="view-details-text">
                    <h2 style="width: 120px;">Email :</h2>
                    <p><?php echo e($agent->email ?? ''); ?></p>
                </div>
                <div class="view-details-text">
                    <h2 style="width: 120px;">Phone :</h2>
                    <p><?php echo e($agent->phone ?? ''); ?></p>
                </div>
                <div class="view-details-text mb-0">
                    <h2 style="width: 120px;">Status :</h2>
                    <p><?php echo e(ucfirst($agent->status)); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/agents/view_agent.blade.php ENDPATH**/ ?>