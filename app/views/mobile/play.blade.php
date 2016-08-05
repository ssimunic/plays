@extends('layouts.master')
@section('content')
@if($play->type == 0)
<div class='alert alert-danger'>
    <span class="glyphicon glyphicon-ban-circle"></span> This play has been deleted by the user.
</div>
@elseif($play->active==1)
<div id="standout" class='playvideo'>
    <p class="playyoutubevideo" @if($play->type==2) {{--style='border-color: #d6e9c6'--}} @endif>
        <object width="560" height="315">
            <param name="movie" value="https://www.youtube.com/v/{{ YouTube::getID($play->link) }}?version=3&amp;hl=hr_HR"></param>
            <param name="allowFullScreen" value="true"></param>
            <param name="allowscriptaccess" value="always"></param>
            <embed id="video" {{--class="playyoutube_video_submit_embed" style="border-radius: 3px;"--}} src="https://www.youtube.com/v/{{ YouTube::getID($play->link) }}?enablejsapi=1&version=3&autohide=1&showinfo=0&rel=0&iv_load_policy=3" type="application/x-shockwave-flash" width="1134" height="650" allowscriptaccess="always" allowfullscreen="true"></embed>
        </object>
    </p>
</div>
<?php
$upstyle = '';
$downstyle = '';
?>
@foreach($votes as $vote)
@if($vote->play_id == $play->id && $vote->user_id == Auth::user()->id)
@if($vote->type=='upvote')
<?php
$upstyle = 'background-color: orange';
$downstyle = 'background-color: #999';
?>
@elseif($vote->type=='downvote')
<?php
$upstyle = 'background-color: #999';
$downstyle = 'background-color: orange';
?>
@endif
@endif
@endforeach
<table style="border-collapse:collapse; width: 100%;">
<tr>
    <td align="left">
    <span style="font-size: 130%; font-family: 'Open Sans'; font-style: normal; font-weight: 300; line-height: 10px;">
        Submitted by <a href="/profile/{{ $play->user->id }}">{{ $play->user->username }}</a>, 
        <span style="color: grey" data-toggle="tooltip" data-placement="right" title="{{ Lop::when($play->date) }}" >
            {{ Lop::time_elapsed_string(strtotime($play->date)) }}
        </span>
    </span>
    </td>
</tr>
</table>
<div id="logintovote" style="display: none;"><p><div class="alert alert-info">Please login to upvote/downvote plays.</div></p></div>
<p style="margin-top: 10px;">
    {{ $play->description }}
</p>
@elseif($play->active == 0)
@if($data->passedvalidation==false)
<div class='alert alert-danger'>
    <span class="glyphicon glyphicon-eye-open"></span> This play hasn't passed content validation. For any further questions, please contact us.
</div>
@elseif($data->passedvalidation=='pending')
<div class='alert alert-warning'>
    <span class="glyphicon glyphicon-eye-open"></span> This play is going through content validation and soon it will be properly displayed.
</div>
@endif
@endif
@stop
@section('jsfooter')
@parent
{{ HTML::script('/dist/jquery.fitvids.js') }}
<script type="text/javascript">
$(document).ready(function() {
    $(".playvideo").fitVids();
});
</script>
@stop