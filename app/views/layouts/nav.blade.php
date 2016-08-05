{{-- <link href="http://getbootstrap.com/docs-assets/css/docs.css" rel="stylesheet"> --}}
<div class="navbar navbar-{{ $navbarclass }} navbar-fixed-top " role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">PLAYS.<span style="color: #18bc9c;">GG</span></a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li @if(Request::is('/')) class="active" @endif>{{ HTML::link('/', 'Home') }}</li>
                <li @if(Request::is('plays')) class="active" @endif>{{ HTML::link('/plays', 'Plays') }}</li>
                <li @if(Request::is('hof')) class="active" @endif>{{ HTML::link('/hof', 'Hall of Fame') }}</li>
		<li><a href="#"><div class="fb-like" data-href="https://www.facebook.com/pages/PLAYSGG/514747211957156" data-layout="button" data-action="like" data-show-faces="true" data-share="false"></div></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li @if(Request::is('news')) class="active" @endif>{{ HTML::link('/news', 'News') }}</li>
                <li @if(Request::is('contests')) class="active" @endif>{{ HTML::link('/contests', 'Contests') }}</li>
                <li class="dropdown">

                    @if(Auth::check())
                    <?php
                    $messages = UserMessage::where('receiver', '=', Auth::user()->id)
                            ->where('read', '=', '0')
                            ->get();
                    ?>
                    @endif
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php
                        if(Auth::check() && $messages->count()>0) 
                        {
                            echo'<span class="glyphicon glyphicon-envelope" style="font-size: 80%; color: #fcf8e3;"></span>';
                        }
                        ?> 
                        @if(Auth::user() && Auth::check())
                            <span class="glyphicon glyphicon-user"></span> {{ Auth::user()->username }}
                        @else
                        <span class="glyphicon glyphicon-user"></span> User Area
                        @endif
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        @if(!Auth::check())
                        <!--guest-->
                        <li>{{ HTML::link('/registration', 'Registration') }}</li>
                        <li>{{ HTML::link('/login', 'Login') }}</li>
                        <!--/guest-->
                        @else
                        <!--member-->
                        <li>{{ HTML::link('/my', 'My Plays') }}</li>
                        <li>{{ HTML::link('/profile', 'Profile') }}</li> 
                        <li>{{ HTML::link('/account', 'Account') }}</li>
                        @if($messages->count()>0)
                        <li>{{ HTML::link('/messages', 'Inbox ('.$messages->count().')') }}</li>
                        @else
                        <li>{{ HTML::link('/messages', 'Inbox') }}</li>
                        <li>{{ HTML::link('/premium', 'Premium') }}</li>
                        @endif
                        <li class="divider"></li>
                        @if(Auth::user() && Auth::user()->user_type_id==4)
                        <li>{{ HTML::link('/admin', 'Admin') }}</li>
                        <li><a href="/piwik/index.php" target="_blank">Analytics </a></li>
                        <li class="divider"></li>
                        @endif
                        <li>{{ HTML::link('/logout', 'Logout') }}</li>
                        <!--/member-->
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
