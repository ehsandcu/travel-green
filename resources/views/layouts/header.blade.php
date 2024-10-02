<!doctype html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="csrf-token" content="{{ csrf_token() }}"/>
            <meta name="author" content="Muhammad Ehsan" />
            <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
            <title>Green Travel | @yield('title', 'Commuting Carbon Calculator')</title>

            {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}

            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Source+Serif+Pro:wght@400;700&display=swap" rel="stylesheet">

            <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
            <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
            <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
            <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}">
            <link rel="stylesheet" href="{{ asset('fonts/icomoon/style.css') }}">
            <link rel="stylesheet" href="{{ asset('fonts/flaticon/font/flaticon.css') }}">
            <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">
            <link rel="stylesheet" href="{{ asset('css/aos.css') }}">
            <link rel="stylesheet" href="{{ asset('css/style.css') }}">
            @yield('css')
        </head>
        <body>
            <div class="site-mobile-menu site-navbar-target">
                <div class="site-mobile-menu-header">
                    <div class="site-mobile-menu-close">
                        <span class="icofont-close js-menu-toggle"></span>
                    </div>
                </div>
                <div class="site-mobile-menu-body"></div>
            </div>
        
            <nav class="site-nav">
                <div class="container">
                    <div class="site-navigation">
                        <a href="{{ route('home')}}" class="logo m-0 text-decoration-none">Green Travel <span class="text-primary">.</span></a>
        
                        <ul class="js-clone-nav d-none d-lg-inline-block text-left site-menu float-end">
                            <li class="active"><a href="{{ route('home') }}">Home</a></li>
                            <li class="has-children">
                                <a href="#">Dropdown</a>
                                <ul class="dropdown">
                                    <li><a href="elements.html">Elements</a></li>
                                    <li><a href="#">Menu One</a></li>
                                    <li class="has-children">
                                        <a href="#">Menu Two</a>
                                        <ul class="dropdown">
                                            <li><a href="#">Sub Menu One</a></li>
                                            <li><a href="#">Sub Menu Two</a></li>
                                            <li><a href="#">Sub Menu Three</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Menu Three</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('service.index') }}">Services</a></li>
                            <li><a href="{{ route('about.us') }}">About</a></li>
                            <li><a href="{{ route('contact.us') }}">Contact Us</a></li>
                        </ul>        
                        <a href="#" class="burger ml-auto float-right site-menu-toggle js-menu-toggle d-inline-block d-lg-none light" data-toggle="collapse" data-target="#main-navbar">
                            <span></span>
                        </a>        
                    </div>
                </div>
            </nav>