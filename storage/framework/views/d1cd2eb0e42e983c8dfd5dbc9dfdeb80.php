<div class="modal fade assign_research" id="standard-modal<?php echo e($client->id); ?>" tabindex="-1" aria-labelledby="standard-modalLabel" style="display: none;" aria-hidden="true">
    <style>
        .selectElement {
            /* position: relative; */
            background-color: #fff;
            border-radius: 10px;
            font-size: 16px;
            line-height: normal;
            color: #444;
            font-weight: 400;
            padding: 13px 15px;
            border: 1px solid #E6EAED;
        }
    </style>
    <div class="modal-dialog modal-dialog-ld">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="standard-modalLabel">Assign Researcher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="assign_research<?php echo e($client->id); ?>" action="<?php echo e(url('admin/clients/assing-researcher')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="client_id" value="<?php echo e($client->id ?? ''); ?>">
                <div class="modal-body g-3">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="validationDefault04" class="form-label">KV Id</label>
                            <input type="text" class="form-control" id="kulvrisk_id" name="kulvrisk_id" value="<?php echo e($client->kulvrisk_id ?? ''); ?>">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="validationDefault04" class="form-label">Researcher Name <?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
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
                            <select class="selectElement form-select js-choice researcher-select" name="researcher_ids[]" multiple>
                                <?php $__currentLoopData = $researchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $researcher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option <?php if($client->researcher_ids != null && in_array($researcher->id, json_decode($client->researcher_ids, true))): ?> selected <?php endif; ?> value="<?php echo e($researcher->id); ?>"><?php echo e($researcher->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <span class="text-danger researcher_ids_error">
                                
                            </span>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-primary">Apply </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(document).ready(function() {
    $('#assign_research<?php echo e($client->id); ?>').on('submit', function(e) {
        e.preventDefault();

        let $form = $(this);
        let $submitBtn = $form.find('button[type="submit"]');
        let originalText = $submitBtn.text();

        $submitBtn.prop('disabled', true).text('Assigning...');

        // Clear old error messages
        $form.find('.text-danger').not('.req-star').text('');

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: $form.serialize(),
            success: function(response) {
                $submitBtn.prop('disabled', false).text(originalText);
                
                // Close the modal
                $('#standard-modal<?php echo e($client->id); ?>').modal('hide');

                Swal.fire({
                    icon: 'success',
                    title: 'Assigned!',
                    text: response.message || 'Researcher assigned successfully!',
                    timer: 5000,
                    confirmButtonText: 'OK',
                }).then(() => {
                    location.reload();
                });
            },
            error: function(xhr) {
                $submitBtn.prop('disabled', false).text(originalText);
                
                const errors = xhr.responseJSON?.errors;
                
                if (errors) {
                    $.each(errors, function(field, messages) {
                        $form.find(`[name="${field}"]`).next('.text-danger').text(messages[0]);
                    });
                    if (errors.researcher_ids) {
                        $('.researcher_ids_error').text(errors.researcher_ids[0]);
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while assigning researcher.',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    });
});
</script>
<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/clients/modals/assing-researcher.blade.php ENDPATH**/ ?>