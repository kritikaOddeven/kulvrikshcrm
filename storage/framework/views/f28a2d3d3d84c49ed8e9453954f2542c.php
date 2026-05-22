<?php $__env->startSection('pagetitle','Research Report | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
    <div class="py-3 row align-items-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">Total Research Reort</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                <li class="breadcrumb-item active">Total Research Report</li>
            </ol>
        </div>
        <div class="d-flex flex-wrap gap-2 col-auto">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('researcher_report_export')): ?>
            <a href="<?php echo e(url('admin/reports/researcher?export=csv')); ?>" type="button" class="btn btn-primary">
                <i class="ri-download-2-line"></i> Export to CSV
            </a>
            <?php endif; ?>
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
            <form action="<?php echo e(url('admin/reports/researcher')); ?>" method="GET">
                <div class="report-filterbox">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="position-relative">
                                <input type="text" class="form-control flatpickr-input active" id="rangecalendar-datepicker" name="date_range" value="<?php echo e(request('date_range')); ?>" placeholder="From - To" readonly="readonly">
                                <i class="ri-calendar-2-line calendar-icon"></i>
                            </div>
                        </div>

                        <div class="col-md-3 mb-2">
                            <select class="form-select" name="client_id">
                                <option selected disabled>Select Client</option>
                                <?php $__currentLoopData = $researchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($client->id); ?>" <?php echo e(request('client_id') == $client->id ? 'selected' : ''); ?>>
                                        <?php echo e($client->lead->first_name); ?> <?php echo e($client->lead->middle_name); ?> <?php echo e($client->lead->last_name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <select class="form-select" name="researcher_id">
                                <option selected disabled>Select Researcher</option>
                                <?php $__currentLoopData = $researchersName; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $researcher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($researcher->id); ?>" <?php echo e(request('researcher_id') == $researcher->id ? 'selected' : ''); ?>>
                                        <?php echo e($researcher->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3 mb-2 text-end">
                            <?php if(request('date_range') || request('client_id') || request('researcher_id')): ?>
                                <a href="<?php echo e(url('admin/reports/researcher')); ?>" class="btn btn-danger me-2">
                                    <i class="ri-filter-off-line me-1"></i> Clear Filters
                                </a>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-success">
                                Generate Report
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card">
                <div class="card-body card-body2">
                    <table id="datatable" class="table table-responsive">
                        <thead class="table-info">
                            <tr>
                                <th>KV ID</th>
                                <th>Client Name</th>
                                <th>Researcher Name</th>
                                <th>Project Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Overdue</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $researchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $researcher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <?php
                                        $assign_researchers = getResearchersWithNames(json_decode($researcher->researcher_ids ?? '[]', true))['researchers'];
                                        $projectData = getProjectsWithNames('parent', json_decode($researcher->project_ids ?? '[]', true));
                                        // Calculate overdue days
                                        $overdueDays = '';
                                        if ($researcher->end_date) {
                                            $endDate = \Carbon\Carbon::parse($researcher->end_date);
                                            $today = \Carbon\Carbon::now();

                                            if ($endDate->isPast()) {
                                                $overdueDays = abs((int) $today->diffInDays($endDate));
                                            } else {
                                                $overdueDays = 0;
                                            }
                                        }
                                    ?>
                                    <td><?php echo e($researcher->kulvrisk_id); ?></td>
                                    <td><?php echo e($researcher->lead->first_name); ?> <?php echo e($researcher->lead->middle_name); ?> <?php echo e($researcher->lead->last_name); ?></td>
                                    <td>
                                        <div>
                                            <?php $__currentLoopData = $assign_researchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $researcherName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="me-2"><?php echo e($researcherName->name); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </td>
                                    <td><?php echo e($projectData['names']); ?></td>
                                    <td><?php echo e($researcher->start_date ?? ''); ?></td>
                                    <td><?php echo e($researcher->end_date ?? ''); ?></td>
                                    <td><?php echo e($overdueDays !== '' ? $overdueDays . ' days' : ''); ?></td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#rangecalendar-datepicker", {
                mode: "range",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "Y-m-d to Y-m-d",
                allowInput: true
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/reports/total-researcher.blade.php ENDPATH**/ ?>