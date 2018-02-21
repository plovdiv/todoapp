<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title> {{ config('app.name', 'TODO APP') }}</title>
        <link rel="stylesheet" href="{{ mix('css/app.css', 'dist') }}">
    </head>
    <body data-page="{{data_page()}}">
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
                        <a class="navbar-brand" href="{{ \Entrust::hasRole('admin') ? url('/admin')
                            : url('/') }}">
                            {{ config('app.name', 'TODO APP') }}
                        </a>
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            &nbsp;
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @if (Auth::user())

                            @role('owner')
                            <li><a href="{{ url(route('lists')) }}">Lists</a></li>
                            <li><a href="{{ url(route('lists.archived')) }}">Archived Lists</a></li>
                            @endrole
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url(route('logout')) }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url(route('logout')) }}" method="POST"
                                              style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @else
                            <li><a href="{{ url(route('register')) }}">Register</a></li>
                            <li><a href="{{ url(route('login')) }}">Login</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @include('flash::message')
                    </div>
                </div>
                <div class="row">
                    <div class="container">
                        <div class="col-sm-offset-1 col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">Welcome</div>

                                <div class="panel-body">
                                    TODO Application.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </div>
            <footer >
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            ©todoapp {{  date('Y') }} 
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <script type="text/javascript" src="{{ mix('js/app.js', 'dist') }}"></script>
    </body>
</html>