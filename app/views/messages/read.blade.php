@extends('layouts.master')
@section('content')
<?php
$data = json_decode($message->data);
?>
<h1>{{ $data->title }} <small>from <a href="/profile/{{ $data->sender }}">{{ $data->sender }}</a>, <span data-toggle="tooltip" data-placement="right" title="{{ Lop::when($message->date) }}" >{{ Lop::time_elapsed_string(strtotime($message->date)) }}</span></small></h1>
<hr>
<div class="panel panel-default">
    <div class="panel-body">
        {{ $message->text }}
    </div>
</div>
<a href="/messages/new/{{ $message->sender }}/{{ base64_encode('Re: '.$data->title) }}" class="btn btn-default">Reply</a>
<a href="/messages/delete/{{ $message->id }}" class="btn btn-danger">Delete</a>
@stop
@section('jsfooter')
@parent
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip({html: true});
    });
</script>
@stop