@extends('layouts.master')
@section('slider')
<div id="main" style="margin-top: -50px; margin-bottom: 10px;">
    <div id="carousel-example-captions" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-captions" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-captions" data-slide-to="1"></li>
            <li data-target="#carousel-example-captions" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="item active" style="overflow: hidden; height: 310px; background-color: black;">
                <center><img src="/img/hof/slider/1.jpg" style="width: 1980px; margin-top: -400px;"></center>
                <div class="carousel-caption">
                    <h3>Nocturne</h3>
                    <p>Are you my nightmare, or am I yours?</p>
                </div>
            </div>
            <div class="item" style="overflow: hidden; height: 310px; background-color: black;">
                <center><img src="/img/hof/slider/2.jpg" style="width: 1980px; margin-top: -250px;"></center>
                <div class="carousel-caption">
                    <h3>Riven</h3>
                    <p>A broken blade is more than enough for the likes of you!</p>
                </div>
            </div>
            <div class="item" style="overflow: hidden; height: 310px; background-color: black;">
                <center><img src="/img/hof/slider/3.jpg" style="width: 1980px; margin-top: -150px;" ></center>
                <div class="carousel-caption">
                    <h3>Thresh</h3>
                    <p>Me, mad? Haha... quite likely.</p>
                </div>
            </div>
        </div>
        <a class="left carousel-control" href="#carousel-example-captions" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-example-captions" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>
</div>
@stop
@section('content')
<center>
<h1>Coming soon</h1>
<p>
<a href="/faq">Read FAQ</a>
</p>
<br/>{{--
<a id="linkfaq" href="#">Read FAQ</a>
<div id="faq" style="display: none;">
    test
</div>--}}
</center>
@stop
@section('jsfooter')
@parent
<script>
    $(document).ready(function() {
        $('#linkfaq').click(function() {
            $('#faq').toggle('slow');
        });
    });
</script>
@stop