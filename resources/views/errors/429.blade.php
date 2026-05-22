<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8" />
        <title>Error 429 | Kulvriksh - </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc."/>
        <meta name="author" content="Zoyothemes"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('assets/admin/images/favicon.ico')}}">

        <!-- App css -->
        <link href="{{asset('assets/admin/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />

        <!-- Icons -->
        <link href="{{asset('assets/admin/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

        <script src="{{asset('assets/admin/js/head.js')}}"></script>


    </head>

    <!-- body start -->
    <body data-menu-color="light" data-sidebar="default">

    <body class="maintenance-bg-image">
        
        <!-- Begin page -->
         <div class="maintenance-pages">
            <div class="container-fluid p-0">
                <div class="row">

                    <div class="col-xl-12 align-self-center">
                        <div class="row">
                            <div class="col-md-5 mx-auto">
                                <div class="text-center">

                                    <div class="mb-0">
                                        <h3 class="mt-4 fw-semibold text-dark text-capitalize">Too many requests</h3>
                                        <p class="text-muted">You've made too many requests in a short time. <br> Please wait a moment and try again.</p>
                                    </div>

                                    <a class='btn btn-primary mt-3 me-1' href='{{url('admin/dashboard')}}'>Back to Home</a>

                                    <div class="maintenance-img mt-4">
                                        <img src="{{asset('assets/admin/images/svg/429-error.svg')}}" class="img-fluid" alt="coming-soon">
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
        <script src="{{asset('assets/admin/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('assets/admin/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{asset('assets/admin/libs/node-waves/waves.min.js')}}"></script>
        <script src="{{asset('assets/admin/libs/waypoints/lib/jquery.waypoints.min.js')}}"></script>
        <script src="{{asset('assets/admin/libs/jquery.counterup/jquery.counterup.min.js')}}"></script>
        <script src="{{asset('assets/admin/libs/feather-icons/feather.min.js')}}"></script>

        <!-- App js-->
        <script src="{{asset('assets/admin/js/app.js')}}"></script>
        
    </body>
</html>