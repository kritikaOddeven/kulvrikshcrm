    <div class="modal fade research-status-modal-<?php echo e($researcher->id); ?>" tabindex="-1" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mySmallModalLabel">Status Update</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(url('admin/researcher/status')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body row g-3">
                        <input type="hidden" name="id" value="<?php echo e($researcher->id); ?>">
                        <div class="col-md-12">
                            <label for="validationDefault04" class="form-label">Status</label>
                            <select class="form-select" id="validationDefault04" required="" name="research_status">
                                <option <?php if($researcher->research_status == 'completed'): ?> selected <?php endif; ?> value="completed">Submitted</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-primary">Save </button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/researchers/modals/status-update.blade.php ENDPATH**/ ?>