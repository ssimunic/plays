@extends('layouts.master')
@section('content')
<h1>News</h1>
<hr>
@if(!$news->isEmpty())
@foreach($news as $new)
@if($new->active==1)
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">
            <strong>
                <a style="text-decoration: none; color: white;" href="/news/{{ $new->id }}">{{ $new->title }}</a>
            </strong> 
            &bullet; 
            <span data-toggle="tooltip" data-placement="right" title="{{ Lop::when($new->date) }}">{{ Lop::time_elapsed_string(strtotime($new->date)) }}</span>
            @if(Auth::user() && Auth::user()->user_type_id==4)
            &nbsp; <a href="/admin/news/edit/{{ $new->id }}"><span class="glyphicon glyphicon-pencil"></span></a>
            @endif                      
        </h3>
        <div class="pull-right" style="margin-top: -20px;">
        <div class="pw-widget pw-size-medium" pw:title="{{ $new->title}} - PLAYS.GG" pw:url="http://{{ Lop::domain }}/news/{{ $new->id}}">
            <a class="pw-button-twitter"></a>
            <a class="pw-button-facebook"></a>
            <a class="pw-button-googleplus"></a>
            <a class="pw-button-reddit"></a>
            <a class="pw-button-email"></a>
        </div>
        <script src="http://i.po.st/static/v3/post-widget.js#publisherKey=ashmku9c4rpdfe78oq0d&retina=true" type="text/javascript"></script>
        </div>
    </div>
    <div class="panel-body">
        {{ $new->text }}
    </div>
</div>
<hr>
@endif
@endforeach

<center><?php echo $news->links(); ?></center>
@else
<div class="alert alert-info">
    No news available.
</div>
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