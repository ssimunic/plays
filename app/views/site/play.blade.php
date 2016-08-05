@extends('layouts.master')
@section('content')
<?php
$data = json_decode($play->data);
?>
<div id="spinner" style="position: fixed; top: 50%; left: 50%; z-index: 9999999;"></div>
<div id="the_lights"></div>
<h1>@if($play->champion!=null)<img class="profileavatar playchamp" src="/img/champions/squares/{{ Lop::getChampImg($play->champion) }}Square.png">@endif {{ $play->name }} @if(Auth::check() && Auth::user()->id==$play->user->id) <small><a href="/my/manager/{{ $play->id }}" style="color: grey;" ><span class="glyphicon glyphicon-pencil"></span></a></small> @endif</h1>
<hr>
@if(Session::has('message_success'))
<div class="alert alert-success">
    {{ Session::get('message_success'); Session::forget('message_success') }}
</div>
@endif
@if($play->type == 0)
<div class='alert alert-danger'>
    <span class="glyphicon glyphicon-ban-circle"></span> This play has been deleted by the user.
</div>
@elseif($play->active==1)
<div id="standout" class='playvideo'>
    <p class="playyoutubevideo" @if($play->type==2) {{--style='border-color: #d6e9c6'--}} @endif>
        <object width="560" height="315">
            <param name="movie" value="https://www.youtube.com/v/{{ YouTube::getID($play->link) }}?version=3&amp;hl=hr_HR"></param>
            <param name="allowFullScreen" value="true"></param>
            <param name="allowscriptaccess" value="always"></param>
            <embed id="video" {{--class="playyoutube_video_submit_embed" style="border-radius: 3px;"--}} src="https://www.youtube.com/v/{{ YouTube::getID($play->link) }}?enablejsapi=1&version=3&autohide=1&showinfo=0&rel=0&iv_load_policy=3" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true"></embed>
        </object>
    </p>
</div>
<?php
$upstyle = '';
$downstyle = '';
?>
@foreach($votes as $vote)
@if($vote->play_id == $play->id && $vote->user_id == Auth::user()->id)
@if($vote->type=='upvote')
<?php
$upstyle = 'background-color: orange';
$downstyle = 'background-color: #999';
?>
@elseif($vote->type=='downvote')
<?php
$upstyle = 'background-color: #999';
$downstyle = 'background-color: orange';
?>
@endif
@endif
@endforeach
<table style="border-collapse:collapse; width: 100%;">
<tr>
    <td align="left">
    <span style="position: relative; top: -3px;" class="item" onclick="@if(!Auth::check()) javascript:document.getElementById('logintovote').style.display = 'block'; $('#logintovote').fadeIn().delay(3000).fadeOut(); @endif" data-postid="{{ $play->id }}" data-score="{{ $play->score }}">
        <span class="vote label label-primary voteup" data-action="up" style='cursor: pointer; {{ $upstyle }}'><span class="glyphicon glyphicon-chevron-up"></span></span>
        <span class="vote-score label label-default">{{ $play->score }}</span>
        <span class="vote label label-danger votedown" data-action="down" style='cursor: pointer; {{ $downstyle }}'><span class="glyphicon glyphicon-chevron-down"></span></span>
    </span>

    <span style="font-size: 130%; font-family: 'Open Sans'; font-style: normal; font-weight: 300; line-height: 10px;">
        Submitted by <a href="/profile/{{ $play->user->id }}">{{ $play->user->username }}</a>, 
        <span style="color: grey" data-toggle="tooltip" data-placement="right" title="{{ Lop::when($play->date) }}" >
            {{ Lop::time_elapsed_string(strtotime($play->date)) }}
        </span>
    </span>
    </td>
    <td style="text-align: right;">
        @if(Session::has('report'.$play->id)==false)
        <a href="/playreport/{{ $play->id }}"><span class="label label-danger" data-toggle="tooltip" data-placement="bottom" title="Report for non-related content" style="position: relative; top: -3px; cursor: pointer;">!</span></a>
        @endif
        <span id="lightson" class="label label-warning" data-toggle="tooltip" data-placement="left" title="Turn on the lights" style="position: relative; top: -3px; cursor: pointer; display: none;">
            ON
        </span>
        <span id="lightsoff" class="label label-default" data-toggle="tooltip" data-placement="left" title="Turn off the lights" style="position: relative; top: -3px; cursor: pointer;">
            OFF
        </span>
    </td>
</tr>
</table>
<div id="logintovote" style="display: none;"><p><div class="alert alert-info">Please login to upvote/downvote plays.</div></p></div>
<p style="margin-top: 10px;">
    {{ $play->description }}
</p>

@elseif($play->active == 0)
@if($data->passedvalidation==false)
<div class='alert alert-danger'>
    <span class="glyphicon glyphicon-eye-open"></span> This play hasn't passed content validation. For any further questions, please contact us.
