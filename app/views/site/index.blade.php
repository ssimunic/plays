@extends('layouts.master')
@section('content')
<?php
$ads = 0;
?>
<style type="text/css">
    #play
    {
        @if($theme=='theme1')
        color: #2c3e50;
        @elseif($theme=='bootstrap')
        color: #144799;
        @endif
    }
	.flip-vertical 
	{
		-moz-transform: scaleY(-1);
		-webkit-transform: scaleY(-1);
		-o-transform: scaleY(-1);
		transform: scaleY(-1);
		-ms-filter: flipv; /*IE*/
		filter: flipv; /*IE*/
	}
</style>{{--
@if(Lop::development==true)
<div class="alert alert-info">
    This site is currently in <strong>development mode</strong>. Upon registration, you will gain early access to all of the features.
</div>
@endif--}}
<h1>Latest best plays
    <span class="pull-right" style="cursor: pointer;"><a href="/submit" class="btn btn-default">Submit play</a></span>
</h1>
<hr>
<div id="standout" class='playvideo' style="display: none;">
    <p class="playyoutubevideo"   >
        <object width="560" height="315">
            <param name="movie" value="https://www.youtube.com/v/{{ Lop::trailer_id }}?version=3&amp;hl=hr_HR"></param>
            <param name="allowFullScreen" value="true"></param>
            <param name="allowscriptaccess" value="always"></param>
            <embed id="video"  src="https://www.youtube.com/v/{{ Lop::trailer_id }}?enablejsapi=1&version=3&autohide=1&showinfo=0&rel=0&iv_load_policy=3" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true"></embed>
        </object>
    </p>
</div>
@if(!$plays->isEmpty())

<?php
// for jQuery
$t = 1;

// for progress bars
$maxprogress = $plays[0]->score;
?>
<div class="row">
<div class="@if($ads==1) col-md-9 @else col-md-12 @endif" @if($ads==1) style="border-right: 1px solid rgb(225, 225, 232);" @endif>
@foreach($plays as $play)

@if($play->type>=1 && $play->active==1)
@if($t==11)
<div style="margin-top: 13px;"></div>

