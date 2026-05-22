<?php $__env->startSection('pagetitle', 'Bill | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">Bills</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="">Bills</a></li>
                <li class="breadcrumb-item active">View All Bills</li>
            </ol>
        </div>
        
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
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

                <div class="card-body card-body2">
                    <table id="datatable" class="table table-responsive">
                        <thead class="table-info">
                            <tr>
                                <th>KV ID</th>
                                <th>Invoice Number</th>
                                <th>Client Name</th>
                                <th>Services Name</th>
                                <th>Bill Date</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $bills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($bill->client->kulvrisk_id ?? '-'); ?></td>
                                    <td><?php echo e($bill->invoice_number); ?></td>
                                    
                                    
                                    <td>
                                        
                                        <?php echo e(!empty($bill->name) ? $bill->name : trim(optional($bill->client->lead)->first_name . ' ' . optional($bill->client->lead)->middle_name . ' ' . optional($bill->client->lead)->last_name)); ?>

                                    </td>

                                    <td>
                                        <!-- <?php
                                            $subProjectIds = json_decode($bill->sub_project_ids ?? ($bill->client->sub_project_ids ?? '[]'), true) ?: [];
                                            $projectsById = \App\Models\Project::whereIn('id', array_unique($subProjectIds))->get()->keyBy('id');
                                            $names = collect($subProjectIds)->map(fn($id) => $projectsById->get($id)?->name)->filter()->toArray();
                                        ?>
                                                    <?php echo e(implode(', ', $names)); ?> -->
                                        <?php
                                            $names = [];

                                            foreach ($bill->billServices as $svc) {
                                                if ($svc->type === 'project') {
                                                    $names[] = $svc->subProject->name ?? '-';
                                                } else {
                                                    $names[] = $svc->service_name ?? '-';
                                                }
                                            }
                                        ?>

                                        <?php echo e(implode(', ', array_filter($names))); ?>

                                    </td>
                                    
                                    <td data-order="<?php echo e($bill->created_at->timestamp); ?>">
                                        <?php echo e($bill->created_at->format('d M Y')); ?>

                                    </td>

                                    <td>
                                        <span class="status-lead-btn <?php echo e($bill->status == 'paid' ? 'high-lead' : 'close-lead'); ?>">
                                            <?php echo e(ucfirst($bill->status)); ?>

                                        </span>
                                    </td>
                                    <td>₹<?php echo e(number_format(round($bill->amount * 1.18), 2)); ?></td>

                                    <td>
                                        <div class="d-flex gap-2">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_bill')): ?>
                                                <a href="<?php echo e(url('admin/bills/' . $bill->id)); ?>" class="view-icon-btn btn-sm btn-action rounded-pill mr-1" title="view"><i class="ri-eye-line"></i></a>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_bill')): ?>
                                                <a href="<?php echo e(url('admin/bills/edit/' . $bill->id)); ?>" class="edit-icon-btn btn-sm btn-action rounded-pill mr-1" title="edit"><i class="ri-edit-line"></i></a>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_bill')): ?>
                                                <form action="<?php echo e(url('admin/bills/delete/' . $bill->id)); ?>" method="POST" id="deleteForm_<?php echo e($bill->id); ?>" style="display:inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-bs-toggle="tooltip" title="delete" data-title="Delete Bill" data-description="Are you sure you want to delete this Bill?" onclick="deleteAccount(this, <?php echo e($bill->id); ?>)">
                                                        <i class="ri-delete-bin-6-line"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
        <?php $__env->startPush('script'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#datatable').DataTable({
        "destroy": true,
        "order": [[4, "desc"]], // ✅ latest bill first
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/bills/index.blade.php ENDPATH**/ ?>