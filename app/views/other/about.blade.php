@extends('layouts.master')
@section('content')
<h1>About</h1>
<hr>
<p>
    We are Internet enthusiasts and developers under name <i>Artikan</i>. 
    On our website, <a href="http://artikan.co" target="_blank">artikan.co</a>, you can read more about us. <br/>
    Idea about <i>{{ Lop::webname }}</i>, place where you can watch daily plays from players all around the world, was born back in Decemeber 2013,
    but due to personal obligations we started working on this project intensively in January 2014.
</p>
<legend>Promotional Trailer</legend>
<div id="standout" class='playvideo'>
    <p class="playyoutubevideo"   >
        <object width="560" height="315">
            <param name="movie" value="https://www.youtube.com/v/{{ Lop::trailer_id }}?version=3&amp;hl=hr_HR"></param>
            <param name="allowFullScreen" value="true"></param>
            <param name="allowscriptaccess" value="always"></param>
            <embed id="video"  src="https://www.youtube.com/v/{{ Lop::trailer_id }}?enablejsapi=1&version=3&autohide=1&showinfo=0&rel=0&iv_load_policy=3" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true"></embed>
        </object>
    </p>
</div>

<legend>Specifications</legend>
<table class="table table-condensed">
    <thead>
        <th>Webname</th>
        <th>Domain</th>
        <th>Version</th>
        <th>Engine</th>
        <th>Server</th>
    </thead>
    <tbody>
        <tr>
            <td>
                <code>{{ Lop::webname }}</code>
            </td>
            <td>
                <code>{{ Lop::domain }}</code>
            </td>
            <td>
                <code>{{ Lop::version }}</code>
            </td>
            <td>
                <code>Laravel/{{ Server::getLaravelVersion() }}</code>
            </td>
            <td>
                <code>{{ Server::getApacheAndPHPVersion() }}</code>
            </td>
        </tr>
    </tbody>
</table>
@stop
@section('jsfooter')
@parent
{{ HTML::script('/dist/jquery.fitvids.js') }}

<script type="text/javascript">
    $(".playvideo").fitVids();
</script>
@stop