<img src="/img/top.png" class="img-responsive" style="pointer-events: none; height: 49px; float: right; margin-top: -49px;">
@endif
@if($play->type==1)
<div class="panel panel-default" style="border: 1px solid #B2B2CC; border-radius: 5px 5px 5px 0px;">
@elseif($play->type==0) {{-- banned --}}
<div class="panel panel-danger" style="background-color: #FFF3F3; border: 5px dashed #ebccd1;">
@elseif($play->type==2) {{-- featured --}}
<div class="panel panel-success" style="background-color: #F5FFEB; border: 5px dashed #d6e9c6;">
@endif
    <div class="panel-body" style="padding: 10px 10px 10px 10px;">
        @if($play->category->name=="LCS")
        <div class="pull-right">
            <img src="/img/category/lcs.png" style="z-index: 100; pointer-events: none; position: absolute; right: 25px; margin-top: -15px; margin-right: -14px; width: 60px; height: 60x;">
        </div>
        @endif
        @if($play->category->name=="Contest")
        <div class="pull-right">
            <img src="/img/category/contest.png" style="z-index: 100; pointer-events: none; position: absolute; right: 25px; margin-top: -14px; margin-right: -13px; width: 60px; height: 60x;">
        </div>
        @endif
        <table class="table-condensed" style="border: 0px; border-spacing: 0; border-collapse: collapse;" cellspacing="0">
            <tr>
                <td class="playscore" style="max-width: 30px;"> 
                    <div class="playscorebar">
                        <?php /*
                          <div class="progress" style="width: 120px; margin-top: 50px; margin-bottom: -50px;">
                          @if(($play->score/$maxprogress*100)<10)
                          {{ $play->score }}
                          @endif
                          <div class="progress-bar progress-bar-success" role="progressbar" style="width: {{ $play->score/$maxprogress*100 }}%; ">
                          @if(($play->score/$maxprogress*100)>10)
                          <div class="@if($play->score<100) {{ "playscorebarnum" }} @endif">
                          {{ $play->score }}
                          </div>
                          @endif
                          </div>
                          </div>
                         */
                        ?>
                        
                        @if($play->type==2)
                        <div class="progress progress-striped active" style="width: 120px; margin-top: 50px; margin-bottom: -50px;">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                        @else
                        <div class="progress progress-bar-danger" style="width: 120px; margin-top: 50px; margin-bottom: -50px;">
                            {{-- $play->negative --}}
                            <?php
                            $total = $play->positive + $play->negative;
                            $p = $play->positive / $total * 100;
                            ?>
                            <?php $barstyle = ''; ?>
                            @foreach($votes as $vote)
                            @if($vote->play_id == $play->id && $vote->user_id == Auth::user()->id)
                            @if(Auth::user()->user_type_id >= 0) {{-- originali it was PREMIUM ONLY! --}}
                                <?php $barstyle = 'background-color: orange;'; ?> {{-- maybe premium feature ? --}}
                            @endif
                            @endif
                            @endforeach
                            <div class="vote-score progress-bar progress-bar-success" role="progressbar" style="width: {{ $p }}%; {{ $barstyle }} ">
                                {{-- $play->positive --}}     
                                <span style="-webkit-transform: rotate(-180deg); -moz-transform: rotate(-180deg); -o-transform: rotate(-180deg);">{{ $play->score }}</span>
                            </div>
                            <?php $barstyle = ''; ?>
                        </div>
                        @endif
                    </div>
                </td>
                <td style="width:280px;">
                    <img id="ytvideo{{ $t }}" data-toggle="tooltip" data-placement="bottom" title="Click to quick view" width="180px" src="{{ YouTube::getThumbnail($play->link) }}" class="img-thumbnail" style="cursor: pointer; min-width: 100px; ">
                </td>
                <td style="@if($ads==1) width: 74%; @else width: 80%; @endif">
                    <table style="border: 0px; border-spacing: 0; border-collapse: collapse; width: 100%;" cellspacing="0">
                        <tr class="playinfo">
                            <td style="width: 75%;">
								<div style="border: 1px solid rgb(221, 221, 221); border-right: 0px; border-radius: 0.5em 0em 0em 0.5em; padding: 0px 10px 0px 10px; height: 130px;">
                                <p>
                                <h4>
                                    @if($play->champion!=null)<img class="profileavatar playchamp_home" src="/img/champions/squares/{{ Lop::getChampImg($play->champion) }}Square.png">@endif
                                    <a id="play" href="/{{ $play->id }}"><b>{{ $play->name }}</b></a> @if(Auth::check() && Auth::user()->id==$play->user->id) 
                                    <small>
                                        <a href="/my/manager/{{ $play->id }}" style="color: grey;" >
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </a>
                                    </small> @endif<small>({{ $play->comments->count() }} comments)</small>
                                    <br>
                                    <small>
                                        <span data-toggle="tooltip" data-placement="right" title="{{ Lop::when($play->date) }}" >{{ Lop::time_elapsed_string(strtotime($play->date)) }}</span>, 
                                        submitted by <a href="profile/{{ $play->user->id }}">{{ $play->user->username }}</a>
                                    </small>
                                </h4>
                                </p>
                                <p class="playdescription">
                                    {{ $play->description }} <a href="/{{ $play->id }}#comments"><b>...</b></a>
                                </p>
								</div>
                            </td>
							<td style="width: 25%;">
								<div style="padding: 5px 5px 5px 5px;position: relative; left: -3px;border: 1px solid rgb(221, 221, 221); border-left: 0px; border-radius: 0em 0.5em 0.5em 0em; padding: 0px 10px 0px 10px; height: 130px;">
									@if($ads==1)
									<div style="position: relative; top:10px; border: 1px solid rgb(221, 221, 221); border-right: 0px;border-top: 0px;border-bottom: 0px; border-radius: 0em 0.5em 0.5em 0em; padding: 0px 10px 0px 10px; height: 110px;">
									
									</div>
									@endif
								</div>
							</td>
                        </tr>
                        {{--
                        <tr>
                            <td>Category: {{ $play->category->name }}</td>
            </tr>
            --}}
        </table>
        </td>
        </tr>
        <tr id="votevideotr{{ $t }}" style="display: none;">
            <td>
                {{-- none --}}
            </td>
            <td>
                <table>
                    <tr>
                        <td>
                     <span class="item" onclick="javascript:document.getElementById('logintovote{{ $t }}').style.display = 'block'; @if(!Auth::check()) document.getElementById('alertlog{{ $t }}').style.display = 'table-row'; $('#alertlog{{$t}}').fadeIn().delay(3000).fadeOut(); @endif" data-postid="{{ $play->id }}" data-score="{{ $play->score }}">
                            <?php
                            $upstyle = '';
                            $downstyle = '';
                            ?>
                            @foreach($votes as $vote)
                            @if($vote->play_id == $play->id && $vote->user_id == Auth::user()->id)
                            @if($vote->type=='upvote')
                            <?php
                            $upstyle = 'background-color: orange';
                            $downstyle = 'background-color: grey';
                            ?>
                            @elseif($vote->type=='downvote')
                            <?php
                            $upstyle = 'background-color: grey';
                            $downstyle = 'background-color: orange';
                            ?>
                            @endif
                            @endif
                            @endforeach
                         <div id="vote1area{{ $t }}" class="vote hpvoteup" data-action="up" style="display:none; @if($theme=='theme1') background-color: #2c3e50; @endif {{ $upstyle }} ">
                            <span class="label"><span class="glyphicon glyphicon-chevron-up" style="font-size: 10em;  padding: 17px 5px;"></span></span>
                        </div>
                        <div id="vote2area{{ $t }}" class="vote hpvotedown voterot" data-action="down" style="display:none; {{ $downstyle }}">
                            <span class="label"><span class="glyphicon glyphicon-chevron-up" style="font-size: 10em;  padding: 15px 5px;"></span></span>
                        </div>
                     </span>
                     </div>
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <div id="videoarea{{ $t }}" style="display:none;">
                    <hr>
                    <p class="youtube_video_submit">
                        <object width="560" height="315">
                            <param name="movie" value="//www.youtube.com/v/{{ YouTube::getID($play->link) }}?version=3&amp;hl=hr_HR"></param>
                            <param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
                            <embed {{--class="youtube_video_submit_embed"--}} src="//www.youtube.com/v/{{ YouTube::getID($play->link) }}?version=3&autohide=1&showinfo=0&rel=0&iv_load_policy=3" type="application/x-shockwave-flash" width="560" height="315" allowscriptaccess="always" allowfullscreen="true"></embed>
                        </object>
                    </p>
                </div>
            </td>
        </tr>
        <tr id="alertlog{{ $t }}" style="display: none;">
            <td>
                {{-- none --}}
            </td>
            <td>
                {{-- none --}}
            </td>
            <td>
                <div id="logintovote{{ $t }}" style="display: none;"><div class="alert alert-info" style="max-width: 560px;">Please login to upvote/downvote plays.</div></div>
            </td>
        </tr>
        </table>
    </div>

