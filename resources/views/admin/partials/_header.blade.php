<div class="topbar-custom">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="d-flex">
                <div class="logo-box">
                    <a class='logo logo-light' href='{{ url('/admin/dashboard') }}'>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/admin/images/logo.png') }}" alt="" width="150" height="50px">
                        </span>
                    </a>
                    <a class='logo logo-dark' href='{{ url('/admin/dashboard') }}'>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/admin/images/logo.png') }}" alt="" width="150" height="50px">
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
                        {{-- <img src="{{asset('assets/admin/images/users/user-13.jpg')}}" alt="user-image" class="rounded-circle" /> --}}
                        <img src="{{ asset(get_profile_image(Auth::user()->profile_image, Auth::user()->name)) }}" class="rounded-circle" alt="Profile Image">
                        <span class="pro-user-name ms-1">{{Auth::user()->name}} <i class="ri-arrow-down-s-line"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end profile-dropdown">
                        <!-- item-->
                        <div class="dropdown-header noti-title text-center">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>

                        <!-- item-->
                        @can('view_profile')
                        <a class='dropdown-item notify-item' href='{{url('/admin/profile')}}'>
                            <i class="ri-user-2-line"></i>
                            <span>My Account</span>
                        </a>
                        @endcan

                        <!-- item-->
                        {{-- <a class='dropdown-item notify-item' href='auth-lock-screen.html'>
                            <i class="mdi mdi-lock-outline fs-16 align-middle"></i>
                            <span>Lock Screen</span>
                        </a> --}}

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
            window.location.href = "{{ route('admin.logout') }}";
        }
    });
}
</script>