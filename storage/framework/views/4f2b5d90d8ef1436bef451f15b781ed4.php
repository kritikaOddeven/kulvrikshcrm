<?php $__env->startSection('pagetitle', 'Dashboard | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>


    <div class="py-3">
        <div class="row align-items-center justify-content-between">
            <div class="col-auto mb-3 mb-md-0">
                <h4 class="page-title">Dashboard</h4>
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
    <?php if($smtpAlert): ?>
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
    <?php if(!auth()->user()->hasImapConfigured()): ?>
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

    <!-- Start Main Widgets -->
    <div class="row dash-row">

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">

                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #90AFD0">
                            <i class="ri-user-settings-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Total Agent</p>
                            <h3 class="total-number" style="--dsash-bg-color: #90AFD0"><?php echo e($data['agent']); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">

                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #CA74FF">
                            <i class="ri-user-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Total Client</p>
                            <h3 class="total-number" style="--dsash-bg-color: #CA74FF"><?php echo e($data['client']); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">

                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #F8D347">
                            <i class="ri-user-follow-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Total Lead</p>
                            <h3 class="total-number" style="--dsash-bg-color: #F8D347"><?php echo e($data['lead']); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">

                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #FFA500">
                            <i class="ri-user-follow-fill"></i>
                        </span>

                        <div>
                            <p class="total-title">Lead To Client</p>
                            <h3 class="total-number" style="--dsash-bg-color: #FFA500"><?php echo e($data['leadClient']); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">

                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #5CC35C">
                            <i class="ri-money-dollar-circle-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Monthly Income</p>
                            <h3 class="total-number" style="--dsash-bg-color: #5CC35C">₹ <span class="total-number"><?php echo e($data['income']); ?></span></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">

                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #FF6C60">
                            <i class="ri-money-dollar-box-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Monthly Expense</p>
                            <h3 class="total-number" style="--dsash-bg-color: #FF6C60">₹ <span class="total-number"><?php echo e(number_format($data['expense'], 2)); ?></span></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">

                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #57C8F2">
                            <i class="ri-message-2-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Total Research Submitted</p>
                            <h3 class="total-number" style="--dsash-bg-color: #57C8F2"><?php echo e($data['completed_status']); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">

                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #6CCAC9">
                            <i class="ri-message-3-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Total Research Running</p>
                            <h3 class="total-number" style="--dsash-bg-color: #6CCAC9"><?php echo e($data['running_status']); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">

                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #1E89C8">
                            <i class="ri-vip-crown-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Paid User</p>
                            <h3 class="total-number" style="--dsash-bg-color: #1E89C8"><?php echo e($data['paid']); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">

                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #E58E95">
                            <i class="ri-user-unfollow-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Unpaid User</p>
                            <h3 class="total-number" style="--dsash-bg-color: #E58E95"><?php echo e($data['lead']); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">

                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #90AFD0">
                            <i class="ri-mail-send-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Total Email Sent</p>
                            <h3 class="total-number" style="--dsash-bg-color: #90AFD0">0</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="dash-card-body">
                <div class="widget-first">

                    <div class="d-flex align-items-center">
                        <span class="dash-icon-box" style="--dsash-bg-color: #CA74FF">
                            <i class="ri-whatsapp-line"></i>
                        </span>

                        <div>
                            <p class="total-title">Total Whatsapp Message Sent</p>
                            <h3 class="total-number" style="--dsash-bg-color: #CA74FF">0</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End Main Widgets -->

    <div class="row">
        <!-- Income & Expense -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0">Income & Expense</h5>
                    </div>
                </div>
                <div class="pad-15">
                    <div style="height: 400px;">
                        <canvas id="incomeExpenseChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paid & Unpaid Users -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0">Paid & Unpaid Users</h5>
                    </div>
                </div>
                <div class="pad-15">
                    <div style="height: 400px;">
                        <?php if($data['paid'] == 0 && $data['lead'] == 0): ?>
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <h5 class="text-muted mb-0">No Data Found</h5>
                            </div>
                        <?php else: ?>
                            <canvas id="paidUnpaidChart"></canvas>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Due Research Table -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Due Research</h5>
        </div>
        <div class="card-body card-body2 table-responsive">
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
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data['latestResearchers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $assign_researchers = getResearchersWithNames(json_decode($client->researcher_ids ?? '[]', true))['researchers'];
                            $projectData = getProjectsWithNames('parent', json_decode($client->project_ids ?? '[]', true));
                            // Calculate overdue days
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
                                <div>
                                    <?php $__currentLoopData = $assign_researchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $researcher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="me-2"><?php echo e($researcher->name); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </td>
                            <td><?php echo e($projectData['names']); ?></td>
                            <td><?php echo e($client->start_date ? \Carbon\Carbon::parse($client->start_date)->format('m-d-Y') : ''); ?></td>
                            <td><?php echo e($client->end_date ? \Carbon\Carbon::parse($client->end_date)->format('m-d-Y') : ''); ?></td>
                            <td><?php echo e($overdueDays !== '' ? $overdueDays . ' Days' : ''); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Income & Expense Bar Chart
        const incomeData = <?php echo json_encode($data['incomeData'], 15, 512) ?>;
        const expenseData = <?php echo json_encode($data['expenseData'], 15, 512) ?>;

        const incomeExpenseCtx = document.getElementById('incomeExpenseChart').getContext('2d');
        new Chart(incomeExpenseCtx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'
                ],
                datasets: [{
                        label: 'Income',
                        data: incomeData,
                        backgroundColor: 'rgba(46, 204, 113, 0.8)',
                        borderColor: 'rgba(46, 204, 113, 1)',
                        borderWidth: 1,
                        borderRadius: 5
                    },
                    {
                        label: 'Expense',
                        data: expenseData,
                        backgroundColor: 'rgba(231, 76, 60, 0.8)',
                        borderColor: 'rgba(231, 76, 60, 1)',
                        borderWidth: 1,
                        borderRadius: 5
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            padding: 20,
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ₹${context.raw.toLocaleString()}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₹' + value.toLocaleString();
                            },
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });


        // Paid & Unpaid Users Doughnut Chart
        
        <?php if($data['paid'] != 0 || $data['lead'] != 0): ?>

            const paidUsers = <?php echo json_encode($data['paid'], 15, 512) ?>;
            const unpaidUsers = <?php echo json_encode($data['lead'], 15, 512) ?>;
            const totalUsers = paidUsers + unpaidUsers;

            const paidUnpaidCtx = document.getElementById('paidUnpaidChart').getContext('2d');
            new Chart(paidUnpaidCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Paid', 'Unpaid'],
                    datasets: [{
                        data: [paidUsers, unpaidUsers],
                        backgroundColor: [
                            'rgba(52, 152, 219, 0.8)',
                            'rgba(241, 148, 138, 0.8)'
                        ],
                        borderColor: [
                            'rgba(52, 152, 219, 1)',
                            'rgba(241, 148, 138, 1)'
                        ],
                        borderWidth: 2,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    const percent = ((value / totalUsers) * 100).toFixed(1);
                                    return `${context.label}: ${value} (${percent}%)`;
                                }
                            }
                        }
                    }
                }
            });
    </script>
    <?php endif; ?>

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>