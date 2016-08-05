@extends('layouts.master')
@section('content')
<h1>Statistics</h1>
<hr>
@if(!$plays->isEmpty())
<div class="panel panel-default">
    <div class="panel-body">
        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </div>
</div>
    @if(Auth::user()->user_type_id==1)
    <p>
    <div class='alert alert-info'><b>Note:</b> More detailed statistics and data are available only for premium users.</div>
    </p>
    @else
<div class="panel panel-default">
    <div class="panel-body">    
        <div id="container2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </div>
</div>    
<div class="panel panel-default">
    <div class="panel-body">        
        <div id="container3" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </div>
</div>    
    @endif
@else
<div class="alert alert-info"><b>You don't have any plays on our website!</b> If you would like, you can submit one <a href='/submit'>here</a> and follow statistics later.</div>
@endif
@stop

@section('jsfooter')
@parent

<!-- highcharts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<!-- statistics -->
@if(!$plays->isEmpty() && !$playsall->isEmpty() && !$playsallmy->isEmpty())
<script type='text/javascript'>
    $(function () {
        $('#container').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Your latest 5 plays statistics'
            },
            subtitle: {
                text: 'Displaying basic data'
            },
            xAxis: {
                categories: [
                    @foreach($plays as $play)
                        '{{ substr($play->name, 0, 30) }}...',
                    @endforeach
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Quantity (n)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Score',
                data: [
                    @foreach($plays as $play)
                    {{ $play->score }},
                    @endforeach
                ],
                color : '#2f7ed8'

            }, {
                name: 'Positive',
                data: [
                    @foreach($plays as $play)
                    {{ $play->positive }},
                    @endforeach
                ],
                color: '#8bbc21'

            }, {
                name: 'Negative',
                data: [
                    @foreach($plays as $play)
                    {{ $play->negative }},
                    @endforeach 
                ],
                color: '#910000'

            }, {
                name: 'Comments',
                data: [
                    @foreach($plays as $play)
                    {{ $play->comments->count() }},
                    @endforeach 
                ],
                color : '#0d233a'

            }]
        });
    });
</script>
<?php
$data = array_fill(1, 30, 0);
foreach($playsall as $play)
{
    $now = date("m y", time());
    $playdate = date("m y", strtotime($play->date));
    if($now == $playdate)
    {
        $day = date('j', strtotime($play->date));
        $data[$day] = $data[$day]+$play->score;
    }
}
?>
@if(Auth::user()->user_type_id>1)
<script type='text/javascript'>
    $(function () {
        $('#container3').highcharts({
            title: {
                text: 'Daily plays popularity',
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
                    text: 'Total Score (n)'
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
                name: 'Total Score',
                data: [
                    @for($i=1;$i<=30;$i++)
                    {{ $data[$i] }},
                    @endfor
                ]
            }]
        });
    });
    
    <?php
    $totalscore = 0;
    $totalpos = 0;
    $totalneg = 0;
    $totalcomments = 0;
    
    foreach($playsallmy as $play)
    {
        $totalscore = $totalscore+$play->score;
        $totalpos = $totalpos+$play->positive;
        $totalneg = $totalneg+$play->negative;
        $totalcomments = $totalcomments+$play->comments->count();
    }
    
    ?>
    
    $(function () {
    $('#container2').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Your total plays statistics'
        },
        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b><br>Total: <b>{point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            data: [
                {
                    name: 'Positive',
                    y: {{ $totalpos }},
                    sliced: true,
                    selected: true,
                    color: '#8bbc21'
                },
                {
                    name: 'Negative',
                    y: {{ $totalneg }},
                    color: '#910000'
                },
            ],
            center: ['20%'],
            name: 'Percentage'
        },
        {
            type: 'pie',
            name: 'Browser share',
            data: [
                {
                    name: 'Score',
                    y: {{ $totalscore }},
                    sliced: true,
                    selected: true,
                    color : '#2f7ed8'
                },
                {
                    name: 'Comments',
                    y: {{ $totalcomments }},
                    color : '#0d233a'
                },
            ],
            center: ['80%'],
            name: 'Percentage'
        }
    ]
    });
});
</script>
@endif
@endif
@stop