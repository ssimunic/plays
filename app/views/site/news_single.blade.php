@extends('layouts.master')
@section('content')
<h1>{{ $new->title }} 
    <small>
        <span data-toggle="tooltip" data-placement="top" title="{{ Lop::when($new->date) }}">{{ Lop::time_elapsed_string(strtotime($new->date)) }}</span>
    </small>
    <div class="pull-right" style="margin-top: 15px;">
        <div class="pw-widget pw-size-medium" pw:title="{{ $new->title}} - PLAYS.GG" pw:url="http://{{ Lop::domain }}/news/{{ $new->id}}">
            <a class="pw-button-twitter"></a>
            <a class="pw-button-facebook"></a>
            <a class="pw-button-googleplus"></a>
            <a class="pw-button-reddit"></a>
            <a class="pw-button-email"></a>
        </div>
        <script src="http://i.po.st/static/v3/post-widget.js#publisherKey=ashmku9c4rpdfe78oq0d&retina=true" type="text/javascript"></script>
    </div>
</h1>
<hr>
<p>
    {{ $new->text }}
</p>
@stop
@section('jsfooter')
@parent
<script type="text/javascript">
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip({html: true});
});
</script>
@stop