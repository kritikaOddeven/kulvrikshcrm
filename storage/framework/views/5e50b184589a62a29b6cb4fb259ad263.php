
<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSeven" aria-expanded="false" aria-controls="panelsStayOpen-collapseSeven">
            Children Information
        </button>
    </h2>
    <div id="panelsStayOpen-collapseSeven" class="accordion-collapse collapse">
        <div class="accordion-body">
            <table class="table info-table">
                <thead>
                    <tr>
                        <th>Gender</th>
                        <th>Children Name</th>
                        <th>Birth Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>

                            <td class="ps-3"><span><?php echo e(ucfirst($item->gender ?? '')); ?></span></td>

                            <td class="ps-3"><span><?php echo e($item->name ?? ''); ?></span></td>


                            <td class="ps-3"><span><?php echo e($item->birth_date ?? ''); ?></span></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/leads/details/children-info.blade.php ENDPATH**/ ?>