</div>
@if($play->type!=2)
<div id="bot{{ $t }}" style="height: 49px; margin-top: -22px;  margin-left: @if($play->type==2) -0px; @else -0px; @endif;">
    {{--
    <div style="position: absolute; z-index: 10; margin-left: 50px; margin-top: 4px; height: 32px; ">
        <span class="textcenter">
            <h4 style='overflow: hidden; width: 450px; white-space: nowrap; text-overflow: ellipsis;'><b>{{ $play->name }} </b></h4>
        </span>
    </div>
    --}}
    {{-- here --}}
    <img id="boti{{$t}}" src="/img/top5.png" class="img-responsive bot" style="margin-left: -0px;cursor: pointer; position: absolute; height: 49px; opacity: 1; @if($ads==1) width: 425px; @else width: 571px; @endif">
	<img src="/img/arrow.png" class="img-responsive arrow" style="cursor: pointer; position: absolute; height: 49px; opacity: 0.0; @if($ads==1) width: 425px; @else width: 571px; @endif">
	<img src="/img/arrow.png" class="img-responsive arrow flip-vertical n{{ $t }}" style="display: none;cursor: pointer; position: absolute; height: 49px; opacity: 0.0; @if($ads==1) width: 425px; @else width: 571px; @endif">
</div>
{{-- here --}}<div style="margin-bottom: 15px;"></div>
@endif
@endif
<?php $t++; ?>

@endforeach
</div>

@else
<div class="alert alert-info">There were no new plays submitten in last hours.</div>

@endif
@if($ads==1)
<div class="col-md-3">

</div>
@endif

<div class="row">
<hr>
<center><?php echo $plays->links(); ?></center>
</div>


