@extends('layouts.master')
@section('content')
<h1>Login</h1>
<hr>
@if(Session::has('message_error'))
<div class="alert alert-danger">{{ Session::get('message_error'); Session::forget('message_error') }}</div>
@endif
@if(Session::has('message'))
<div class="alert alert-success">{{ Session::get('message'); Session::forget('message') }}</div>
@endif
{{ Form::open(array(
            'url' => 'login',
            'method' => 'POST',
            'class' => 'form-horizontal',
            'role' => 'form'
            )) }}
<div class="form-group">
    <label for="username" class="col-sm-2 control-label"><span class="glyphicon glyphicon-user"></span> Username</label>
    <div class="col-sm-5">
        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
    </div>
</div>
<div class="form-group">
    <label for="password" class="col-sm-2 control-label"><span class="glyphicon glyphicon-lock"></span> Password</label>
    <div class="col-sm-5">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-5">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember"> Remember me
            </label>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-5">
        <button type="submit" class="btn btn-default">Submit</button>
    </div>
</div>
{{ Form::close() }}
@stop