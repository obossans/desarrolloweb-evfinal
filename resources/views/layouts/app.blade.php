<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path=""
  data-template="vertical-menu-template-starter"
  data-style="light">

<head>
   <!-- Favicon -->
   <link rel="icon" type="image/x-icon" href="img/favicon/favicon.ico" />

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
  href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
  rel="stylesheet" />

<!-- Icons -->
<link rel="stylesheet" href="{{ asset('vendor/fonts/fontawesome.css')}}" />
<link rel="stylesheet" href="{{ asset('vendor/fonts/tabler-icons.css')}}" />
<link rel="stylesheet" href="{{ asset('vendor/fonts/flag-icons.css')}}" />

<!-- Core CSS -->

<link rel="stylesheet" href="{{ asset('vendor/css/rtl/core.css" class="template-customizer-core-css')}}" />
<link rel="stylesheet" href="{{ asset('vendor/css/rtl/theme-default.css" class="template-customizer-theme-css')}}" />

<link rel="stylesheet" href="{{ asset('css/demo.css')}}" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ asset('vendor/libs/node-waves/node-waves.css')}}" />

<link rel="stylesheet" href="{{ asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
<link rel="stylesheet" href="{{ asset('endor/libs/typeahead-js/typeahead.css')}}v" />
<link rel="stylesheet" href="{{ asset('vendor/libs/apex-charts/apex-charts.css')}}" />
<link rel="stylesheet" href="{{ asset('vendor/libs/swiper/swiper.css')}}" />
<link rel="stylesheet" href="{{ asset('vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{ asset('vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{ asset('vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}" />

<!-- Page CSS -->
<link rel="stylesheet" href="{{ asset('vendor/css/pages/cards-advance.css')}}" />

<!-- Helpers -->
<script src="vendor/js/helpers.js"></script>
<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

<!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
<script src="vendor/js/template-customizer.js"></script>

<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="js/config.js"></script>

<script src="{{ asset('js/app.js')}}" defer></script>

    @yield('css')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <!--Sidebar-->
            @include('partials.sidebar')
            <div class="layout-page">
                <!--Navbar-->
                @include('partials.navbar')

                <div class="content-wrapper">
                    <!-- Content -->

                    @yield('content')
                    <!-- / Content -->
                    @include('partials.footer')
                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <script src="vendor/libs/jquery/jquery.js"></script>
    <script src="vendor/libs/popper/popper.js"></script>
    <script src="vendor/js/bootstrap.js"></script>
    <script src="vendor/libs/node-waves/node-waves.js"></script>
    <script src="vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/libs/hammer/hammer.js"></script>
    <script src="vendor/libs/i18n/i18n.js"></script>
    <script src="vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="vendor/libs/swiper/swiper.js"></script>
    <script src="vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

    <!-- Main JS -->
    <script src="js/main.js"></script>

    <!-- Page JS -->
    <script src="js/dashboards-analytics.js"></script>
</body>

</html>
