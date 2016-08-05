@extends('layouts.master')
@section('content')
<h1>Registration</h1>
<hr>
@if(!$errors->isEmpty())
<div class="alert alert-danger">
    @if(Session::has('message'))
        {{ Session::get('message'); Session::forget('message') }}
    @endif
    <ul>
        @foreach($errors->all() as $error)
        <li> {{ $error }} </li>
        @endforeach
    </ul>
</div>
@endif
{{ Form::open(array(
            'url' => 'registration',
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
    <label for="email" class="col-sm-2 control-label"><span class="glyphicon glyphicon-envelope"></span> E-mail</label>
    <div class="col-sm-5">
        <input type="email" class="form-control" id="email" name="email" placeholder="E-mail address">
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-5">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="terms"> I agree to the <a href="/tos" target="_blank">Terms and Conditions</a>
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