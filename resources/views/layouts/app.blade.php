<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" style="height: 100%;">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Butterfly-Steel') }}</title>

    <!-- Material Styles -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="{{ asset('css/nouislider.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('head')
</head>
<body style="height: 100%;">
<nav id="site-nav">
    <div class="nav-wrapper">
        <a href="{{ route('home') }}" class="brand-logo">Butterfly-Steel</a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
            @auth
                <li><a href="{{ route('home') }}">My Campaigns</a></li>
            @else
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
            @endauth
        </ul>
    </div>
</nav>
<ul class="sidenav" id="mobile-demo">
    @auth
        <li><a href="{{ route('home') }}">My Campaigns</a></li>
    @else
        <li><a href="{{ route('login') }}">Login</a></li>
        <li><a href="{{ route('register') }}">Register</a></li>
    @endauth
</ul>
<div id="app" style="position: relative; min-height: 650px;">
    @yield('content')
</div>
<footer id="page-footer" class="page-footer">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">Company Bio</h5>
                <p class="grey-text text-lighten-4">We are a team of college students working on this project like it's
                                                    our full time job. Any amount would help support and continue
                                                    development on this project and is greatly appreciated.</p>
            </div>
            <div class="col l3 s12">
                <h5 class="white-text">Settings</h5>
                <ul>
                    <li><a class="white-text" href="#!">Link 1</a></li>
                    <li><a class="white-text" href="#!">Link 2</a></li>
                    <li><a class="white-text" href="#!">Link 3</a></li>
                    <li><a class="white-text" href="#!">Link 4</a></li>
                </ul>
            </div>
            <div class="col l3 s12">
                <h5 class="white-text">Connect</h5>
                <ul>
                    <li><a class="white-text" href="#!">Link 1</a></li>
                    <li><a class="white-text" href="#!">Link 2</a></li>
                    <li><a class="white-text" href="#!">Link 3</a></li>
                    <li><a class="white-text" href="#!">Link 4</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            Made by <a class="brown-text text-lighten-3" href="http://materializecss.com">Materialize</a>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/nouislider.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.sidenav').sidenav();
            let navHeight = $('#site-nav').height();
            let footerHeight = $('#page-footer').height();
            $('#app').css('minHeight', 'calc(100% - ' + (navHeight + footerHeight + 20) + 'px)');
        });
    </script>
    @yield('js')
</footer>
</body>
</html>
