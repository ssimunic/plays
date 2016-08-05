@extends('layouts.admin')
@section('content')
<h1>{{ $user->username }}</h1>
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
@if(Session::has('message_success'))
<div class="alert alert-success">
    {{ Session::get('message_success'); Session::forget('message_success') }}
</div>
@endif
<div class="panel panel-default">
    <div class="panel-heading">User Information</div>
    <div class="panel-body">
        {{ Form::open(array(
            'url' => '/admin/users/save',
            'method' => 'POST',
            'role' => 'form',
            'class' => 'form-horizontal'
            )) }}   
    <input type="hidden" name="id" value="{{ $user->id }}">
        <div class="form-group">
            <label for="id" class="col-sm-1 control-label">ID</label>
            <div class="col-sm-10">
                <p class="form-control-static">{{ $user->id }}</p>
            </div>
        </div>
        <div class="form-group">
            <label for="username" class="col-sm-1 control-label">Username</label>
            <div class="col-sm-10">
                <p class="form-control-static">{{ $user->username }}</p>
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-1 control-label">Email</label>
            <div class="col-sm-3">
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" placeholder="Email">
            </div>
        </div>
        <div class="form-group">
            <label for="p_email" class="col-sm-1 control-label">Payment Email</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="p_email" name="p_email" value="{{ $user->p_email }}" placeholder="Payment Email">
            </div>
        </div>
        <hr>
        <div class="form-group">
            <label for="usertype" class="col-sm-1 control-label">User Type</label>
            <div class="col-sm-2">
                <select class="form-control" name="usertype">
                    <option value="0" @if($user->user_type_id==0) selected @endif><span class="text-muted">Banned</span></option>
                    <option value="1" @if($user->user_type_id==1) selected @endif>Default</option>
                    <option value="2" @if($user->user_type_id==2) selected @endif>Premium</option>
                    <option value="4" @if($user->user_type_id==4) selected @endif>Admin</option>
                </select>
            </div>
            @if($user->user_type_id==2)
            <label for="premium_till" class="col-sm-1 control-label">Premium Till</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="premium_till" name="premium_till" value="{{ $user->premium_till }}" placeholder="Premium Till">
            </div>
            @endif
        </div>
        <div class="form-group">
            <label for="display_name" class="col-sm-1 control-label">Display Name</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="display_name" name="display_name" value="{{ $user->display_name }}" placeholder="Display Name">
            </div>
        </div>
        <div class="form-group">
            <label for="avatar" class="col-sm-1 control-label">Avatar</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="avatar" name="avatar" value="{{ $user->avatar }}" placeholder="Avatar">
            </div>
            <div class="col-sm-1">
                <img style="height: 42px; width: 42px; border-radius: 5px; border: 1px solid #dddddd; pointer-events: none;" src="/img/{{ $user->avatar }}.jpg">
            </div>
        </div>
        <hr>
        <div class="form-group">
            <label for="data" class="col-sm-1 control-label">User Data [<a id="hmedals" href="#mexample">?</a>]</label>
            <div class="col-sm-10">
                <div id="data_p">
                <p class="form-control-static"><pre style="font-size: 11px; cursor: pointer;">{{ JSON::prettyPrint($user->data, true) }}</pre></p>
                </div>
                <textarea style="display: none;" class="form-control" rows="5" name="data" id="data" placeholder="Data">{{ $user->data }}</textarea>
                <div id="mexample" style="display: none;">
                    Example:
                    <code>
                        {{{ '"medals":{"Conest 1<sup>st</sup> Place<br>Jan 20th, 2014":"gold/medal-award-gold-icon", ... }' }}}
                    </code>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="sdata" class="col-sm-1 control-label">Summoners</label>
            <div class="col-sm-10">
                <div id="summoners_p">
                <p class="form-control-static"><pre style="font-size: 11px; cursor: pointer;">{{ JSON::prettyPrint($user->summoner_data, true) }}</pre></p>
                </div>
                <textarea style="display: none;" class="form-control" rows="5" name="sdata" id="sdata" placeholder="Summoner Data">{{ $user->summoner_data }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-1 col-sm-10">
                <button type="submit" class="btn btn-default">Save</button>
            </div>
        </div>
        
        {{ Form::close() }}
    </div>
</div>
@stop
@section('jsfooter')
@parent
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript">
    $("#summoners_p").click(function(){
        $("#sdata").show().focus();
        $("#summoners_p").hide();
    });
    
    $("#data_p").click(function(){
        $("#data").show().focus();
        $("#data_p").hide();
    });
    
    $("#hmedals").click(function(){
        $("#mexample").toggle('fast');
    });
    
    $(function() {
        $( "#premium_till" ).datepicker({ dateFormat: "yy-mm-dd 00:00:00" });
    });
</script>
@stop
