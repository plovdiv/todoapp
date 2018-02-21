<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta name="robots" content="noindex, nofollow">
        <meta charset="utf-8"/>
        <title>{{ config('app.name', 'TODO APP') }}</title>
        <meta name="description" content="{{ config('app.name', 'TODO APP') }}"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ mix('css/app.css', 'dist') }}">
        <script type="text/javascript" src="{{ mix('js/app.js', 'dist') }}"></script>
    </head>

    <body class="public-public-index">
        <div id="app">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container-fluid">
                    <div class="navbar-header">

                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <!-- Branding Image -->
                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'TODO APP') }}
                        </a>
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            &nbsp;
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        ©todoapp @php  echo date('Y') @endphp 
                    </div>
                </div>
            </div>
        </footer>

    </body>
</html>