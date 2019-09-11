<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel VUE - Lading page </title>
        <link href="{{ asset('css/landing.css') }}" rel="stylesheet">

    </head>
    <body>
        <div id="page-container">
            <div id="header" class="header navbar navbar-expand-md navbar-transparent fixed-top">
                <!-- begin container -->
                <div class="container">
                    <!-- begin navbar-header -->
                    <div class="navbar-header">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <a href="/" class="navbar-brand">
                            <img src="/images/vue-laravel.png" alt="Laravel Vue App" class="brand-image">
                        </span>
                        </a>
                    </div>
                    <!-- end navbar-header -->
                    <!-- begin navbar-collapse -->
                    <div class="collapse navbar-collapse" id="header-navbar">

                        <ul class="nav navbar-nav ml-md-auto">
                            @if (Route::has('login'))
                                    @auth
                                        <li class="nav-item"><a href="/app" class="nav-link" data-click="scroll-to-target">Dashboard</a></li>
                                    @else
                                        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link" data-click="scroll-to-target">LOGIN</a></li>

                                        @if (Route::has('register'))
                                            <li class="nav-item"><a href="{{ route('register') }}" class="nav-link" data-click="scroll-to-target">REGISTER</a></li>
                                        @endif
                                    @endauth
                            @endif
                        </ul>
                    </div>
                    <!-- end navbar-collapse -->
                </div>
                <!-- end container -->
            </div>
            <div id="home" class="content has-bg home" style="height: 944px;">
                <!-- begin content-bg -->
                <div class="content-bg">
                    <img src="/images/home-bg.jpg" alt="Home">
                </div>
                <!-- end content-bg -->
                <!-- begin container -->
                <div class="container home-content">
                    <h1>Welcome to LaraVue</h1>
                    <h3>A study application</h3>
                    <p>
                        This project is only for the study purpose, integration of Laravel with VUE. This application is purely for practicing the different aspects for laravel and VueJS.
                    </p>
                    <p>
                        Theme inspired from <a href="http://webapplayers.com/homer_admin-v2.0/" target="_blank">Homer</a> and <a href="https://wrapbootstrap.com/theme/color-admin-admin-template-front-end-WB0N89JMK" target="_blank"> Color Admin</a> please get permission from author or buy the theme for commercial use.
                    </p>
                </div>
                <!-- end container -->
            </div>
        </div>
    </body>
</html>
