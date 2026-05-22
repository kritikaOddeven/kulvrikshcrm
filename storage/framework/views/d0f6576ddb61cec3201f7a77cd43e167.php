
<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
            Family Information
        </button>
    </h2>
    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
        <div class="accordion-body">
            <table class="table info-table">
                <thead>
                    <tr>
                        <th>Relation</th>
                        <th>Name</th>
                        <th>Date Of Birth</th>
                        <th>Marriage Date</th>
                        <th>Death Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data->families->whereIn('belongs_to', 'lead'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e(ucfirst($item->relation)); ?></td>
                            <td><?php echo e($item->name); ?></td>
                            <td><?php echo e($item->birth_date); ?></td>
                            <td><?php echo e($item->marriage_date); ?></td>
                            <td><?php echo e($item->death_date); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <table class="table info-table">
                <thead>
                    <tr>
                        <th>Relation</th>
                        <th>Name</th>
                        <th>Date Of Birth</th>
                        <th>Death Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data->siblings->whereIn('belongs_to', 'lead'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e(ucfirst($item->relation)); ?></td>
                            <td><?php echo e($item->name); ?></td>
                            <td><?php echo e($item->birth_date); ?></td>
                            <td><?php echo e($item->death_date); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div class="row">
                <div class="col-12 mb-2">
                    <label for="notes" class="form-label">Ancestor History Notes</label>
                    <textarea class="form-control" readonly name="lead_ancestor_notes" rows="3"><?php echo e($data->lead_ancestor_notes); ?></textarea>
                </div>
            </div>

        </div>
    </div>
</div>
<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/leads/details/family-info.blade.php ENDPATH**/ ?>