@extends('layouts.master')
@section('content')
<h1>Contact <small>Wanna get in touch with us ?</small></h1>
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
@if(Session::has('message'))
<div class="alert alert-success">
    {{ Session::get('message'); Session::forget('message') }}
</div>
@endif
{{ Form::open(array(
            'method' => 'POST',
            'url' => '/contact',
            'role' => 'form',
            'class' => 'form-horizontal'
            )) }}
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-8">
            <input type="name" class="form-control" id="name" placeholder="Name" name="name">
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-8">
            <input type="email" class="form-control" id="email" placeholder="Email" name="email">
        </div>
    </div>
    <div class="form-group">
        <label for="message" class="col-sm-2 control-label">Message</label>
        <div class="col-sm-8">
            <textarea class="form-control" rows="7" name="message"></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Send</button>
        </div>
    </div>
{{ Form::close() }}


@stop