</div>
@elseif($data->passedvalidation=='pending')
<div class='alert alert-warning'>
    <span class="glyphicon glyphicon-eye-open"></span> This play is going through content validation and soon it will be properly displayed.
</div>
@endif
@endif
<hr>
@if($data->comments==true)
<div id="comments" class="panel panel-default">
    <div class="panel-heading">Post Comment</div>
    <div class="panel-body">
{{ Form::open(array(
            'url' => 'comment',
            'method' => 'POST',
            'role' => 'form',
            'class' => 'form-horizontal'
    )) }}
        <input type="hidden" name="playid" value="{{ $play->id }}">
        <div class="form-group">
          <label for="comment" class="col-sm-2 control-label">Comment</label>
          <div class="col-sm-9">
              <textarea class="form-control" id="comment" name="comment" rows="5" @if(Auth::user()==false) placeholder="Please login to post comments..." disabled @else placeholder="Enter any text..." @endif></textarea>
          </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default" @if(Auth::user()==false) disabled @endif>Submit</button>
            </div>
        </div>
{{ Form::close() }}
    </div>
</div>
@if(Session::has('message'))
<div class="alert alert-success">
    {{ Session::get('message'); Session::forget('message') }}
</div>
@endif
<div id="checkcomments"></div>
{{-- DIV COMMENTSAREA STARTS --}}
<div id="commentsarea">
{{-- LOADED FROM OTHER.COMMENTSAREA, TO BE REVIEWED ? --}}

@include('other.commentsarea')

</div>
{{-- DIV COMMENTSAREA ENDS --}}
@else
<div class='alert alert-info'>
    <span class="glyphicon glyphicon-info-sign"></span> Comments have been disabled on this play.
</div>
@endif
@stop
@section('jsfooter')
@parent
{{ HTML::script('/dist/jquery.fitvids.js') }}
<script type="text/javascript">
$(document).ready(function() {
            $(function() {
                $('.likec').click(function() {
                    var self = $(this);
                    var id = self.data('id');
                    var score = self.data('score');
                    $.ajax({
                        type: 'POST',
                        url: '/ajax/comment/like',
                        data: {'id': id},
                        success: function(results) {
                            html = $.trim(results);
                            
                            if(html=='success')
                            {
                                self.parent().find('.likes').html(++score);
                                self.parent().find('.likes').css({'display':'block'});
                            }
                            
                            if(html=='failure')
                            {
                                //alert('fail');
                            }
                        },
                    });
                });
            });
            $.ajaxSetup({
                url: '/ajax/vote',
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
                                    self.parent().find('.votedown').css({'background-color':'#999'});
                                    self.parent().parent().find('.vote-score').html(++score);

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
                                    self.parent().find('.voteup').css({'background-color':'#999'});
                                    self.parent().parent().find('.vote-score').html(--score);

                                }
                                if (html == 'failure') {
                                    //alert('vdown-failure');
                                }
                            }
                        });
                    }
                    // add disabled class with .item
                    parent.addClass('.disabled');
                };
            });
        });
  
</script>
<script>
var vidinterval = setInterval(PlayerState, 1000);

function PlayerState() {
    var sStatus = document.getElementById("video").getPlayerState();
    if (sStatus == -1)
    {
    }
    else if (sStatus == 0)
    {
        document.getElementById("the_lights").style.display = "block";
        $("#the_lights").fadeTo("slow", 0);
        
        $("#lightson").trigger("click");
    }
    else if (sStatus == 1)
    {
        document.getElementById("the_lights").style.display = "block";
        $("#the_lights").fadeTo("slow", 0.8);
        $("#lightsoff").hide();
        $("#lightson").show();
        //$("#lightsoff").trigger("click");

    }
    else if (sStatus == 2)
    {
        document.getElementById("the_lights").style.display = "block";
        $("#the_lights").fadeTo("slow", 0);
        $("#lightsoff").show();
        $("#lightson").hide();
        //$("#lightson").trigger("click");
    }
    else if (sStatus == 3)
    {
        //buffering
    }
    else if (sStatus == 5)
    {
        //cued
    }
}

