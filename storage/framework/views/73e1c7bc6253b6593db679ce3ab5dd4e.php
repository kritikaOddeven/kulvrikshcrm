<?php $__env->startSection('pagetitle','Today-Birthday | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
<style>
    .choices__inner{
        background-color: #fff !important;
    }
</style>
    <div class="row py-3 align-items-sm-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">Today's Birthdays</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">WhatsApp</a></li>
                <li class="breadcrumb-item active">Today's Birthdays</li>
            </ol>
        </div>
        <div class="col-auto">
            <div class="d-flex justify-content-end align-items-center gap-2">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('send_birthday_whatsapp')): ?>
                <button id="openCampaignModal" class="btn btn-primary" disabled>Send</button>
                <?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal2848fab3424fc8162748b5c6984d5047 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2848fab3424fc8162748b5c6984d5047 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.filter','data' => ['countries' => $countries]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filter'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['countries' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($countries)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2848fab3424fc8162748b5c6984d5047)): ?>
<?php $attributes = $__attributesOriginal2848fab3424fc8162748b5c6984d5047; ?>
<?php unset($__attributesOriginal2848fab3424fc8162748b5c6984d5047); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2848fab3424fc8162748b5c6984d5047)): ?>
<?php $component = $__componentOriginal2848fab3424fc8162748b5c6984d5047; ?>
<?php unset($__componentOriginal2848fab3424fc8162748b5c6984d5047); ?>
<?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row">
        
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
        <div class="col-12">
            <div class="card">
                <div class="card-body card-body2">
                    <table id="datatable" class="table table-responsive">
                        <thead class="table-info">
                            <tr>
                                <th><input type="checkbox" id="select-all"></th>
                                <th>Name</th>
                                <th>Relation</th>
                                <th>Birth Date</th>
                                <th>Email Id</th>
                                <th>Phone Number</th>
                                <th>Country</th>
                                <th>State</th>
                                <th>City</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $birthdays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $birthday): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><input type="checkbox" class="row-checkbox" value="<?php echo e($birthday['id']); ?>" data-phone="<?php echo e($birthday['phone'] ?? ''); ?>" data-phonecode="<?php echo e($birthday['phonecode'] ?? ''); ?>" data-name="<?php echo e($birthday['name']); ?>" data-id="<?php echo e($birthday['id']); ?>" data-type="<?php echo e($birthday['type']); ?>" data-relation="<?php echo e($birthday['relation']); ?>"></td>
                                    <td><?php echo e($birthday['name']); ?></td>
                                    <td><?php echo e($birthday['relation']); ?></td>
                                    <td><?php echo e($birthday['birth_date'] ? \Carbon\Carbon::parse($birthday['birth_date'])->format('d-m-Y') : '-'); ?></td>
                                    <td><?php echo e($birthday['email'] ?? '-'); ?></td>
                                    <td><?php echo e($birthday['phone'] ?? '-'); ?></td>
                                    <td><?php echo e($birthday['country'] ?? '-'); ?></td>
                                    <td><?php echo e($birthday['state'] ?? '-'); ?></td>
                                    <td><?php echo e($birthday['city'] ?? '-'); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('admin.whatsapp.campaign.send-campaign-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/whatsapp/birthday/today-birthday.blade.php ENDPATH**/ ?>