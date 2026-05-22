<?php
    $projects = \App\Models\Project::parent()->status('active')->get();
    $accounts = \App\Models\BankAccount::where('status', 'active')->get();
?>

<div class="modal fade" id="existingBill" tabindex="-1" aria-labelledby="existingBillLabel" style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="existingBillLabel">Generate Bill</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(url('admin/clients/generate-bill')); ?>" method="POST" id="generateExistingBillForm">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="client_id" value="<?php echo e($client->id ?? ''); ?>">
                <input type="hidden" name="amount" id="existing_bill_amount" value="0">
                <div class="modal-body g-3">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Invoice Number<?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7 = $attributes; } ?>
<?php $component = App\View\Components\RequiredStar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\RequiredStar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $attributes = $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $component = $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?></label>
                            <input type="text" class="form-control" name="invoice_number"
                                value="<?php echo e(generate_invoice_number()); ?>" readonly>
                        </div>

                        <div class="col-md-6 mb-2">
                            <label class="form-label">KV Id</label>
                            <input type="text" class="form-control" name="kulvrisk_id"
                                value="<?php echo e($client->kulvrisk_id ?? ''); ?>">
                        </div>

                        <div class="col-md-12 mb-2">
                            <label class="form-label">Select Bank <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7 = $attributes; } ?>
<?php $component = App\View\Components\RequiredStar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\RequiredStar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $attributes = $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $component = $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?></label>
                            <select class="form-select" name="bank_account_id" required>
                                <option selected disabled>Select Bank Account</option>
                                <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>"><?php echo e($item->bank_name); ?> - <?php echo e($item->account_number); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="text-danger">
                                <?php $__errorArgs = ['bank_account_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <?php echo e($message); ?>

                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </span>
                        </div>
                    </div>

                    <hr>

                    <div class="row dynamic-group-existing mb-2" data-index="0">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Project Name<?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7 = $attributes; } ?>
<?php $component = App\View\Components\RequiredStar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\RequiredStar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $attributes = $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $component = $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?></label>
                            <select class="form-select project-select-existing" name="project_ids[]" data-index="0" required>
                                <option selected disabled>Select Project</option>
                                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($project->id); ?>"><?php echo e($project->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Sub Project Name<?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7 = $attributes; } ?>