$(document).ready(function(elem) {
      // turn on the lights manually
    var refreshIntervalId;
    $("#lightson").click(function() {
        clearInterval(vidinterval);
        $("#the_lights").fadeTo("slow", 0);
        $("#lightsoff").show();
        $("#lightson").hide();
    });
    
    $("#lightsoff").click(function() {
        $("#the_lights").fadeTo("slow", 0.8);
        $("#lightsoff").hide();
        $("#lightson").show();
    });
    // reply
    c = 0;
    (function( $ ){
        $.fn.newForm = function(parent_id) {
           var html = '{{ Form::open(array(
            'url' => 'comment',
            'method' => 'POST',
            'role' => 'form',
            'class' => 'form-horizontal')) }}\n\
            <input type="hidden" name="parent_id" value="'+parent_id+'">\n\
            <input type="hidden" name="playid" value="{{ $play->id }}">\n\
            <div class="form-group"><div class="col-sm-10">\n\
            <textarea class="form-control" id="reply" name="reply" rows="5" placeholder="Reply on above comment..."></textarea>\n\
            </div></div>\n\
            <div class="form-group"><div class="col-sm-10"><button type="submit" class="btn btn-default">Submit</button></div></div>{{ Form::close() }}';
            $(this).parent().parent().find('#commentnewsubmit').html(html);
            if(c==0)
            {
                c=1;
            }
            else
            {
                $(this).parent().parent().find('#commentnewsubmit').html('');
                c=0;
            }
        }; 
     })( jQuery );
       
    // edit
    d = 0;
    (function( $ ){
        $.fn.editComment = function(commentid, textedit) {
           var html = '{{ Form::open(array(
            'url' => 'comment/edit',
            'method' => 'POST',
            'role' => 'form',
            'class' => 'form-horizontal')) }}\n\
            <input type="hidden" name="commentid" value="'+commentid+'">\n\
            <input type="hidden" name="playid" value="{{ $play->id }}">\n\
            <div class="form-group"><div class="col-sm-10">\n\
            <textarea class="form-control" id="edit" name="edit" rows="5">'+textedit+'</textarea>\n\
            </div></div>\n\
            <div class="form-group"><div class="col-sm-10"><button type="submit" class="btn btn-default">Save</button></div></div>{{ Form::close() }}';
            //alert(this.parent().parent().find('#commtext').html());
            $(this).parent().parent().find('#commtext').html(html);
            if(d==0)
            {
                d=1;
            }
            else
            {
                $(this).parent().parent().find('#commtext').html(textedit);
                d=0;
            }
        }; 
     })( jQuery );
     
    // tooltip
    $('[data-toggle="tooltip"]').tooltip({html: true});
    //lights on
    $("#the_lights").fadeTo(1, 0);
    //fitvit
    $(".playvideo").fitVids();
    //lights
    $("#standout").click(function() {
        document.getElementById("the_lights").style.display = "block";
        //$("#the_lights").fadeTo("slow", 0.8);
    });
    $("#the_lights").click(function() {
        document.getElementById("the_lights").style.display = "block";
        //$("#the_lights").fadeTo("slow", 0);
    });
  
    comms = {{ $play->comments->count() }};
    x = 0;
    // check for new comments ajax
    $(function() {  
    var prevAjaxReturned = true;
    var xhr = null;
    var text = null;
    var html = null;
    setInterval(function() {
            if( prevAjaxReturned ) {
                prevAjaxReturned = false;
            } else if( xhr ) {
                xhr.abort( );
            }
                    
            xhr = $.ajax({
                type: "POST",
                data: {'playid': {{ $play->id }}, 'commentsnum': comms},
                url: "/ajax/comments/check",
                success: function(response) {
                    x = response
                    if(response==1)
                    {
                        text = 'There is '+response+' new comment. Would you like to load it ?';
                    }
                    else
                    {
                        text = 'There are '+response+' new comments. Would you like to load them ?';
                    }
                    
                    html = '<hr><p id="getcomments"><center><a href="javascript:;">'+text+'</a></center></p><hr>';
                    $("#checkcomments").html(html);
                    prevAjaxReturned = true;
               }

            });

        }, 5000);
    });
    
    // load new comments ajax
    $(function() {
        $('#checkcomments').click(function() {
            comms=comms+parseInt(x);
          $.ajax({
            url: '/ajax/comments',
            type: 'POST',
            data: {'playid': {{$play->id}}},
            success: function(results) {
                $('#commentsarea').html(results);
                document.getElementById('checkcomments').innerHTML = '';            
                // tooltip
                $('[data-toggle="tooltip"]').tooltip({html: true});
            },
            error: function(){ 
                //alert('error');
            },
          });
        });
    });
    
   

});
</script>
{{ HTML::script('/dist/spin.js') }}   
<script type="text/javascript">
    //spinner
    var opts = {
        lines: 9, // The number of lines to draw
        length: 0, // The length of each line
        width: 5, // The line thickness
        radius: 25, // The radius of the inner circle
        corners: 1, // Corner roundness (0..1)
        rotate: 0, // The rotation offset
        direction: 1, // 1: clockwise, -1: counterclockwise
        color: '#000', // #rgb or #rrggbb or array of colors
        speed: 1, // Rounds per second
        trail: 100, // Afterglow percentage
        shadow: false, // Whether to render a shadow
        hwaccel: false, // Whether to use hardware acceleration
        className: 'spinner', // The CSS class to assign to the spinner
        zIndex: 2e9, // The z-index (defaults to 2000000000)
    };
    var target = document.getElementById('spinner');
    var spinner = new Spinner(opts).spin(target);
          
    $(window).load(function() {
        $('#spinner').fadeOut('fast');
    });
</script>
@stop