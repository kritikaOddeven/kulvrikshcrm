<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Forgot Password | Kulvriksh</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc." />
    <meta name="author" content="Zoyothemes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset('assets/admin/images/favicon.ico')); ?>">

    <!-- App css -->
    <link href="<?php echo e(asset('assets/admin/css/app.min.css')); ?>" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons -->
    <link href="<?php echo e(asset('assets/admin/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />

    <script src="<?php echo e(asset('assets/admin/js/head.js')); ?>"></script>

    <!-- Remix Icon CDN -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

</head>

<body class="body-whitebg">
    <!-- Begin page -->
    <div class="account-page login-bg">
        <div class="container-fluid p-0">
            <div class="row align-items-center g-0 px-3 py-3 vh-100">

                <div class="col-xl-5">
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <div class="">
                                <div class="">
                                    <div class="mb-0 p-0 p-lg-3">
                                        <div class="mb-0 border-0 p-md-4 p-lg-0">
                                            <div class="mb-4 p-0 text-lg-start text-center">
                                                <div class="auth-brand text-center">
                                                    <a class='logo logo-light' href='<?php echo e(url('login')); ?>'>
                                                        <span class="logo-lg">
                                                            <img src="<?php echo e(asset('assets/admin/images/logo.png')); ?>" alt="" width="300" height="150px">
                                                        </span>
                                                    </a>
                                                    <a class='logo logo-dark' href='<?php echo e(url('login')); ?>'>
                                                        <span class="logo-lg">
                                                            <img src="<?php echo e(asset('assets/admin/images/logo.png')); ?>" alt="" width="300" height="150px">
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="auth-title-section mb-4 text-lg-start text-center">
                                                <h3 class="login-title">Reset Password</h3>
                                            </div>

                                            <div class="pt-0">
                                                <form action="<?php echo e(route('submit.reset.password')); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="token" value="<?php echo e($token); ?>">
                                                    <div class="form-group mb-3">
                                                        <label for="emailaddress" class="form-label">Email address</label>
                                                        <input class="form-control bg-light" type="email" id="emailaddress" name="email" value="<?php echo e($email ?? ''); ?>" readonly>
                                                    </div>


                                                    <div class="form-group mb-3 row">
                                                        <label class="form-label">New Password<?php if (isset($component)) { $__componentOriginal27abc86fb91a36b7c85cb140e4c313c7 = $component; } ?>
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
                                                        <div class="col-lg-12 col-xl-12">
                                                            <div class="input-group">
                                                                <input class="form-control" type="password" id="new_password" name="password" placeholder="New Password">
                                                                <span class="input-group-text btn btn-outline-dark" style="cursor: pointer;" onclick="togglePassword('new_password', this.querySelector('i'))">
                                                                    <i class="ri-eye-off-line password-toggle"></i>
                                                                </span>
                                                            </div>
                                                            <span class="text-danger">
                                                                <?php $__errorArgs = ['password'];
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

                                                    <div class="form-group mb-3 row">
                                                        <label class="form-label">Confirm Password</label>
                                                        <div class="col-lg-12 col-xl-12">
                                                            <div class="input-group">
                                                                <input class="form-control" type="password" id="confirm_password" name="password_confirmation" placeholder="Confirm Password">
                                                                <span class="input-group-text btn btn-outline-dark" style="cursor: pointer;" onclick="togglePassword('confirm_password', this.querySelector('i'))">
                                                                    <i class="ri-eye-off-line password-toggle"></i>
                                                                </span>
                                                            </div>
                                                            <span id="password_error" style="color:red; font-size: 14px;"></span>
                                                        </div>
                                                    </div>


                                                    <div class="form-group mb-0 row">
                                                        <div class="col-12">
                                                            <div class="d-grid">
                                                                <button class="btn btn-primary" type="submit"> Reset Password </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-xl-7 d-none d-xl-inline-block">
                    <div class="account-page-bg rounded-4">

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- END wrapper -->

    <!-- Vendor -->
    <script src="<?php echo e(asset('assets/admin/libs/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/libs/simplebar/simplebar.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/libs/node-waves/waves.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/libs/waypoints/lib/jquery.waypoints.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/libs/jquery.counterup/jquery.counterup.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/libs/feather-icons/feather.min.js')); ?>"></script>

    <!-- App js-->
    <script src="<?php echo e(asset('assets/admin/js/app.js')); ?>"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const newPassword = document.getElementById('new_password');
            const confirmPassword = document.getElementById('confirm_password');
            const errorSpan = document.getElementById('password_error');

            confirmPassword.addEventListener('input', function() {
                if (newPassword.value !== confirmPassword.value) {
                    errorSpan.textContent = "Passwords do not match.";
                } else {
                    errorSpan.textContent = "";
                }
            });
        });

        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('ri-eye-off-line');
                icon.classList.add('ri-eye-line');
            } else {
                input.type = 'password';
                icon.classList.remove('ri-eye-line');
                icon.classList.add('ri-eye-off-line');
            }
        }
    </script>

</body>

</html>
<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/auth/reset-password.blade.php ENDPATH**/ ?>