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
    <link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('assets/admin/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons -->
    <link href="{{ asset('assets/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ asset('assets/admin/js/head.js') }}"></script>


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
                                                    <a class='logo logo-light' href='{{ url('login') }}'>
                                                        <span class="logo-lg">
                                                            <img src="{{ asset('assets/admin/images/logo.png') }}" alt="" width="300" height="150px">
                                                        </span>
                                                    </a>
                                                    <a class='logo logo-dark' href='{{ url('login') }}'>
                                                        <span class="logo-lg">
                                                            <img src="{{ asset('assets/admin/images/logo.png') }}" alt="" width="300" height="150px">
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="auth-title-section mb-4 text-lg-start text-center">
                                                <h3 class="login-title">Forgot Password</h3>
                                            </div>
                                            {{-- Alert message --}}
                                            <x-custom-alert />
                                            <div class="pt-0">
                                                <form action="{{ route('submit.forget.password') }}" method="POST" class="my-4">
                                                    @csrf
                                                    <div class="form-group mb-3">
                                                        <label for="emailaddress" class="form-label">Email address <x-required-star /></label>
                                                        <input class="form-control" type="email" id="emailaddress" name="email"  placeholder="Enter your email">
                                                        <span class="text-danger">
                                                                @error('email')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                    </div>

                                                    <div class="form-group mb-0 row">
                                                        <div class="col-12">
                                                            <div class="d-grid">
                                                                <button class="btn btn-primary" type="submit"> Reset Password </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="text-center text-muted">
                                                    <p class="mb-0">Change the mind ?<a class='text-primary ms-2 fw-medium' href='{{ url('/login') }}'>Back to Login</a></p>
                                                </div>
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
                        <div class="auth-user-review text-center">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                <div class="carousel-inner">

                                    <div class="carousel-item active">
                                        <p class="prelead mb-2">

                                        </p>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- END wrapper -->

    <!-- Vendor -->
    <script src="{{ asset('assets/admin/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/feather-icons/feather.min.js') }}"></script>

    <!-- App js-->
    <script src="{{ asset('assets/admin/js/app.js') }}"></script>

</body>

</html>
