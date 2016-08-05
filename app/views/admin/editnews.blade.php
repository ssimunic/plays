@extends('layouts.admin')
@section('content')
<h1>ID: {{ $new->id }}</h1>
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

        {{ Form::open(array(
            'url' => '/admin/news/save',
            'method' => 'POST',
            'role' => 'form'
            )) }}       
            <input type="hidden" name="id" value="{{ $new->id }}">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="{{ $new->title }}">
            </div>
            <div class="form-group">
                <label for="description">Text</label>
                <div id="editor"></div>
            </div>
            <button type="submit" class="btn btn-default">Save</button>
        {{ Form::close() }}
 
@stop
@section('jsfooter')
@parent
<!-- elRTE -->
<script src="/dist/elrte-1.3/js/jquery-1.6.1.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/dist/elrte-1.3/js/elrte.min.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="/dist/elrte-1.3/css/elrte.min.css" type="text/css" media="screen" charset="utf-8">
<script src="/dist/elrte-1.3/js/jquery-ui-1.8.13.custom.min.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="/dist/elrte-1.3/css/smoothness/jquery-ui-1.8.13.custom.css" type="text/css" media="screen" charset="utf-8">
<!-- elRTE translation messages -->
<script src="/dist/elrte-1.3/js/i18n/elrte.ru.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    document.getElementById('editor').innerHTML = '{{ addslashes($new->text) }}';
    $().ready(function() {
        var opts = {
            cssClass: 'el-rte',
            height: 350,
            toolbar: 'complete',
            cssfiles: ['/dist/elrte-1.3/css/elrte-inner.css']
        }
        $('#editor').elrte(opts);
    })
</script>
@stop