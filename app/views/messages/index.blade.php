@extends('layouts.master')
@section('content')
<h1>Messages</h1>
<hr>
<p>
    <a class="btn btn-primary" href="/messages/new">Compose</a>
    <a class="btn btn-danger" href="/messages/emptyall">Empty all</a>
</p>
@if(!$messages->isEmpty())
<table class="table">
    <thead>
        <tr>
            <th>Title</th>
            <th>From</th>
            <th>Date</th>
            <th style="width:150px;"><center>Actions</center></th>
        </tr>
    </thead>
    <tbody>
        @foreach($messages as $message)
        <?php
        $data = json_decode($message->data);
        ?>
        <tr @if($message->read==0) {{"class='warning'"}} @endif>
            <td><a href="/messages/read/{{ $message->id }}">{{ $data->title }}</a></td>
            <td><a href="/profile/{{ $data->sender }}">{{ $data->sender }}</a></td>
            <td><span data-toggle="tooltip" data-placement="right" title="{{ Lop::when($message->date) }}" >{{ Lop::time_elapsed_string(strtotime($message->date)) }}</span></td>
            <td>
                <center>
                    @if($message->read=='0')
                    <a href="/messages/markasread/{{ $message->id }}" style="text-decoration: none; ">
                        <span data-toggle="tooltip" data-placement="bozzom" title="Mark as read" class="glyphicon glyphicon-ok"></span>
                    </a>
                    @endif
                    <a href="/messages/delete/{{ $message->id }}" style="text-decoration: none; color: red;">
                        <span data-toggle="tooltip" data-placement="bozzom" title="Delete" class="glyphicon glyphicon-remove"></span>
                    </a>
                </center>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>
<div class="alert alert-info">
    You don't have any message(s) in your inbox.
</div>
</p>
@endif
@stop
@section('jsfooter')
@parent
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip({html: true});
    });
</script>
@stop