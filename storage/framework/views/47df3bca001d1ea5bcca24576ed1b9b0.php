<div class="topbar-custom">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="d-flex">
                <div class="logo-box">
                    <a class='logo logo-light' href='<?php echo e(url('/admin/dashboard')); ?>'>
                        <span class="logo-lg">
                            <img src="<?php echo e(asset('assets/admin/images/logo.png')); ?>" alt="" width="150" height="50px">
                        </span>
                    </a>
                    <a class='logo logo-dark' href='<?php echo e(url('/admin/dashboard')); ?>'>
                        <span class="logo-lg">
                            <img src="<?php echo e(asset('assets/admin/images/logo.png')); ?>" alt="" width="150" height="50px">
                        </span>
                    </a>
                </div>
                <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                    <li>
                        <button class="button-toggle-menu nav-link">
                            <i data-feather="menu" class="noti-icon"></i>
                        </button>
                    </li>
                </ul>
            </div>

            <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">

                <!-- User Dropdown -->
                <li class="dropdown notification-list topbar-dropdown">
                    <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="index.html#" role="button" aria-haspopup="false" aria-expanded="false">
                        
                        <img src="<?php echo e(asset(get_profile_image(Auth::user()->profile_image, Auth::user()->name))); ?>" class="rounded-circle" alt="Profile Image">
                        <span class="pro-user-name ms-1"><?php echo e(Auth::user()->name); ?> <i class="ri-arrow-down-s-line"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end profile-dropdown">
                        <!-- item-->
                        <div class="dropdown-header noti-title text-center">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>

                        <!-- item-->
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_profile')): ?>
                        <a class='dropdown-item notify-item' href='<?php echo e(url('/admin/profile')); ?>'>
                            <i class="ri-user-2-line"></i>
                            <span>My Account</span>
                        </a>
                        <?php endif; ?>

                        <!-- item-->
                        

                        <div class="dropdown-divider"></div>

                        <!-- item-->
                        <a class='dropdown-item notify-item' href='javascript:void(0)' onclick="confirmLogout()">
                           <i class="ri-logout-circle-r-line"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
function confirmLogout() {
    Swal.fire({
        title: 'Are you sure?',
        text: "You will be logged out of your account!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, logout!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?php echo e(route('admin.logout')); ?>";
        }
    });
}
</script><?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/admin/partials/_header.blade.php ENDPATH**/ ?>