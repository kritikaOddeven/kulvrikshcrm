<?php $__env->startSection('pagetitle','Expense Category| Kulvriksh'); ?>
<?php $__env->startSection('admin-content'); ?>
    <div class="py-3 row align-items-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">Expense Category</h4>
            
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Category</a></li>
                <li class="breadcrumb-item active">View All Category</li>
            </ol>
        </div>
        <div class="d-flex flex-wrap gap-2 col-auto">

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add_expense_category')): ?>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#expense">
                    + Add Category
                </button>
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
            <div class="card">

                <div class="card-body card-body2">
                    <table id="datatable" class="table table-responsive">
                        <thead class="table-info">
                            <tr>
                                <th style="width: 180px important!">Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th style="width: 200px important!" data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $expense; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item->category); ?></td>
                                    <td class="text-wrap-400"><?php echo e($item->description); ?></td>
                                    <td>
                                        <?php if($item->status === 'active'): ?>
                                            <span class="active-btn">Active</span>
                                        <?php else: ?>
                                            <span class="inactive-btn">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_expense_category')): ?>
                                                <a data-value="<?php echo e($item->id); ?>" class="edit-icon-btn btn-sm btn-action mr-1 editbtn"><i class="ri-edit-line"></i></a>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_expense_category')): ?>
                                                <form action="<?php echo e(url('admin/expenses/category/delete/' . $item->id)); ?>" method="POST" id="deleteForm_<?php echo e($item->id); ?>" style="display:inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-bs-toggle="tooltip" title="delete" data-title="Delete Expense Category" data-description="Are you sure you want to delete this expense category?" onclick="deleteAccount(this, <?php echo e($item->id); ?>)">
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

    <?php echo $__env->make('admin.expense.category.add-edit', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            // 🟢 Add Expense Form
            $('#addExpenseForm').on('submit', function(e) {
                e.preventDefault();
                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');
                $submitBtn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        $form[0].reset();
                        $('#expense').modal('hide');

                        Swal.fire({
                            title: 'Success!',
                            text: response.message || 'Added successfully!',
                            icon: 'success',
                            timer: 5000,
                            confirmButtonText: 'OK',
                        }).then(() => location.reload());
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        $form.find('.text-danger').not('.req-star').text('');
                        $.each(errors, function(field, message) {
                            $form.find(`[name="${field}"]`).next('.text-danger').text(message[0]);
                        });
                        $submitBtn.prop('disabled', false).text('Save');
                    }
                });
            });

            // 🟢 Edit Expense Form
            $('#editExpenseForm').on('submit', function(e) {
                e.preventDefault();
                let $form = $(this);
                let $submitBtn = $form.find('button[type="submit"]');
                $submitBtn.prop('disabled', true).text('Saving...');

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        $form[0].reset();
                        $('#editCatExpense').modal('hide');

                        Swal.fire({
                            title: 'Success!',
                            text: response.message || 'Updated successfully!',
                            icon: 'success',
                            timer: 5000,
                            confirmButtonText: 'OK',
                        }).then(() => location.reload());
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        $form.find('.text-danger').not('.req-star').text('');
                        $.each(errors, function(field, message) {
                            $form.find(`[name="${field}"]`).next('.text-danger').text(message[0]);
                        });
                        $submitBtn.prop('disabled', false).text('Save');
                    }
                });
            });

            // 🟢 Edit Button Click
            $('.editbtn').on('click', function() {
                const expense_id = $(this).data('value');
                $('#editCatExpense').modal('show');

                $.ajax({
                    url: "<?php echo e(url('admin/expenses/category/edit')); ?>/" + expense_id,
                    type: 'GET',
                    success: function(response) {
                        $('#expense_id').val(response.id);
                        $('#category').val(response.category);
                        $('#description').val(response.description);
                        $('#status').val(response.status);
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/expense/category/index.blade.php ENDPATH**/ ?>