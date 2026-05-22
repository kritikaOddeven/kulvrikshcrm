<?php $__env->startSection('pagetitle', 'Income-Expense Report | Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
    <div class="py-3 row align-items-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">Income Expense Report</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
                <li class="breadcrumb-item active">Income Expense Report</li>
            </ol>
        </div>
        <div class="d-flex flex-wrap gap-2 col-auto">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('income_expense_report_export')): ?>
                <a href="<?php echo e(request()->fullUrlWithQuery(['export' => 'csv'])); ?>" type="button" class="btn btn-primary"><i class="ri-download-2-line"></i> Export To CSV</a>
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
            <form action="<?php echo e(url('admin/reports/income-expense')); ?>" method="GET">
                <div class="report-filterbox">
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-8">
                            <div class="row">

                                <div class="col-md-4 mb-2">
                                    <div class="position-relative">
                                        <input type="text" class="form-control flatpickr-input active" id="rangecalendar-datepicker" name="date_range" placeholder="From - To" readonly="readonly" value="<?php echo e(request('date_range')); ?>">
                                        <input type="hidden" name="start_date" value="<?php echo e(request('start_date')); ?>">
                                        <input type="hidden" name="end_date" value="<?php echo e(request('end_date')); ?>">
                                        <i class="ri-calendar-2-line calendar-icon"></i>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-2">
                                    <select class="form-select" name="type" id="transaction-type">
                                        <option value="">All Transactions</option>
                                        <option value="credit" <?php echo e(request('type') === 'credit' ? 'selected' : ''); ?>>Credit</option>
                                        <option value="debit" <?php echo e(request('type') === 'debit' ? 'selected' : ''); ?>>Debit</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-2" id="category-filter" style="display: none;">
                                    <select class="form-select" name="category_id">
                                        <option value="">All Categories</option>
                                        <?php $__currentLoopData = $expenseCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>" <?php echo e(request('category_id') == $category->id ? 'selected' : ''); ?>><?php echo e($category->category); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-2 text-end" id="filter-buttons">
                            <?php if(request('date_range') || request('type') || request('category_id')): ?>
                                <a href="<?php echo e(url('admin/reports/income-expense')); ?>" class="btn btn-danger mb-2">
                                    <i class="ri-filter-off-line me-1"></i> Clear Filters
                                </a>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-success mb-2 ms-2">
                                <i class="ri-file-list-3-line me-1"></i> Generate Report
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p>Opening Balance</p>
                        <p class="text-end"><strong>₹<?php echo e($account->opening_balance ?? ''); ?></strong></p>
                        
                    </div>

                </div>
                <div class="card-body card-body2">
                    <div class="table-responsive">
                        <table id="datatable" class="table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="table-info">
                                <tr>
                                    <th>Date</th>
                                    <th class="text-wrap-400">Description</th>
                                    <th>Credit</th>
                                    <th>Debit</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($transaction['date']->format('d M Y')); ?></td>
                                        <td class="text-wrap-400"><?php echo e($transaction['description']); ?></td>
                                        <td>₹<?php echo e(number_format($transaction['credit'], 2)); ?></td>
                                        <td>₹<?php echo e(number_format($transaction['debit'], 2)); ?></td>
                                        <td>₹<?php echo e(number_format($transaction['total_amount'], 2)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const transactionType = document.getElementById('transaction-type');
            const categoryFilter = document.getElementById('category-filter');

            // Function to toggle category filter visibility
            function toggleCategoryFilter() {
                if (transactionType.value === 'debit') {
                    categoryFilter.style.display = 'block';
                } else {
                    categoryFilter.style.display = 'none';
                    // Clear category selection when hidden
                    categoryFilter.querySelector('select').value = '';
                }
            }

            // Initial check
            toggleCategoryFilter();

            // Listen for changes
            transactionType.addEventListener('change', toggleCategoryFilter);
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/reports/income-expense.blade.php ENDPATH**/ ?>