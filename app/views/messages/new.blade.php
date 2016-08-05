@extends('layouts.master')
@section('content')
<h1>Compose</h1>
<hr>
@if(Session::has('message_fail'))
<div class="alert alert-danger">
    {{ Session::get('message_fail'); Session::forget('message_fail') }}
</div>
@endif
@if(Session::has('message_success'))
<div class="alert alert-success">
    {{ Session::get('message_success'); Session::forget('message_success') }}
</div>
@endif
{{ Form::open(array(
            'url' => 'messages/new',
            'method' => 'POST',
            'class' => 'form-horizontal',
            'role' => 'form',
            )) }}
<form class="form-horizontal" role="form">
    <div class="form-group">
        <label for="receiver" class="col-sm-2 control-label">Receiver</label>
        <div class="col-sm-8">
            <?php
            $username = '';
            if($user)
            {
                $username = $user->username;
            }
            ?>
            <input type="text" name="receiver" class="form-control" id="receiver" placeholder="Receiver" value="{{ $username }}">
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label for="receiver" class="col-sm-2 control-label">Title</label>
        <div class="col-sm-8">
            <input type="text" name="title" class="form-control" id="title" placeholder="Title" value="{{ base64_decode($mtitle) }}">
        </div>
    </div>
    <div class="form-group">
        <label for="message" class="col-sm-2 control-label">Message</label>
        <div class="col-sm-8">
            <textarea name="message" class="form-control" placeholder="Enter any text here..." rows="8"></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-8">
            <button type="submit" class="btn btn-default">Send</button>
        </div>
    </div>
{{ Form::close() }}
@stop