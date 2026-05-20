<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Mofi admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Mofi admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    @include('Components.title')
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    @include('Components.styles')

    @stack('style')
    <style>
        .custom-pagination nav {
            display: flex;
            justify-content: center;
        }

        .custom-pagination .pagination {
            gap: 6px;
            margin: 0;
            flex-wrap: wrap;
        }

        .custom-pagination .page-item {
            list-style: none;
        }

        .custom-pagination .page-link {
            background: transparent !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: #fff !important;
            border-radius: 8px !important;
            min-width: 38px;
            text-align: center;
            transition: 0.2s ease;
            box-shadow: none !important;
        }

        .custom-pagination .page-link:hover {
            background: rgba(255, 255, 255, 0.1) !important;
        }

        .custom-pagination .active .page-link {
            background: #7366ff !important;
            border-color: #7366ff !important;
            color: #fff !important;
        }

        .custom-pagination .disabled .page-link {
            opacity: .5;
        }

        /* 🔥 HAPUS ICON ANEH TEMPLATE */
        .custom-pagination svg {
            width: 14px !important;
            height: 14px !important;
        }

        /* FULL WIDTH PAGE BODY */
        .page-wrapper.compact-wrapper .page-body-wrapper .page-body {
            min-height: calc(100vh - 80px);
            margin-top: 80px;
            padding: 30px;
            width: calc(100% - 250px) !important;
            max-width: 100% !important;
        }

        /* BIKIN CONTENT MELEBAR */
        .page-body {
            width: 100% !important;
            max-width: 100% !important;
        }

        /* TABLE BIAR LEGA */
        .table-responsive {
            overflow-x: auto;
        }

        .table {
            min-width: 1500px;
        }

        /* SPACING KOLOM */
        .table td,
        .table th {
            padding: 16px 18px !important;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div class="loader-wrapper">
        <div class="loader loader-1">
            <div class="loader-outter"></div>
            <div class="loader-inner"></div>
            <div class="loader-inner-1"></div>
        </div>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top">
        <i data-feather="chevrons-up"></i>
    </div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <div class="page-header row">
            <div class="header-logo-wrapper col-auto">
                <div class="logo-wrapper">
                    <a href="index.html">
                        <img class="img-fluid for-light" src="{{ asset('') }}assets/images/logo/logo.png"
                            alt="" />
                        <img class="img-fluid for-dark" src="{{ asset('') }}assets/images/logo/logo_light.png"
                            alt="" />
                    </a>
                </div>
            </div>
            <div class="col-4 col-xl-4 page-title">
                <h4 class="f-w-700">@yield('title')</h4>
                <nav>
                    @yield('breadcrumb')
                </nav>
            </div>
            <!-- Page Header Start-->
            @include('Components.header')
            <!-- Page Header Ends -->
        </div>
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            @include('Components.sidebar')
            <!-- Page Sidebar Ends-->
            <div class="page-body">
                <!-- Container-fluid starts-->
                @yield('content')
                <!-- Container-fluid Ends-->
            </div>
            <!-- footer start-->
            @include('Components.footer')
        </div>
    </div>
    @include('Components.script')

    @stack('script')
</body>

</html>
