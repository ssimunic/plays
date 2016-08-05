<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="PLAYS.GG is a website where you can watch daily plays from players all around the world!">
        <meta name="keywords" content="plays, plays.gg, lol plays, league of legends plays, league plays, league pentakill, pentakills, hexakills, quadrakills, lol videos">
        <meta name="author" content="Artikan">
        <link rel="shortcut icon" href="">
        <meta name="autocomplete" content="off">

        <title>{{ Lop::webname }} - {{ $title }}</title>      
        @yield('wysihtml')
        
        @section('styles')
            <!-- Bootstrap core CSS -->
            {{ HTML::style('dist/css/'.$theme.'.css') }}
            <!-- Custom styles -->
            {{ HTML::style('css/main.css') }}
        @stop 
        @yield('styles')
        
        {{-- <div id="watermark"></div> --}}
    </head>
    <body>
        @include('layouts.nav')
        @yield('slider')
        @yield('mobile')
        {{ Lop::cover() }}
        <div style="background: url('/img/covers/{{ Session::get('cover') }}.jpg') no-repeat center center fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; opacity: 0.3; position: fixed; width: 100%; height: 100%; z-index: -1; margin-top: -100px;"></div>
        <div id="overlay"></div>
        <div id="wrap">
            <div class="container parallax containercover"  @if(Request::is('/')) style="min-width:850px;" @endif @if(Request::is('hof')) style="width: 100%; margin-top: -10px; min-width: 890px;" @endif>
                @yield('content')
            </div>
            @section('ads')
            <div class="container containercover">
                <center>
                    <img class="img-thumbnail" src="//storage.googleapis.com/support-kms-prod/SNP_3094702_en_v0" height="auto">
                </center>
            </div>
            @stop
            @if(!Auth::user() || Auth::user()->user_type_id<2)
                @yield('ads')
            @endif
        </div>      
        @include('layouts.footer')
        
        <!-- Bootstrap core JavaScript -->
        @section('jsfooter')
        {{ HTML::script('https://code.jquery.com/jquery-1.10.2.min.js') }}
        <!-- Loading bar -->
        {{ HTML::style('dist/nprogress.css') }}
        {{ HTML::script('dist/nprogress.js') }}
        <script>
            NProgress.start();
        </script>
        {{ HTML::script('dist/js/bootstrap.min.js') }}
        @stop
        @yield('jsfooter')
        <script>
            NProgress.done();
        </script>
        <!-- Piwik -->
        <script type="text/javascript">
          var _paq = _paq || [];
          _paq.push(['trackPageView']);
          _paq.push(['enableLinkTracking']);
          (function() {
            var u=(("https:" == document.location.protocol) ? "https" : "http") + "://plays.gg/piwik/";
            _paq.push(['setTrackerUrl', u+'piwik.php']);
            _paq.push(['setSiteId', 1]);
            var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
            g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
          })();

        </script>
        <noscript><p><img src="http://plays.gg/piwik/piwik.php?idsite=1" style="border:0;" alt="" /></p></noscript>
        <!-- End Piwik Code -->
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/hr_HR/all.js#xfbml=1";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		</script>
    </body>
</html>
