@extends('layouts.admin')
@section('content')
<h1>News</h1>
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
    <div class="panel-heading">Publish</div>
    <div class="panel-body">
        {{ Form::open(array(
            'url' => '/admin/news/new',
            'method' => 'POST',
            'role' => 'form'
            )) }}            
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" id="title" placeholder="Enter title">
            </div>
            <div class="form-group">
                <label for="description">Text</label>
                <div id="editor"></div>
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        {{ Form::close() }}
    </div>
</div>
@if(!$news->isEmpty())
<div class="panel panel-default">
    <div class="panel-body">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Publisher</th>
                    <th>Active</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($news as $new)
                <tr>
                    <td>{{ $new->id }}</td>
                    <td>{{ '<a href="/admin/news/edit/'.$new->id.'">'.$new->title.'</a>' }}</td>
                    <td>{{ Lop::when($new->date) }}</td>
                    <td>{{ $new->publisher_name }}</td>
                    <td>
                        <?php
                        if ($new->active == 1) {
                            echo 'Yes (<a href="/admin/news/hide/'.$new->id.'">hide</a>)';
                        } elseif ($new->active == 0) {
                            echo 'No (<a href="/admin/news/show/'.$new->id.'">show</a>)';
                        }
                        ?>
                    </td>
                    <td>
                        <a href="/admin/news/delete/{{ $new->id }}"><span class="glyphicon glyphicon-remove" style="cursor: pointer; color: #e74c3c;"></span></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
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