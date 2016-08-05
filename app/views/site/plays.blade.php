@extends('layouts.master')
@section('content')
{{ Form::open(array(
            'url' => 'plays',
            'method' => 'GET',
            'role' => 'form'
            )) }}
<div id="sticker" style="z-index: 999; @if($theme=='theme1') margin-top: 11px; @elseif($theme=='bootstrap') margin-top: 0px; @endif">
<div class="input-group">
    <input type="text" name="q" class="form-control" value="{{ Input::get('q') }}">
    <div class="input-group-btn">
        <button type="submit" class='btn btn-primary'>Search</button>
        <button id="expand" type="button" class="btn btn-primary dropdown-toggle togglefilters">
            <span class="caret"></span>
            <span class="sr-only">Toggle Filter</span>
        </button>
    </div>
</div>
</div>

<div class="panel panel-default filters" style="display: none;margin-top: 5px;">
    <div class="panel-body">
        <legend style="font-size: 15px;">Date</legend>
        <label class="radio-inline">
            <input type="radio" name="date" value="hour" @if(Input::get('date')=='hour') checked @endif>
            Last hour
        </label>


        <label class="radio-inline">
            <input type="radio" name="date" value="today" @if(Input::get('date')=='today') checked @endif>
            Today
        </label>


        <label class="radio-inline">
            <input type="radio" name="date" value="week" @if(Input::get('date')=='week') checked @endif>
            This week
        </label>


        <label class="radio-inline">
            <input type="radio" name="date" value="month" @if(Input::get('date')=='') checked @endif @if(Input::get('date')=='month') checked @endif>
            This month
        </label>


        <label class="radio-inline">
            <input type="radio" name="date" value="year" @if(Input::get('date')=='year') checked @endif>
            This year
        </label>
        <br/><br/>   
        
        <legend style="font-size: 15px;">Sort</legend>
        <label class="radio-inline">
            <input type="radio" name="sort" value="date" @if(Input::get('sort')=='') checked @endif @if(Input::get('sort')=='date') checked @endif>
            Date
        </label>
        <label class="radio-inline">
            <input type="radio" name="sort" value="score" @if(Input::get('sort')=='score') checked @endif>
            Score
        </label>

        <br/><br/>
        <legend style="font-size: 15px;">Champion {{--<small><a href="javascript:;" id="clearlink">clear</a></small>--}}</legend>
        @include('other.champselection')
    </div>
</div>

<hr>
@if(!$plays->isEmpty())
<?php $i=0; ?>
@foreach($plays as $play)
<?php if($i==0)
{
    echo '<div class="row">';
}
?>
<div class="col-md-4" style="margin-bottom: 30px;">

<a data-toggle="tooltip" href="/{{ $play->id }}">
    <p style="position: absolute; top: 223px; left: 20px;">
        <span class="label label-default" style="" data-toggle="tooltip" data-placement="bottom" title="Score" >{{ $play->score }}</span>
        <span class="label label-info" style="" data-toggle="tooltip" data-placement="bottom" title="{{ Lop::when($play->date) }}" >{{ Lop::time_elapsed_string(strtotime($play->date)) }}</span>
        <span class="label text-muted" style="background-color: transparent;">submitted by {{ $play->user->username }}</span>
        <span class="label text-muted" style="background-color: transparent;">(<strong>{{ $play->comments->count() }}</strong> comments)</span>
    </p> 
    <img class="img-responsive youtube_video_submit" src="{{ YouTube::getThumbnail($play->link) }}" style="cursor: pointer; width: 700px; height: 250px; @if($play->type==0) color: #e74c3c; opacity: 0.5; @endif">
</a>
<h3>
    <a href="/{{ $play->id }}" style='@if($play->type==0) color: #e74c3c; opacity: 0.5; @endif'>{{ $play->name }}</a>
</h3>
 
</div>
<?php $i=$i+1; ?>

<?php if($i==3)
{
    echo '</div>';
    $i=0;
}
?>
@endforeach
</div>
</div>
<center><?php echo $plays->appends(array_except(Input::all(), 'page'))->links(); ?></center>
@else
<div class="alert alert-info">No results found.</div>
@endif
{{ Form::close() }}
@stop
@section('jsfooter')
@parent
{{ HTML::script('/dist/sticky.js') }}
{{ HTML::style('/dist/image-picker/image-picker-champions.css') }}
{{ HTML::script('/dist/image-picker/image-picker.min.js') }}
<script type="text/javascript">
    $("#expand").click(function() {
		$("html, body").animate({ scrollTop: 0 }, "slow");
		return false;
	});
	
    $('#clearlink').click(function() {
        $("option:selected").removeAttr("selected");
        $("div").removeClass("selected");
    });
    
    $("select").imagepicker();

    $('.togglefilters').click(function() {
            $('.filters').toggle('fast');
    });
    
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip({html: true});
        $("#sticker").stick_in_parent({
           offset_top: 50
        });
    });
</script>
@stop