@extends('layouts.master')
@section('content')
<div class="jumbotron">
  <h1>Contests <small>from March 1st</small></h1>
  <p>Submit your play, reserve your spot in <i>Hall of Fame</i> and win prizes!</p>
  <p><a class="btn btn-primary btn-lg" id="goto" role="button">Learn more</a></p>
  <div id="learnmore"></div>
</div>
{{--<div class='alert alert-info'>Coming soon.</div>--}}
<div class="well well-lg">
<div class="row">
    <div class="col-lg-4 col-md-4">
        <h3><span class="glyphicon glyphicon-cloud-upload"></span> Make awesome play</h3>
        <p>
            Easy to say but hard to do, kind of! Record your games using game recording software, show your opponent your skill, get lucky and upload your play!
        </p>
    </div>
    <div class="col-lg-4 col-md-4">
        <h3><span class="glyphicon glyphicon-globe"></span> Share and compete</h3>
        <p>
            So you made a play, but what is the point if nobody gets to see it ? That's what we are here! Sharing is simple as it sounds, so don't hesitate.
        </p>
    </div>
    <div class="col-lg-4 col-md-4">
        <h3><span class="glyphicon glyphicon-gbp"></span> Win prizes</h3>
        <p>
            When you make it to the top, your awesomeness, superior skill and hard work will undoubtedly be rewarded with awesome prizes!
        </p>
    </div>
</div>
</div>
<br/>
<legend>Where can I enter ?</legend>
<div class="row">
    <div class="col-md-5">
        <h2>To participate you will need...</h2>
        <ul>
            <li>account</li>
            <li>verified summoner</li>
            <li>play</li>
        </ul>
        Submitted play <b>must</b> contain <i>verified summoner</i>, otherwise, you will not be eligible to participate.
        Once you meet the requirement, you will be able to mark your play for contest through play manager, which is located <a href="/my/manager">here</a>.
        All entries will be reviewed by our staff.
    </div>
    <div class="col-md-7">
        <img class="img-responsive" style="border-radius: 5px;" src="/img/contest/verify.png">
    </div>
</div> 
<br/>
<legend>Rewards</legend>
@if(Lop::contest_rewards=='level3')
<table>
    <tr>
        <td style="width: 50%;">
            <img data-toggle="tooltip" data-placement="top" title="Roccat Kone XTD" class="img-thumbnail" src="/img/contest/rkonextd.jpg">
        </td>
        <td style="width: 50%;">
            <img data-toggle="tooltip" data-placement="top" title="Prepaid cards" class="img-thumbnail" src="/img/contest/pcards.jpg">
        </td>
    </tr>
</table>
@elseif(Lop::contest_rewards=='level1')
<div class="row">
    <div class="col-md-7">
        <img class="img-responsive" style="border-radius: 5px;" src="/img/contest/pcards.jpg">
    </div>
    <div class="col-md-5">
        <p>
            <h1>Prepaid cards</h1>
            For first contest <i>ever</i> on {{ Lop::webname }}, we will reward winners with $10, $25 and $50 prepaid cards.
            <h1>Gaming gear</h1>
            ... is something that we would definitely prefer to give out in the future since we are currently not able to.
        </p>
    </div>
</div>
@endif
<br/>
<legend>Medals</legend>
<div class="row">
    <div class="col-md-5">
        <p>
            <h1>Show off your victory!</h1>
            Although it doesn't have to mean a lot to everyone, we like to reward also with badges on profile to let everyone see who is truly <i>Victorious</i>.
			<br/><br/><br/>
			<i>Good luck, Summoner!</i>
        </p>
    </div>
    <div class="col-md-7"> 
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Contest Awards</th>
                            <th>Title</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="vertical-align: middle;">1</td>
                            <td style="vertical-align: middle;">
                                <img class="noselection" data-toggle="tooltip" data-placement="bottom" title="Contest 1<sup>st</sup> Place<br>{date}, {year}" src="/img/icon/medal/big/gold/medal-award-gold-icon.png">
                            </td>
                            <td style="vertical-align: middle;">Contest 1<sup>st</sup> Place</td>

                            <td style="vertical-align: middle;">Available, weekly</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle;">2</td>
                            <td style="vertical-align: middle;">
                                <img class="noselection" data-toggle="tooltip" data-placement="bottom" title="Contest 2<sup>nd</sup> Place<br>{date}, {year}" src="/img/icon/medal/big/silver/medal-award-silver-icon.png">
                            </td>
                            <td style="vertical-align: middle;">Contest 2<sup>nd</sup> Place</td>

                            <td style="vertical-align: middle;">Available, weekly</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle;">3</td>
                            <td style="vertical-align: middle;">
                                <img class="noselection" data-toggle="tooltip" data-placement="bottom" title="Contest 3<sup>rd</sup> Place<br>{date}, {year}" src="/img/icon/medal/big/bronze/medal-award-bronze-icon.png">
                            </td>
                            <td style="vertical-align: middle;">Contest 3<sup>rd</sup> Place</td>

                            <td style="vertical-align: middle;">Available, weekly</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
{{--
<hr>
<blockquote>
  <p>Pain is temporary, victory is forever!</p>
  <small>Aatrox, the Darkin Blade</small>
</blockquote>
--}}
</div>
@stop
@section('jsfooter')
@parent
<script type="text/javascript">
    $("#goto").click(function() {
        $('html, body').animate({
            scrollTop: $("#learnmore").offset().top
        }, 500);
    });   
	$(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip({html: true});
    });
</script>
@stop