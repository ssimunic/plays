@extends('layouts.admin')
@section('content')
<h1>Dashboard</h1>
<hr>
<div class="row">
    <div class="col-lg-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <span class="glyphicon glyphicon-facetime-video" style="font-size: 80px; margin-top: 10px;"></span>
                    </div>
                    <div class="col-xs-6 text-right">
                        <p class="announcement-heading">{{ $newplays }}</p>
                        <p class="announcement-text">New Plays</p>
                    </div>
                </div>
            </div>
            <a href="/admin/plays">
                <div class="panel-footer announcement-bottom">
                    <div class="row">
                        <div class="col-xs-6">
                            View All Plays
                        </div>
                        <div class="col-xs-6 text-right">
                            <span class="glyphicon glyphicon-arrow-right"></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <span class="glyphicon glyphicon-eye-open" style="font-size: 80px; margin-top: 10px;"></span>
                    </div>
                    <div class="col-xs-6 text-right">
                        <p class="announcement-heading">{{ $waitingvalidation }}</p>
                        <p class="announcement-text">Awaiting Validation</p>
                    </div>
                </div>
            </div>
            <a href="/admin/plays?type=validation">
                <div class="panel-footer announcement-bottom">
                    <div class="row">
                        <div class="col-xs-6">
                            Complete Tasks
                        </div>
                        <div class="col-xs-6 text-right">
                            <span class="glyphicon glyphicon-arrow-right"></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <span class="glyphicon glyphicon-user" style="font-size: 80px; margin-top: 10px;"></span>
                    </div>
                    <div class="col-xs-6 text-right">
                        <p class="announcement-heading">{{ $newusers }}</p>
                        <p class="announcement-text">New Users</p>
                    </div>
                </div>
            </div>
            <a href="/admin/users">
                <div class="panel-footer announcement-bottom">
                    <div class="row">
                        <div class="col-xs-6">
                            View All Users
                        </div>
                        <div class="col-xs-6 text-right">
                            <span class="glyphicon glyphicon-arrow-right"></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <span class="glyphicon glyphicon-usd" style="font-size: 80px; margin-top: 10px;"></span>
                    </div>
                    <div class="col-xs-6 text-right">
                        <p class="announcement-heading">{{ $newpayments }}</p>
                        <p class="announcement-text">New Premiums</p>
                    </div>
                </div>
            </div>
            <a href="/admin/payments">
                <div class="panel-footer announcement-bottom">
                    <div class="row">
                        <div class="col-xs-6">
                            View Payments
                        </div>
                        <div class="col-xs-6 text-right">
                            <span class="glyphicon glyphicon-arrow-right"></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<hr>
<div class="panel panel-primary">
  <div class="panel-heading">{{ Lop::webname }} Statistics</div>
  <div class="panel-body">
        <div id="container3" style="min-width: 310px; margin: 0 auto"></div>
  </div>
</div>
@stop

@section('jsfooter')
@parent

<!-- highcharts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<!-- statistics -->

<?php
$data = array_fill(1, 30, 0);
foreach($playsall as $play)
{
    $now = date("m y", time());
    $playdate = date("m y", strtotime($play->date));
    if($now == $playdate)
    {
        $day = date('j', strtotime($play->date));
        $data[$day] = $data[$day]+1;
    }
}

$data1 = array_fill(1, 30, 0);
foreach($users as $user)
{
    $now = date("m y", time());
    $playdate = date("m y", strtotime($user->registration_date));
    if($now == $playdate)
    {
        $day = date('j', strtotime($user->registration_date));
        $data1[$day] = $data1[$day]+1;
    }
}

$data2 = array_fill(1, 30, 0);
foreach($comments as $comment)
{
    $now = date("m y", time());
    $playdate = date("m y", strtotime($comment->date));
    if($now == $playdate)
    {
        $day = date('j', strtotime($comment->date));
        $data2[$day] = $data2[$day]+1;
    }
}

$data3 = array_fill(1, 30, 0);
foreach($votes as $vote)
{
    $now = date("m y", time());
    $playdate = date("m y", strtotime($vote->date));
    if($now == $playdate)
    {
        $day = date('j', strtotime($vote->date));
        $data3[$day] = $data3[$day]+1;
    }
}
?>
@if(Auth::user()->user_type_id>1)
<script type='text/javascript'>
    $(function () {
        $('#container3').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: 'Total daily',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: [
                    <?php
                    for($days=1; $days<=30; $days++)
                    {
                        echo "'".date('M', time())." ".$days."',";
                    }
                    ?>
                ],
                max: 29,
            },
            yAxis: {
                title: {
                    text: 'Total Daily (n)'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                name: 'Total Plays',
                data: [
                    @for($i=1;$i<=30;$i++)
                    {{ $data[$i] }},
                    @endfor
                ]
            }, 
            {
                name: 'Total Users',
                data: [
                    @for($i=1;$i<=30;$i++)
                    {{ $data1[$i] }},
                    @endfor
                ]
            }, 
            {
                name: 'Total Comments',
                data: [
                    @for($i=1;$i<=30;$i++)
                    {{ $data2[$i] }},
                    @endfor
                ]
            }, 
            {
                name: 'Total Votes',
                data: [
                    @for($i=1;$i<=30;$i++)
                    {{ $data3[$i] }},
                    @endfor
                ]
            }]
        });
    });
   
</script>
@endif
@stop