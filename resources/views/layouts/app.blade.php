@php use App\Models\User; @endphp
    <!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Blood Bank Optimization - Automated Matching and Tracking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="Optimizing blood bank operations through automated donor-recipient matching and donation tracking for improved efficiency and reliability.">
    <meta name="keywords"
          content="Blood Bank, Donor Matching, Recipient Matching, Donation Tracking, Blood Donation, Healthcare Technology">
    <meta name="author" content="Blood Bank Optimization Team">
    <meta name="email" content="support@bloodbankoptimization.com">
    <meta name="website" content="https://www.bloodbankoptimization.com">
    <meta name="Version" content="v1.0">

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}"/>

    <!-- Css Libraries -->
    <link href="{{ asset('dashboard/assets/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/assets/libs/tiny-slider/tiny-slider.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/assets/libs/tobii/css/tobii.min.css') }}" rel="stylesheet">

    <!-- Bootstrap Css -->
    <link href="{{ asset('dashboard/assets/css/bootstrap.min.css') }}" class="theme-opt" rel="stylesheet"
          type="text/css"/>

    <!-- Icons Css -->
    <link href="{{ asset('dashboard/assets/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet"
          type="text/css">
    <link href="{{ asset('dashboard/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('dashboard/assets/libs/@iconscout/unicons/css/line.css') }}" type="text/css" rel="stylesheet"/>

    <!-- Style Css -->
    <link href="{{ asset('dashboard/assets/css/style.min.css') }}" class="theme-opt" rel="stylesheet" type="text/css"/>
</head>

<body>

<div class="page-wrapper toggled">
    <!-- sidebar-wrapper -->
    <nav id="sidebar" class="sidebar-wrapper sidebar-dark">
        <div class="sidebar-content" data-simplebar style="height: calc(100% - 60px);">
            <div class="sidebar-brand">
                <a href="{{ route('dashboard') }}">
                    <!-- SVG for light mode -->
                    <svg class="logo-light-mode" height="24" viewBox="0 0 200 50" xmlns="http://www.w3.org/2000/svg">
                        <text x="10" y="35" font-family="Arial, sans-serif" font-size="30" fill="black">AutoBlood</text>
                    </svg>

                    <!-- SVG for dark mode -->
                    <svg class="logo-dark-mode" height="24" viewBox="0 0 200 50" xmlns="http://www.w3.org/2000/svg">
                        <text x="10" y="35" font-family="Arial, sans-serif" font-size="30" fill="white">AutoBlood</text>
                    </svg>

                    <span class="sidebar-colored">
            <!-- Another SVG for colored mode -->
            <svg height="60" viewBox="0 0 200 50" xmlns="http://www.w3.org/2000/svg" style="width: 100%; height: 60px;">
                <text x="10" y="35" font-family="Arial, sans-serif" font-size="30" fill="red">AutoBlood</text>
            </svg>
        </span>
                </a>
            </div>


            <ul class="sidebar-menu">
                <li class="sidebar">
                    <a href="{{ route('dashboard') }}"><i class="ti ti-home me-2"></i>Dashboard</a>
                </li>
                <li class="sidebar">
                    <a href="{{ route('dashboard.appointments') }}"><i class="ti ti-time me-2"></i>Appointments</a>
                </li>

                @can('isAdmin', User::class)
                    <li class="sidebar">
                        <a href="{{ route('dashboard.users') }}"><i class="ti ti-user me-2"></i>Users</a>
                    </li>

                    <li class="sidebar">
                        <a href="{{ route('dashboard.donations') }}"><i class="ti ti-time me-2"></i>Donations</a>
                    </li>
                    <li class="sidebar">
                        <a href="{{ route('dashboard.donations.requests') }}"><i class="ti ti-time me-2"></i>Donation Requests</a>
                    </li>

                    <li class="sidebar">
                        <a href="{{ route('dashboard.donation.matches') }}"><i class="ti ti-time me-2"></i>Donations Matches</a>
                    </li>
                @endcan

                @can('isDonor', User::class)
                    <li class="sidebar">
                        <a href="{{ route('dashboard.donations') }}"><i class="ti ti-time me-2"></i>My Donations</a>
                    </li>
                @endcan

                @can('isRecipient', User::class)
                    <li class="sidebar">
                        <a href="{{ route('dashboard.donations.requests') }}"><i class="ti ti-time me-2"></i>My Requests</a>
                    </li>
                @endcan
            </ul>
            <!-- sidebar-menu  -->
        </div>
    </nav>
    <!-- sidebar-wrapper  -->

    <!-- Start Page Content -->
    <main class="page-content bg-light">
        {{ $slot }}
        <!-- Footer Start -->
        <footer class="shadow py-3">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-sm-start text-center mx-md-2">
                            <p class="mb-0 text-muted">©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>
                                Blood Bank Optimization Team.
                            </p>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </footer><!--end footer-->

        <!-- End -->
    </main>
    <!--End page-content" -->
</div>
<!-- page-wrapper -->

<!-- javascript -->
<!-- JAVASCRIPT -->
<script src="{{ asset('dashboard/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dashboard/assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('dashboard/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('dashboard/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{asset('dashboard/assets/libs/tiny-slider/min/tiny-slider.js')}}"></script>
<script src="{{asset('dashboard/assets/libs/tobii/js/tobii.min.js')}}"></script>


<!-- Main Js -->
<script src="{{ asset('dashboard/assets/js/plugins.init.js') }}"></script>
<script src="{{ asset('dashboard/assets/js/app.js') }}"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css"
      integrity="sha512-hvNR0F/e2J7zPPfLC9auFe3/SE0yG4aJCOd/qxew74NN7eyiSKjr7xJJMu1Jy2wf7FXITpWS1E/RY8yzuXN7VA=="
      crossorigin="anonymous" referrerpolicy="no-referrer"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.js"
        integrity="sha512-Zt7blzhYHCLHjU0c+e4ldn5kGAbwLKTSOTERgqSNyTB50wWSI21z0q6bn/dEIuqf6HiFzKJ6cfj2osRhklb4Og=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.css"
      integrity="sha512-bs9fAcCAeaDfA4A+NiShWR886eClUcBtqhipoY5DM60Y1V3BbVQlabthUBal5bq8Z8nnxxiyb1wfGX2n76N1Mw=="
      crossorigin="anonymous" referrerpolicy="no-referrer"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"
        integrity="sha512-9KkIqdfN7ipEW6B6k+Aq20PV31bjODg4AA52W+tYtAE0jE0kMx49bjJ3FgvS56wzmyfMUHbQ4Km2b7l9+Y/+Eg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