<?php $component = App\View\Components\RequiredStar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\RequiredStar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $attributes = $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $component = $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?></label>
                            <select class="form-select subproject-select-existing" name="sub_project_ids[]"
                                data-index="0" required disabled>
                                <option selected disabled>Select Sub Project</option>
                            </select>
                        </div>
                    </div>

                    <div id="existingDynamicContainer"></div>

                    <div class="row justify-content-between mb-2">
                        <div class="col-auto">
                            <button id="existingAddMore" class="btn btn-sm btn-primary">+ Add More</button>
                        </div>
                        <div class="col-auto">
                            <button id="existingDelete" class="btn btn-sm btn-danger" style="display: none">
                                <i class="ri-delete-bin-line"></i> Delete
                            </button>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <table class="table info-table" id="existingBillServicesTable">
                                <thead>
                                    <tr>
                                        <th>Service Name</th>
                                        <th>Sub Service Name</th>
                                        <th class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-end fw-bold">Total</td>
                                        <td class="fw-bold text-end" id="existingBillTotalAmount">₹0.00</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-primary">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        let existingCount = 1;

        function formatCurrency(amount) {
            const value = parseFloat(amount || 0);
            return '₹' + value.toLocaleString('en-IN', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function updateTableFromSelections() {
            const $tbody = $('#existingBillServicesTable tbody');
            $tbody.empty();

            let total = 0;

            $('.dynamic-group-existing').each(function() {
                const $group = $(this);
                const $projectSelect = $group.find('.project-select-existing');
                const $subSelect = $group.find('.subproject-select-existing');

                const projectName = $projectSelect.find('option:selected').text();
                const subProjectName = $subSelect.find('option:selected').text();
                const amount = parseFloat($subSelect.find('option:selected').data('amount')) || 0;

                if (projectName && subProjectName && amount > 0) {
                    total += amount;
                    $tbody.append(
                        `<tr>
                            <td>${projectName}</td>
                            <td>${subProjectName}</td>
                            <td class="text-end">${formatCurrency(amount)}</td>
                        </tr>`
                    );
                }
            });

            $('#existingBillTotalAmount').text(formatCurrency(total));
            $('#existing_bill_amount').val(total.toFixed(2));
        }

        function buildProjectOptions() {
            const data = <?php echo json_encode($projects, 15, 512) ?>;
            return data.map(p => `<option value="${p.id}">${p.name}</option>`).join('');
        }

        $('#existingAddMore').click(function(e) {
            e.preventDefault();

            const index = existingCount++;
            $('#existingDelete').show();

            const projectOptions = buildProjectOptions();

                    const group = `
                <div class="row dynamic-group-existing mb-2" data-index="${index}">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Project Name<?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7 = $attributes; } ?>
<?php $component = App\View\Components\RequiredStar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\RequiredStar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $attributes = $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $component = $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?></label>
                        <select class="form-select project-select-existing" name="project_ids[]" data-index="${index}" required>
                            <option selected disabled>Select Project</option>
                            ${projectOptions}
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Sub Project Name<?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7 = $attributes; } ?>
<?php $component = App\View\Components\RequiredStar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('required-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\RequiredStar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $attributes = $__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__attributesOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7)): ?>
<?php $component = $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7; ?>
<?php unset($__componentOriginal27abc86fb91a36b7c85cb140e4c313c7); ?>
<?php endif; ?></label>
                        <select class="form-select subproject-select-existing" name="sub_project_ids[]"
                            data-index="${index}" required disabled>
                            <option selected disabled>Select Sub Project</option>
                        </select>
                    </div>
                </div>
            `;

            $('#existingDynamicContainer').append(group);
        });

        $('#existingDelete').click(function(e) {
            e.preventDefault();

            const $groups = $('#existingDynamicContainer .dynamic-group-existing');
            if ($groups.length === 0) {
                return;
            }

            const $lastGroup = $groups.last();
            $lastGroup.remove();
            updateTableFromSelections();

            if ($('#existingDynamicContainer .dynamic-group-existing').length === 0) {
                $('#existingDelete').hide();
                existingCount = 1;
            }
        });

        $(document).on('change', '.project-select-existing', function() {
            const projectId = $(this).val();
            const index = $(this).data('index');
            const $subSelect = $(`.subproject-select-existing[data-index="${index}"]`);

            $subSelect.empty().append('<option selected disabled>Select Sub Project</option>').prop('disabled', true);

            if (!projectId) {
                return;
            }

            $.ajax({
                url: `/admin/get-subprojects/${projectId}`,
                type: 'GET',
                success: function(res) {
                    let options = '<option selected disabled>Select Sub Project</option>';
                    res.forEach(function(sub) {
                        options += `<option value="${sub.id}" data-amount="${sub.amount}">${sub.name}</option>`;
                    });
                    $subSelect.html(options).prop('disabled', false);
                },
                error: function() {
                    $subSelect.html('<option>Error loading subprojects</option>').prop('disabled', true);
                }
            });
        });

        $(document).on('change', '.subproject-select-existing', function() {
            updateTableFromSelections();
        });

        $('#existingBill').on('shown.bs.modal', function() {
            $('#generateExistingBillForm')[0].reset();
            $('#existingBillServicesTable tbody').empty();
            $('#existingBillTotalAmount').text('₹0.00');
            $('#existing_bill_amount').val('0');

            $('.dynamic-group-existing').not('[data-index="0"]').remove();
            existingCount = 1;

            const $firstProject = $('.project-select-existing[data-index="0"]');
            const $firstSub = $('.subproject-select-existing[data-index="0"]');

            $firstProject.val('');
            $firstSub.empty().append(
                '<option selected disabled>Select Sub Project</option>').prop('disabled', true);

            $('#existingDelete').hide();
        });
    });
</script>
<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/bills/modals/generate-bill-existing-client.blade.php ENDPATH**/ ?>