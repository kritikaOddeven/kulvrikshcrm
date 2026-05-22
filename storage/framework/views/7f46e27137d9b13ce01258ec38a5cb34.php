<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Log In | Kulvriksh </title>
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

    <link href="<?php echo e(asset('assets/admin/css/custom.css')); ?>" rel="stylesheet" type="text/css" />

    <script src="<?php echo e(asset('assets/admin/js/head.js')); ?>"></script>
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
                                                <div class="auth-brand text-left">
                                                    <a class='logo logo-light' href='<?php echo e(url('login')); ?>'>
                                                        <span class="logo-lg">
                                                            <img src="<?php echo e(asset('assets/admin/images/logo.png')); ?>" alt=""  >
                                                        </span>
                                                    </a>
                                                    <a class='logo logo-dark' href='<?php echo e(url('login')); ?>'>
                                                        <span class="logo-lg">
                                                            <img src="<?php echo e(asset('assets/admin/images/logo.png')); ?>" alt="" >
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php if (isset($component)) { $__componentOriginale2f365c7094bff4327525ae36f935879 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale2f365c7094bff4327525ae36f935879 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.custom-alert','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('custom-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale2f365c7094bff4327525ae36f935879)): ?>
<?php $attributes = $__attributesOriginale2f365c7094bff4327525ae36f935879; ?>
<?php unset($__attributesOriginale2f365c7094bff4327525ae36f935879); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale2f365c7094bff4327525ae36f935879)): ?>
<?php $component = $__componentOriginale2f365c7094bff4327525ae36f935879; ?>
<?php unset($__componentOriginale2f365c7094bff4327525ae36f935879); ?>
<?php endif; ?>

                                            <div class="auth-title-section mb-4 text-lg-start text-center">
                                                <h3 class="login-title">Log In</h3>
                                            </div>

                                            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('login-with-otp');

$__html = app('livewire')->mount($__name, $__params, 'lw-3643686343-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
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

</body>

</html>
<?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/auth/login.blade.php ENDPATH**/ ?>