<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    
    <title><?php echo $__env->yieldContent('pagetitle'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc." />
    <meta name="author" content="Zoyothemes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset('assets/admin/images/favicon.ico')); ?>">

    <!-- Datatables css -->
    <link href="<?php echo e(asset('assets/admin/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/admin/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/admin/libs/datatables.net-keytable-bs5/css/keyTable.bootstrap5.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/admin/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/admin/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css')); ?>" rel="stylesheet" type="text/css" />

    <script src="<?php echo e(asset('assets/admin/js/head.js')); ?>"></script>
    <!-- App css -->
    <link href="<?php echo e(asset('assets/admin/css/app.min.css')); ?>" rel="stylesheet" type="text/css" id="app-style" />
    

    <!-- Flatpickr Timepicker css -->
    <link href="<?php echo e(asset('assets/admin/libs/flatpickr/flatpickr.min.css')); ?>" rel="stylesheet" type="text/css" />

    <!-- Icons -->
    
    <link href="<?php echo e(asset('assets/admin/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css" integrity="sha512-kJlvECunwXftkPwyvHbclArO8wszgBGisiLeuDFwNM8ws+wKIw0sv1os3ClWZOcrEB2eRXULYUsm8OVRGJKwGA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.css">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 Bootstrap 5 Theme CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.6.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet">
    </link>

    <link href="<?php echo e(asset('assets/admin/css/custom.css')); ?>" rel="stylesheet" type="text/css" id="app-style" />

</head>
<style>
    /* Remove spinners */
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    .swal2-html-container,
    .swal2-popup {
        padding: 0 !important;
    }

    .swal2-html-container {
        border-radius: 15px;
    }

    .swal2-popup {
        border-radius: 15px;
    }

    .swal2-cancel.swal2-styled {
        background: #fff !important;
        color: #000 !important;
        border: 1px solid #e6eaed !important;
    }

    .swal2-popup.swal2-modal.swal2-icon-warning{
        padding: 0 15px 40px !important;
    }

    /*  */


    .calendar-icon {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        color: #666;
        pointer-events: none;
        /* icon won't interfere with input clicks */
    }


    /* Select 2 */
    .select2 {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single {
        height: calc(2.375rem + 2px);
        /* same as .form-control height */
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #212529;
        line-height: 1.5;
        padding-left: 0;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100%;
        right: 10px;
    }

    .select2-container--default .select2-selection--single:focus {
        border-color: none !important;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, .25);
    }

    .datatable,
    #datatable,
    .dataTable,
    table.dataTable {
        width: 100% !important;
    }

    .choices {
        margin-bottom: 0 !important;
    }

    .swal2-actions {
        padding-bottom: 20px !important;
    }

    .choices[data-type*=select-one] .choices__inner {
        padding-bottom: 2.5px !important;
    }

    .choices__inner {
        padding: 4.5px 4.5px 0.75px !important;
        min-height: 30px !important;
    }
</style>

<script src="//unpkg.com/alpinejs" defer></script>

<!-- body start -->

<body data-menu-color="light" data-sidebar="default">

    <!-- Begin page -->
    <div id="app-layout">

        <!-- Topbar Start -->
        <?php echo $__env->make('admin.partials._header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- end Topbar -->

        <!-- Left Sidebar Start -->
        <?php echo $__env->make('admin.partials._sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    
                    <?php if(app()->environment('local') && $errors->any()): ?>
                        <?php
                            $fields = collect($errors->keys())->map(fn($key) => ucfirst(str_replace('_', ' ', $key)))->implode(', ');
                        ?>
                        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            <strong>We couldn't save your submission due to issues with the following fields:</strong> <?php echo e($fields); ?>.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php echo $__env->yieldContent('admin-content'); ?>
                </div> <!-- container-fluid -->
            </div> <!-- content -->

            <!-- Footer Start -->
            <?php echo $__env->make('admin.partials._footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <!-- end Footer -->

        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <script>
        // Push a few dummy history states to block back navigation
        history.pushState(null, null, location.href);
        history.pushState(null, null, location.href);
        history.pushState(null, null, location.href);
        history.pushState(null, null, location.href);

        window.onpopstate = function() {
            history.go(1);
        };
    </script>

    <!-- Vendor -->
    <script src="<?php echo e(asset('assets/admin/libs/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/libs/simplebar/simplebar.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/libs/node-waves/waves.min.js')); ?>"></script>
    
    
    <script src="<?php echo e(asset('assets/admin/libs/feather-icons/feather.min.js')); ?>"></script>

    <!-- Datatables js -->
    <script src="<?php echo e(asset('assets/admin/libs/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>

    <!-- dataTables.bootstrap5 -->
    <script src="<?php echo e(asset('assets/admin/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/libs/datatables.net-buttons/js/dataTables.buttons.min.js')); ?>"></script>
    <!-- dataTables.keyTable -->
    <script src="<?php echo e(asset('assets/admin/libs/datatables.net-keytable/js/dataTables.keyTable.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/libs/datatables.net-keytable-bs5/js/keyTable.bootstrap5.min.js')); ?>"></script>

    <!-- dataTable.responsive -->
    <script src="<?php echo e(asset('assets/admin/libs/datatables.net-responsive/js/dataTables.responsive.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js')); ?>"></script>

    <!-- dataTables.select -->
    <script src="<?php echo e(asset('assets/admin/libs/datatables.net-select/js/dataTables.select.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/libs/datatables.net-select-bs5/js/select.bootstrap5.min.js')); ?>"></script>

    <!-- Datatable Demo App Js -->
    <script src="<?php echo e(asset('assets/admin/js/pages/datatable.init.js')); ?>"></script>
    <!-- App js-->
    <script src="<?php echo e(asset('assets/admin/js/app.js')); ?>"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />

    <!-- Flatpickr Timepicker Plugin js -->
    <script src="<?php echo e(asset('assets/admin/libs/flatpickr/flatpickr.min.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/admin/js/pages/form-picker.js')); ?>"></script>
    <script src="https://unpkg.com/slim-select@latest/dist/slimselect.min.js"></script>

    <script>
        flatpickr(".basic-datepicker", {
            altInput: true,
            altFormat: "d-m-Y",
            dateFormat: "Y-m-d"
        });

        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.js-choice');

            elements.forEach(function(el) {
                // Only initialize if it hasn't been initialized already
                if (!el.choicesInstance) {
                    el.choicesInstance = new Choices(el, {
                        removeItemButton: true,
                        shouldSort: false,
                    });
                }
            });
        });

        document.querySelectorAll('.selectElement').forEach(function(el) {
            new SlimSelect({
                select: el,
                settings: {
                    showSearch: false,
                }
            });
        });
    </script>


    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo e(asset('assets/admin/js/sweetalert2.js')); ?>"></script>
    <script>
        feather.replace();
    </script>

    
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    
    <script>
        // Also initialize CKEditor for existing editors on page load
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.editor').forEach(function(textarea) {
                if (!textarea.id) {
                    textarea.id = 'editor-' + Date.now() + Math.floor(Math.random() * 1000); // give a unique ID
                }
                CKEDITOR.replace(textarea.id);
            });
        });

        // Select 2 initialization
        $(document).ready(function() {
            $('.select2').select2({
                allowClear: true
            });
        });

        $(document).ready(function() {
            // Listen for submit on any form that contains a .save-btn
            $('form').on('submit', function(e) {
                var $form = $(this);
                var $btn = $form.find('.save-btn');

                // Disable the save button to prevent double submission
                $btn.prop('disabled', true).text('Saving...');
            });
        });
    </script>

    <?php echo $__env->yieldPushContent('script'); ?>

    <script>
        // User status check
        let statusCheckInterval;
        const CHECK_INTERVAL = 10000;

        function checkUserStatus() {
            $.ajax({
                url: '<?php echo e(route("admin.check.status")); ?>',
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status === 'inactive') {
                        showInactivityAlert();
                    }
                },
                error: function() {
                    console.error('Error checking user status');
                }
            });
        }

        function showInactivityAlert() {
            Swal.fire({
                title: 'Account Deactivated',
                text: 'Your account has been marked as inactive. You will be logged out in 5 seconds.',
                icon: 'warning',
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: false,
                allowOutsideClick: false
            }).then(() => {
                window.location.href = '<?php echo e(route("admin.logout")); ?>';
            });
        }

        // Start checking user status
        statusCheckInterval = setInterval(checkUserStatus, CHECK_INTERVAL);
        
        // Initial check
        checkUserStatus();

        // File size validation
        function validateFileSize(input) {
            const maxTotalSize = 10 * 1024 * 1024; // 10MB in bytes
            let totalSize = 0;

            for (let i = 0; i < input.files.length; i++) {
                totalSize += input.files[i].size;
            }

            if (totalSize > maxTotalSize) {
                Swal.fire({
                    title: 'File Size Error',
                    text: 'Total size of all files must not exceed 10MB',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                input.value = '';
            }
        }
    </script>
</body>

</html>
<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/layouts/app.blade.php ENDPATH**/ ?>