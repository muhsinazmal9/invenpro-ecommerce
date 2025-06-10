<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset(getSetting(App\Models\Settings::FAVICON)) }}" type="image/x-icon" />
    <title>@yield('title') - {{ config('app.name') }}</title>
    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="{{ asset('assets/backend/css/bootstrap.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/backend/css/lineicons.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/backend/css/materialdesignicons.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/backend/css/main.css') }}" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/toastr.min.css') }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />

    <link rel="stylesheet" href="{{ asset('assets/backend/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/css/responsive.bootstrap.min.css') }}">

    <script src="{{ asset('assets/backend/js/jquery.min.js') }}"></script>


    <script src="{{ asset('assets/backend/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/dataTables.responsive.min.js') }}"></script>
    <link href="{{ asset('assets/backend/css/select2.min.css') }}" rel="stylesheet" />

    {{-- Summernote --}} 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" rel="stylesheet"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>


    {{-- tagify --}}
    <script src="{{ asset('assets/backend/js/tagify.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/tagify.polyfills.min.js') }}"></script>
    <link href="{{ asset('assets/backend/css/tagify.css') }}" rel="stylesheet" type="text/css" />



    @stack('css')

</head>

<body>
    <div id="toast"></div>
    <div>

        <!-- ======== Preloader =========== -->

        @include('backend.partials.preloader')
        <!-- ======== Preloader =========== -->

        <!-- ======== sidebar-nav start =========== -->
        @include('backend.partials.sidebar')

        <!-- ======== sidebar-nav end =========== -->
        <main class="main-wrapper">
            <!-- ========== header start ========== -->
            @include('backend.layouts.header')
            <!-- ========== header end ========== -->

            <!-- ======== main-wrapper start =========== -->
            @yield('content')
            <!-- ========== footer start =========== -->
            @include('backend.layouts.footer')
            <!-- ========== footer end =========== -->
        </main>

        <!-- ======== main-wrapper end =========== -->

        <!-- ========= All Javascript files linkup ======== -->

        <script src="{{ asset('assets/backend/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/main.js') }}"></script>
        <script src="{{ asset('assets/backend/js/sweetalert2.all.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/toastr.min.js') }}"></script>
        <script src="{{ asset('assets/backend/js/select2.min.js') }}"></script>
        <script>
            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @endif
            @if (session('error'))
                toastr.error("{{ session('error') }}");
            @endif
        </script>
        @stack('script')
</body>

</html>
