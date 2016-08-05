@extends('layouts.master')
@section('content')
<h1>Manager </h1>
<hr>
@if(!$plays->isEmpty())
<ul class="list-group">
@foreach($plays as $play)
<?php $data = json_decode($play->data); ?>
<li class='list-group-item'>
    <a href="/my/manager/{{ $play->id }}" >
        <div class="pull-right">
        <div class="pw-widget pw-size-medium" pw:title="{{ $play->name}} - {{ Lop::webname }}" pw:url="http://{{ Lop::domain }}/{{ $play->id}}">
            <a class="pw-button-twitter"></a>
            <a class="pw-button-facebook"></a>
            <a class="pw-button-googleplus"></a>
            <a class="pw-button-reddit"></a>
            <a class="pw-button-email"></a>
        </div>
        <script src="http://i.po.st/static/v3/post-widget.js#publisherKey=ashmku9c4rpdfe78oq0d&retina=true" type="text/javascript"></script>
        </div>
        <a href='/my/manager/{{ $play->id }}' style='text-decoration: none;'>
        @if($play->active==0)
        @if($data->passedvalidation=='pending')
        <span class="label label-warning">
        @elseif($data->passedvalidation==false)
        <span class="label label-danger">
        @endif
        @elseif($play->type==0)
        <span class="label label-danger">
        @elseif($play->type==1)
        <span class="label label-default">
        @elseif($play->type==2)
        <span class="label label-success">
        @endif
        {{ $play->name }}</span> 
        </a>
        <small>{{ Lop::when($play->date) }}</small>
    </a>
</li>
@endforeach
</ul>
@else
<div class="alert alert-info"><b>You don't have any plays on our website!</b> If you would like, you can submit one <a href='/submit'>here</a> and manage it later.</div>
@endif
<hr>
<p id='legend'>
<span class="label label-default">Default</span>
<span class="label label-success">Featured</span>
<span class="label label-warning">Pending Validation</span>
<span class="label label-danger">Deleted</span>
</p>
@stop
@section('jsfooter')
@parent
<script type='text/javascript'>
    $( document ).ready(function() {
        $('#legend').delay(5000).fadeOut('slow');
    });
</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-52c6a80d0fc68989"></script>
@stop