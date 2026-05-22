<div>
    <?php if(session('success') || session('error') || session('info') || session('failed')): ?>
        <?php
            $type = session('success') ? 'success' : (session('error') || session('failed') ? 'danger' : 'info');
            $message = session('success') ?? (session('error') ?? session('info')) ?? session('failed');
        ?>

        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition class="alert alert-<?php echo e($type); ?> alert-dismissible fade show mt-3" role="alert">
            <?php echo e($message); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

</div><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/components/custom-alert.blade.php ENDPATH**/ ?>