<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>{{ $title }} - {{ Lop::webname }}</title>

        <!-- Bootstrap core CSS -->
        {{ HTML::style('/dist/css/'.$theme.'.css') }}

        <!-- Add custom CSS here -->
        {{ HTML::style('/css/admin.css') }}
    </head>

    <body>
        
        <div id="wrapper">
            @section('nav')
            <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">PLAYS.<span style="color: #18bc9c;">GG</span></a>
                </div>
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <li @if(Request::is('admin')) class="active" @endif><a href="/admin"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                        <li @if(Request::is('admin/plays')) class="active" @endif><a href="/admin/plays"><i class="fa fa-dashboard"></i>Plays</a></li>
                        <li @if(Request::is('admin/users')) class="active" @endif><a href="/admin/users"><i class="fa fa-dashboard"></i>Users</a></li>
                        <li @if(Request::is('admin/news')) class="active" @endif><a href="/admin/news"><i class="fa fa-dashboard"></i>News</a></li>
                        <li @if(Request::is('admin/payments')) class="active" @endif><a href="/admin/payments"><i class="fa fa-dashboard"></i>Payments</a></li>
                    </ul>
                </div>
            </nav>
            @stop
            @yield('nav')
            
            <div id="page-wrapper">
                @yield('content')
            </div>
            
        </div>

        @section('jsfooter')
        {{ HTML::script('https://code.jquery.com/jquery-1.10.2.min.js') }}
        <!-- Loading bar -->
        {{ HTML::style('/dist/nprogress.css') }}
        {{ HTML::script('/dist/nprogress.js') }}
        <script>
            NProgress.start();
        </script>
        {{ HTML::script('/dist/js/bootstrap.min.js') }}
        @stop
        @yield('jsfooter')
        <script>
            NProgress.done();
        </script>
        
    </body>
</html>
