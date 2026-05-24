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
    <link rel="icon" href="{{ asset('') }}assets/images/logo/smpn.png" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('') }}assets/images/logo/smpn.png" type="image/x-icon">
    <title>Login | SIMPRESI</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/font-awesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/style.css">
    <link id="color" rel="stylesheet" href="{{ asset('') }}assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}assets/css/responsive.css">

    <style>
        .show-hide {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
        }

        .show-hide svg {
            width: 18px;
            height: 18px;
        }
    </style>
</head>

<body>
    <!-- login page start-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-7">
                <img class="bg-img-cover bg-center" src="{{ asset('') }}assets/images/login/smpn2saronggi.png"
                    alt="looginpage">
            </div>
            <div class="col-xl-5 p-0">
                <div class="login-card login-dark">
                    <div>
                        <div class="text-center mb-4">
                            <a class="logo text-decoration-none d-flex flex-column align-items-center" href="#">

                                <!-- Logo -->
                                <img class="for-light" src="{{ asset('assets/images/logo/smpn.png') }}" alt="logo"
                                    style="width: 90px; height: auto;">

                                <img class="for-dark d-none" src="{{ asset('assets/images/logo/smpn.png') }}"
                                    alt="logo" style="width: 90px; height: auto;">

                                <!-- Judul -->
                                <h2 class="fw-bold"> SMPN 2 Saronggi </h2>

                                <!-- Quote -->
                                <small class="mt-2">
                                    <i>
                                        "<b>Sekolah boleh di desa, tapi mimpi kami mendunia!</b>"
                                    </i>
                                </small>

                            </a>
                        </div>
                        <div class="login-main">
                            <form class="theme-form" method="POST" action="{{ route('login') }}">
                                @csrf

                                <h4>Sign in to account</h4>
                                <p>Enter your email & password to login</p>

                                @include('Components.alert')

                                <div class="form-group">
                                    <label class="col-form-label">Email Address</label>
                                    <input class="form-control" type="email" name="email" required
                                        placeholder="test@gmail.com">
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" name="password" required
                                            placeholder="*********">
                                        <div class="show-hide" id="togglePassword">
                                            <i data-feather="eye"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <div class="checkbox p-0">
                                        <input id="remember" type="checkbox" name="remember">
                                        <label class="text-muted" for="remember">Remember password</label>
                                    </div>

                                    <button class="btn btn-primary btn-block w-100" type="submit">
                                        Sign in
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- latest jquery-->
        <script src="{{ asset('') }}assets/js/jquery.min.js"></script>
        <!-- Bootstrap js-->
        <script src="{{ asset('') }}assets/js/bootstrap/bootstrap.bundle.min.js"></script>
        <!-- feather icon js-->
        <script src="{{ asset('') }}assets/js/icons/feather-icon/feather.min.js"></script>
        <script src="{{ asset('') }}assets/js/icons/feather-icon/feather-icon.js"></script>
        <!-- scrollbar js-->
        <!-- Sidebar jquery-->
        <script src="{{ asset('') }}assets/js/config.js"></script>
        <!-- Plugins JS start-->
        <!-- calendar js-->
        <!-- Plugins JS Ends-->
        <!-- Theme js-->
        <script src="{{ asset('') }}assets/js/script.js"></script>
        <script src="{{ asset('') }}assets/js/script1.js"></script>
        <!-- Plugin used-->
    </div>

    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function() {

                const passwordInput =
                    document.querySelector(
                        'input[name="password"]'
                    );

                const togglePassword =
                    document.getElementById(
                        'togglePassword'
                    );

                togglePassword.addEventListener(
                    'click',
                    function() {

                        const icon =
                            this.querySelector('svg');

                        if (
                            passwordInput.type ===
                            'password'
                        ) {

                            passwordInput.type =
                                'text';

                            this.innerHTML =
                                feather.icons['eye-off']
                                .toSvg();

                        } else {

                            passwordInput.type =
                                'password';

                            this.innerHTML =
                                feather.icons['eye']
                                .toSvg();

                        }

                    });

            });
    </script>
</body>

</html>
