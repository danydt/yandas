<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="Yanda's vous aide à acheter vos articles en France et les récupérer à Kinshasa">
    <meta name="keywords"
          content="yandas, yandas livraison, achat en ligne, achat, achat france, livraison Kinshasa">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - S'inscrire</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fontawesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/feather-icon.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/sweetalert2.css') }}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
</head>
<body>
<!-- Loader starts-->
<div class="loader-wrapper">
    <div class="theme-loader">
        <div class="loader-p"></div>
    </div>
</div>
<!-- Loader ends-->
<!-- page-wrapper Start-->
<section>
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-xl-5"><img class="bg-img-cover bg-center" src="{{ asset('assets/images/login/bg-register1.png') }}"
                                       alt="looginpage"></div>
            <div class="col-xl-7 p-0">
                <div class="login-card">
                    <form class="theme-form login-form" method="POST" action="{{ route('register') }}">
                        @csrf
                        <h4>Créez votre compte</h4>
                        <h6>Entrez vos données personnelles pour créer un compte</h6>
                        <div class="form-group">
                            <label for="name">Votre nom complet</label>
                            <div class="small-group">
                                <div class="input-group"><span class="input-group-text"><i class="icon-user"></i></span>
                                    <input id="name" name="name" class="form-control @error('name') is-invalid @enderror" type="text" required placeholder="Votre nom complet" autocomplete="name" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Adresse électronique</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-email"></i></span>
                                <input id="email" name="email" class="form-control @error('email') is-invalid @enderror" type="email" required
                                       placeholder="Votre adresse mail" value="{{ old('email') }}" autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                                <input id="password" class="form-control @error('password') is-invalid @enderror"
                                       type="password" name="password" required placeholder="Votre mot de passe" autocomplete="new-password">
                                <div class="show-hide"><span class="show">                         </span></div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">Confirmez le mot de passe</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                                <input id="password-confirm" class="form-control" type="password"
                                       name="password_confirmation" required placeholder="Confirmez votre mot de passe" autocomplete="new-password">
                                <div class="show-hide"><span class="show">                         </span></div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <input id="checkbox1" type="checkbox">
                                <label class="text-muted" for="checkbox1">D'accord avec notre <span>Politique de confidentialité                   </span></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Créer un compte</button>
                        </div>
                        <p>Vous avez déjà un compte ?<a class="ms-2" href="{{ route('login') }}">Se connecter</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- page-wrapper end-->
<!-- latest jquery-->
<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
<!-- feather icon js-->
<script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
<!-- Sidebar jquery-->
<script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
<script src="{{ asset('assets/js/config.js') }}"></script>
<!-- Bootstrap js-->
<script src="{{ asset('assets/js/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap/bootstrap.min.js') }}"></script>
<!-- Plugins JS start-->
<script src="{{ asset('assets/js/sweet-alert/sweetalert.min.js') }}"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{ asset('assets/js/script.js') }}"></script>
<!-- login js-->
<!-- Plugin used-->
</body>
</html>
