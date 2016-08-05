@extends('layouts.master')
@section('content')
<h1>My Plays</h1>
<hr>
@if(Session::has('message_success'))
<div class="alert alert-success">
    {{ Session::get('message_success'); Session::forget('message_success') }}
</div>
@endif
<div class="well" style="max-width: 400px;">
    <a href="/submit" class="btn btn-primary btn-lg btn-block"><span class="glyphicon glyphicon-facetime-video"></span> Submit</a>
    <a href="/my/manager" class="btn btn-primary btn-lg btn-block"><span class="glyphicon glyphicon-tasks"></span> Manager</a>
    <a href="/my/stats" class="btn btn-primary btn-lg btn-block"><span class="glyphicon glyphicon-stats"></span> Statistics</a>
</div>
@stop