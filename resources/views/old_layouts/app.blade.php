<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('page_title')</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-free/css/all.min.css') }}" />
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="{{ asset('assets/css/tempusdominus-bootstrap-4.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/icheck-bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/jqvmap.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/OverlayScrollbars.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/summernote-bs4.min.css') }}" />
        <style>
            .sidebar .nav-link p{
                color:black;
            }
            .nav-sidebar>.nav-item .nav-icon {
                color:black;
            }
        </style>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">

            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                @include('layouts.header')
            </nav>
            <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background: #f4f6f9; ">
                @include('layouts.sidenav')
            </aside>

            <div class="container-fluid">
                <div class="content-wrapper">
                    <section class="content">
                        @yield('style')
                        @yield('content')
                        @yield('script')
                    </section>
                </div>
            </div>

            <aside class="control-sidebar control-sidebar-dark">
                @include('layouts.sidesetting')
            </aside>

            <footer class="main-footer">
                <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                  <b>Version</b> 3.2.0
                </div>
            </footer>

        </div>
    </body>
    <script src="{{ asset('assets/user/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/user/js/jquery-ui.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/sparkline.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.vmap.usa.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('assets/js/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('assets/js/adminlte.js') }}"></script>
    {{-- <script src="{{ asset('assets/user/js/demo.js') }}"></script> --}}
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</html>
