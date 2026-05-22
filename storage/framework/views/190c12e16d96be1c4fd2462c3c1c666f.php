

<div>
    <?php if(session('success') || session('error') || session('info') || session('failed')): ?>
        <?php
            $type = session('success') ? 'success' : (session('error') || session('failed') ? 'error' : 'info');
            $message = session('success') ?? (session('error') ?? session('info') ?? session('failed'));
        ?>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: '<?php echo e($type); ?>',
                    title: '<?php echo e(ucfirst($type)); ?>',
                    text: <?php echo json_encode($message, 15, 512) ?>,
                    timer: 5000,
                    confirmButtonText: 'OK',
                });
            });
        </script>
    <?php endif; ?>
</div>
<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/components/alert.blade.php ENDPATH**/ ?>