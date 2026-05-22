<?php $__env->startSection('pagetitle', 'Activity Logs | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
    <div class="row py-3 align-items-sm-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">View Activity Logs</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item active">View Activity Logs</li>
            </ol>
        </div>
        <div class="col-auto">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('export_csv')): ?>
            <a href="<?php echo e(route('admin.logs.export')); ?>" class="btn btn-primary me-2">
                <i class="ri-download-2-line me-1"></i> Export To CSV
            </a>
            <?php endif; ?>

            <?php if(auth()->user()?->hasRole('super-admin')): ?>
                <button type="button" class="btn btn-danger" data-title="Clear Activity Logs" data-description="Are you sure you want to delete all activity logs? This action cannot be undone." onclick="confirmClearLogs(this)">
                    <i class="ri-delete-bin-line me-1"></i> Clear Logs
                </button>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('admin.logs.clear')); ?>" id="deleteLogForm" style="display:none;">
                <?php echo csrf_field(); ?>
            </form>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body card-body2">

                    <table id="datatable" class="table table-responsive">
                        <thead class="table-info">
                            <tr>
                                <th>Date & Time</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($log->created_at->format('m-d-Y, h:i A')); ?></td>
                                    <td><?php echo e($log->user->name ?? 'Unknown'); ?></td>
                                    <td><?php echo e($log->description); ?></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <?php if(auth()->user()?->hasRole('super-admin')): ?>
                                                <form action="<?php echo e(route('admin.logs.delete', $log->id)); ?>" method="POST" id="deleteForm_<?php echo e($log->id); ?>" style="display:inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="button" class="delete-icon-btn btn-outline-danger me-1" data-title="Delete Log" data-description="Are you sure you want to delete this log?" onclick="deleteAccount(this, <?php echo e($log->id); ?>)">
                                                        <i class="ri-delete-bin-line fs-16"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <button type="button" class="view-icon-btn btn-outline-dark" onclick="viewLogDetails(<?php echo e($log->id); ?>)" title="View Details">
                                                <i class="ri-eye-line fs-16"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                </div>
            </div>

            <!-- Log Details Modal -->
            <div class="modal fade" id="logDetailsModal" tabindex="-1" aria-labelledby="logDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="logDetailsModalLabel">Log Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table info-table mb-0">
                                    <tr>
                                        <th width="200">Date & Time</th>
                                        <td id="modal-date"></td>
                                    </tr>
                                    <tr>
                                        <th>Agent Name</th>
                                        <td id="modal-agent"></td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td id="modal-description"></td>
                                    </tr>
                                    <tr>
                                        <th>Role</th>
                                        <td>
                                            <pre class="mb-0" id="modal-properties"></pre>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>IP Address</th>
                                        <td id="modal-ip_address"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function viewLogDetails(id) {
            // Show loading state

            // Show modal
            var modal = new bootstrap.Modal(document.getElementById('logDetailsModal'));
            modal.show();

            // Fetch log details
            $.ajax({
                url: "<?php echo e(url('admin/logs/view')); ?>/" + id,
                type: 'GET',
                success: function(response) {
                    $('#modal-date').text(response.created_at);
                    $('#modal-agent').text(response.user ? response.user.name : 'Unknown');
                    $('#modal-description').text(response.description);
                    $('#modal-properties').text(response.role);
                    $('#modal-ip_address').text(response.ip_address);
                },
                error: function() {
                    $('#modal-date, #modal-agent, #modal-description, #modal-properties').html('<div class="text-danger">Error loading log details</div>');
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/logs/index.blade.php ENDPATH**/ ?>