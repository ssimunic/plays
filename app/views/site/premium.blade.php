@extends('layouts.master')
@section('content')
<h1>Premium @if(Auth::user()->user_type_id>=2)<small>active</small>@endif</h1>
<hr>
@if(Auth::user()->user_type_id>=2)
<?php
$diff = strtotime(Auth::user()->premium_till)-time();
$days = ceil(abs($diff) / 86400);

if($days>30)
{
    $del = 365;
}
elseif($days<=30)
{
    $del = 30;
}

if(Auth::user()->user_type_id>2)
{
    $width = 100;
}
else
{
    $width = round($days/$del*100, 0);
}
?>
<div class="progress progress-striped active">
    <div class="progress-bar" style="width: {{ $width }}%" >
        @if(Auth::user()->user_type_id>2)
                <span style="padding-left: 10px;"><b>unlimited days left</b></span>
        @else
            @if($days>=4)
                <center><b>{{ $days }} days left</b></center>
            @endif
        @endif
    </div>
        @if(Auth::user()->user_type_id>2)
                <span style="padding-left: 10px;"><b>unlimited days left</b></span>
        @else
            @if($days<4)
                <span style="padding-left: 10px;"><b>{{ $days }} days left</b></span>
            @endif
        @endif
</div>
<hr>
@endif
@if(Auth::user()->user_type_id<2)
<div class="alert alert-info">
    Premium Membership gives you awesome features, and most importantly, it keeps our server running!
</div>
<hr>
@endif
<div class="row">
    <div class="col-md-4">
        <div class="well">
            <legend><center>No advertisements</center></legend>
            <img class="img-responsive img-circle img-thumbnail" src="/img/premium/1.png">
        </div>
    </div>
    <div class="col-md-4">        
        <div class="well">
            <legend><center>Display name</center></legend>
            <img class="img-responsive img-circle img-thumbnail" src="/img/premium/2.png">
        </div>
    </div>
    <div class="col-md-4">
        <div class="well">
            <legend><center>Extended play description</center></legend>
            <img class="img-responsive img-circle img-thumbnail" src="/img/premium/3.png">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="well">     
            <legend><center>Detailed statistics</center></legend>
            <img class="img-responsive img-circle img-thumbnail"  src="/img/premium/4.png">
        </div>
    </div>
    <div class="col-md-4">
        <div class="well">
            <legend><center>Beta testing</center></legend>
            <img class="img-responsive img-circle img-thumbnail" src="/img/premium/5.png">
        </div>
    </div>
    <div class="col-md-4">
        <div class="well">
            <legend><center>Medal of appreciation</center></legend>
            <img class="img-responsive img-circle img-thumbnail" src="/img/premium/6.png">
        </div>
    </div>
</div>
@if(Auth::user()->user_type_id<2)

<hr>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-3">
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="WEDUS362UDTV2">
            <button type="submit" class="btn btn-primary btn-lg pull-right" style="height: 90px;">
                <span style="padding-right: 10px; font-size: 44px; font-weight: bold; line-height: normal">$2.99</span>
                <img style="position: relative; top: -9px;" src="/img/premium/donate.png">
            </button>
        </form>
    </div>
    <div class="col-md-3">
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="CB7VB838P7G7E">
            <button type="submit" class="btn btn-info btn-lg pull-left" style="height: 90px;">
                <span style="padding-right: 10px; font-size: 44px; font-weight: bold; line-height: normal">$24.99</span>
                <img style="position: relative; top: -9px;" src="/img/premium/donate.png">
            </button>
        </form>
    </div>
    <div class="col-md-3"></div>
</div>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-3">
        <center><h4>Monthly</h4></center>
    </div>
    <div class="col-md-3">
        <span style="position: relative; left: 25px;"><center><h4>Annually, 30% OFF</h4></center></span>
    </div>
    <div class="col-md-3"></div>
</div>
@endif
<hr>
<blockquote class="blockquote-reverse pull-right">
    <p><i>Thank you for making {{ Lop::webname }} possible!</i></p>
    <small>Artikan</small>
</blockquote>
@stop