</div>
@stop
@section('jsfooter')
@parent
<script type="text/javascript">
$(document).ready(function() {
            $.ajaxSetup({
                url: 'ajax/vote',
                type: 'POST',
                cache: 'false',
            });

            // any voting button (up/down) clicked event
            $('.vote').click(function() {
                var self = $(this); // cache $this
                var action = self.data('action'); // grab action data up/down 
                var parent = self.parent(); // grab grand parent .item
                var postid = parent.data('postid'); // grab post id from data-postid
                var score = parent.data('score'); // grab score form data-score
                // only works where is no disabled class
                if (!parent.hasClass('.disabled')) {
                    // vote up action
                    if (action == 'up') {
                        $.ajax({data: {'postid': postid, 'action': 'up'},
                            success: function(results) {
                                html = $.trim(results);
                                if (html == 'up')
                                {
                                    self.css({'background-color':'orange'});
                                    self.parent().find('.hpvotedown').css({'background-color':'grey'});
                                    self.parent().parent().parent().parent().parent().parent().parent().parent().find('.vote-score').html(++score).css({'background-color':'orange'});
                                }
                                if (html == 'failure') { 
                                    //alert('vup-failure');
                                }
                            }
                        });
                    }
                    // voting down action
                    else if (action == 'down') {
                        $.ajax({data: {'postid': postid, 'action': 'down'},
                            success: function(results) {
                                html = $.trim(results);
                                if (html == 'down')
                                {
                                    self.css({'background-color':'orange'});
                                    self.parent().find('.hpvoteup').css({'background-color':'grey'});
                                    self.parent().parent().parent().parent().parent().parent().parent().parent().find('.vote-score').html(--score).css({'background-color':'orange'});
                                }
                                if (html == 'failure') {
                                   //alert('vdown-failure');
                                }
                            }
                        });
                    }
                    // add disabled class with .item
                    parent.addClass('.disabled');
                }
                ;
            });
        });
  
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip({html: true});
       
        $(".arrow").on({
            mouseenter: function () {
                $(this).stop();
                $(this).animate({ opacity: 1 });
                //$(this).animate({ height: 49 }, 'fast');
            },
            mouseleave: function () {
                $(this).stop();
                $(this).animate({ opacity: 0.0 });
                //$(this).animate({ height: 40 }, 'fast');
            }
        });
        
        $("#ytvideo1, #bot1").click(function() {
            document.getElementById('votevideotr1').style.display = 'table-row';
			//$('.n1').slideToggle('slow');
            $('#videoarea1').slideToggle('slow');
            $('#vote1area1').slideToggle('slow');
            $('#vote2area1').slideToggle('slow');
        });
        $("#ytvideo2, #bot2").click(function() {
            document.getElementById('votevideotr2').style.display = 'table-row';
			//$('.n2').slideToggle('slow');
            $('#videoarea2').slideToggle('slow');
            $('#vote1area2').slideToggle('slow');
            $('#vote2area2').slideToggle('slow');
            
        });
        $("#ytvideo3, #bot3").click(function() {
            document.getElementById('votevideotr3').style.display = 'table-row';
            //$('.n3').slideToggle('slow');
			$('#videoarea3').slideToggle('slow');
            $('#vote1area3').slideToggle('slow');
            $('#vote2area3').slideToggle('slow');
        });
        $("#ytvideo4, #bot4").click(function() {
            document.getElementById('votevideotr4').style.display = 'table-row';
            //$('.n4').slideToggle('slow');
			$('#videoarea4').slideToggle('slow');
            $('#vote1area4').slideToggle('slow');
            $('#vote2area4').slideToggle('slow');
        });
        $("#ytvideo5, #bot5").click(function() {
            document.getElementById('votevideotr5').style.display = 'table-row';
            //$('.n5').slideToggle('slow');
			$('#videoarea5').slideToggle('slow');
            $('#vote1area5').slideToggle('slow');
            $('#vote2area5').slideToggle('slow');
        });
        $("#ytvideo6, #bot6").click(function() {
            document.getElementById('votevideotr6').style.display = 'table-row';
            //$('.n6').slideToggle('slow');
			$('#videoarea6').slideToggle('slow');
            $('#vote1area6').slideToggle('slow');
            $('#vote2area6').slideToggle('slow');
        });
        $("#ytvideo7, #bot7").click(function() {
            document.getElementById('votevideotr7').style.display = 'table-row';
            //$('.n7').slideToggle('slow');
			$('#videoarea7').slideToggle('slow');
            $('#vote1area7').slideToggle('slow');
            $('#vote2area7').slideToggle('slow');
        });
        $("#ytvideo8, #bot8").click(function() {
            document.getElementById('votevideotr8').style.display = 'table-row';
            //$('.n8').slideToggle('slow');
			$('#videoarea8').slideToggle('slow');
            $('#vote1area8').slideToggle('slow');
            $('#vote2area8').slideToggle('slow');
        });
        $("#ytvideo9, #bot9").click(function() {
            document.getElementById('votevideotr9').style.display = 'table-row';
            //$('.n9').slideToggle('slow');
			$('#videoarea9').slideToggle('slow');
            $('#vote1area9').slideToggle('slow');
            $('#vote2area9').slideToggle('slow');
        });
        $("#ytvideo10, #bot10").click(function() {
            document.getElementById('votevideotr10').style.display = 'table-row';
            //$('.n10').slideToggle('slow');
			$('#videoarea10').slideToggle('slow');
            $('#vote1area10').slideToggle('slow');
            $('#vote2area10').slideToggle('slow');
        });
    });
</script>


{{ HTML::script('/dist/jquery.fitvids.js') }}

<script type="text/javascript">
    $(".playvideo").fitVids();
    $("#trailerc").click(function(){
        $("#standout").toggle('slow');
    });
</script>
@stop