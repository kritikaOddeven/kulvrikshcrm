<?php $__env->startSection('pagetitle', 'Researcher Dashboard | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>

    <div class="py-3">
        <div class="row align-items-center justify-content-between">
            <div class="col-auto mb-3 mb-md-0">
                <h4 class="page-title">Researcher Dashboard</h4>
            </div>
            <div class="col-auto">
                <form method="GET" class="d-flex flex-wrap gap-2 justify-content-end">
                    <div class="position-relative">
                        <input type="text" class="form-control flatpickr-input active dash-input-filter" id="rangecalendar-datepicker" name="date_range" value="<?php echo e(request('date_range')); ?>" placeholder="From - To" readonly="readonly">
                        <i class="ri-calendar-2-line calendar-icon position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%);"></i>
                    </div>

                    <div class="d-flex align-items-end">
                        <?php if(request('date_range')): ?>
                            <a href="<?php echo e(url('admin/dashboard')); ?>" class="btn btn-danger">
                                <i class="ri-filter-off-line me-1"></i> Clear Filters
                            </a>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary ms-2">
                            <i class="ri-filter-3-line me-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- SMTP Configuration Alert -->
    <?php if($smtpAlert && auth()->user()->hasPermissionTo('smtp_setup')): ?>
        <?php if (isset($component)) { $__componentOriginald395c6fcfff316da5fbc1e85629fc469 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald395c6fcfff316da5fbc1e85629fc469 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.smtp-alert','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('smtp-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald395c6fcfff316da5fbc1e85629fc469)): ?>
<?php $attributes = $__attributesOriginald395c6fcfff316da5fbc1e85629fc469; ?>
<?php unset($__attributesOriginald395c6fcfff316da5fbc1e85629fc469); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald395c6fcfff316da5fbc1e85629fc469)): ?>
<?php $component = $__componentOriginald395c6fcfff316da5fbc1e85629fc469; ?>
<?php unset($__componentOriginald395c6fcfff316da5fbc1e85629fc469); ?>
<?php endif; ?>
    <?php endif; ?>

    <!-- Bank Account Configuration Alert -->
    <?php if($bankingAlert): ?>
        <?php if (isset($component)) { $__componentOriginal84051ecaf83456757bbfd03a740de521 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal84051ecaf83456757bbfd03a740de521 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.account-alert','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('account-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal84051ecaf83456757bbfd03a740de521)): ?>
<?php $attributes = $__attributesOriginal84051ecaf83456757bbfd03a740de521; ?>
<?php unset($__attributesOriginal84051ecaf83456757bbfd03a740de521); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal84051ecaf83456757bbfd03a740de521)): ?>
<?php $component = $__componentOriginal84051ecaf83456757bbfd03a740de521; ?>
<?php unset($__componentOriginal84051ecaf83456757bbfd03a740de521); ?>
<?php endif; ?>
    <?php endif; ?>

    <!-- IMAP Configuration Alert -->
    <?php if(!auth()->user()->hasImapConfigured() && auth()->user()->hasPermissionTo('imap_setup')): ?>
        <?php if (isset($component)) { $__componentOriginalc55625859667b53d663d3ae7f7fcb32e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc55625859667b53d663d3ae7f7fcb32e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.imap-alert','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('imap-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc55625859667b53d663d3ae7f7fcb32e)): ?>
<?php $attributes = $__attributesOriginalc55625859667b53d663d3ae7f7fcb32e; ?>
<?php unset($__attributesOriginalc55625859667b53d663d3ae7f7fcb32e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc55625859667b53d663d3ae7f7fcb32e)): ?>
<?php $component = $__componentOriginalc55625859667b53d663d3ae7f7fcb32e; ?>
<?php unset($__componentOriginalc55625859667b53d663d3ae7f7fcb32e); ?>
<?php endif; ?>
    <?php endif; ?>
    
    <div class="row dash-row">
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">
                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #90AFD0">
                            <i class="ri-user-line"></i>
                        </span>
                        <div>
                            <p class="total-title">Total Research</p>
                            <h3 class="total-number" style="--dsash-bg-color: #90AFD0"><?php echo e($totalResearch ?? 0); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">
                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #CA74FF">
                            <i class="ri-user-follow-line"></i>
                        </span>
                        <div>
                            <p class="total-title">Running Research</p>
                            <h3 class="total-number" style="--dsash-bg-color: #CA74FF"><?php echo e($runningResearch ?? 0); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">
                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #5CC35C">
                            <i class="ri-user-heart-line"></i>
                        </span>
                        <div>
                            <p class="total-title">Submitted Research</p>
                            <h3 class="total-number" style="--dsash-bg-color: #5CC35C"><?php echo e($completeResearch ?? 0); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">
                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #5CC35C">
                            <i class="ri-user-heart-line"></i>
                        </span>
                        <div>
                            <p class="total-title">Joint Research Count</p>
                            <h3 class="total-number" style="--dsash-bg-color: #5CC35C"><?php echo e($jointResearch ?? 0); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Due Research</h5>
        </div>
        <div class="card-body card-body2">
            <table id="datatable" class="table">
                <thead class="table-light">
                    <tr>
                        <th>KV ID</th>
                        <th>Client Name</th>
                        <th>Researcher Name</th>
                        <th>Project Name</th>
                        <th>Start Date</th>
                        <th>Due Date</th>
                        <th>Overdue</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $assign_researchers = getResearchersWithNames(json_decode($client->researcher_ids ?? '[]', true))['researchers'];
                            $projectData = getProjectsWithNames('parent', json_decode($client->project_ids ?? '[]', true));
                            $overdueDays = '';
                            if ($client->end_date) {
                                $endDate = \Carbon\Carbon::parse($client->end_date);
                                $today = \Carbon\Carbon::now();
                                if ($endDate->isPast()) {
                                    $overdueDays = abs((int) $today->diffInDays($endDate));
                                } else {
                                    $overdueDays = 0;
                                }
                            }
                        ?>
                        <tr>
                            <td><?php echo e($client->kulvrisk_id); ?></td>
                            <td><?php echo e($client->lead->first_name ?? ''); ?> <?php echo e($client->lead->middle_name ?? ''); ?> <?php echo e($client->lead->last_name ?? ''); ?></td>
                            <td>
                                <?php $__currentLoopData = $assign_researchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $researcher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span><?php echo e($researcher->name); ?></span>
                                    <?php if(!$loop->last): ?>
                                        ,
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                            <td><?php echo e($projectData['names']); ?></td>
                            <td><?php echo e($client->start_date ? \Carbon\Carbon::parse($client->start_date)->format('m-d-Y') : ''); ?></td>
                            <td><?php echo e($client->end_date ? \Carbon\Carbon::parse($client->end_date)->format('m-d-Y') : ''); ?></td>
                            <td><?php echo e($overdueDays !== '' ? $overdueDays . ' Days' : ''); ?></td>
                            <td><?php echo e($client->research_status == 'completed' ? 'Submitted' : ucfirst($client->research_status)); ?></td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/dashboard-researcher.blade.php ENDPATH**/ ?>