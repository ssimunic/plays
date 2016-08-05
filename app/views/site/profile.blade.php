@extends('layouts.master')
@section('content')
@include('other.medals')
@include('other.avatars')
</small>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body" >
                <div style="display: table-cell; vertical-align: middle;">
               
                    <a href="javascript:;" @if(Auth::user()->id==$user->id) data-toggle="modal" data-target="#avatars" @endif> 
                     
                    <div @if(Auth::user()->id==$user->id) data-toggle="tooltip" data-placement="top" title="Click here to change avatar" @endif style="background: url('/img/{{ $user->avatar }}.jpg'); background-size: 100%;" class="profileavatar"></div>
                  
                    </a>
                  
                </div>
                <div style="display: table-cell; vertical-align: top; padding-left: 5px;">
                    <span style="font-size: 150%;">
                        @if($user->display_name=='Undefined')
                        {{ $user->username }} 
                        @else
                        {{ $user->display_name }} <span style="color: grey"><small>({{ $user->username }})</small></span>
                        @endif
                        @if($user->user_type_id==0)
                        {{ '(<span style="color: darkred;">Banned</span>)' }}
                        @endif
                        <a href="/messages/new/{{ $user->id }}"><span class="glyphicon glyphicon-envelope" style="font-size: 70%; color: grey;"></span></a>
                    </span>
                    <br/>
                        <p>
                            <span data-toggle="tooltip" data-placement="left" title="Member since">
                                {{ Lop::when($user->registration_date) }}</span>
                        </p>
                        <p>
                        <?php
                        $totalscore = 0;
                        foreach ($user->play as $play) {
                            $totalscore = $totalscore + $play->score;
                        }
                        ?>
                        <span class="label label-success" data-toggle="tooltip" data-placement="bottom" title="Total plays score" style="font-size: 130%">
                            {{ $totalscore }}</span>
                        <span class="label label-info" data-toggle="tooltip" data-placement="bottom" title="Total votes" style="font-size: 130%">
                            {{ $user->votes->count() }}</span>
                        <span class="label label-default" data-toggle="tooltip" data-placement="bottom" title="Total comments" style="font-size: 130%">
                            {{ $user->comments->count() }}</span>
                        </p>
                </div>
                <hr>
                <div style="display: table-cell; ">
                    <?php
                    $data = json_decode($user->data);
                    ?>
                    @if($user->user_type_id > 1 || $user->play->count() >= Lop::playmaster3 || $user->votes->count() >= Lop::votemaniac3 || $user->comments->count() >= Lop::commentator3)
                        @if($user->user_type_id>1)
                            <img class="noselection" data-toggle="tooltip" data-placement="bottom" title="Premium" src="/img/icon/medal/big/page-white-medal-icon.png">
                        @endif
                        @foreach($data->medals as $title=>$medal)
                        <img class="noselection" data-toggle="tooltip" data-placement="bottom" title="{{ $title }}" src="/img/icon/medal/big/{{ $medal}}.png">
                        @endforeach
                        
                        @if($user->play->count() >= Lop::playmaster1)
                            <img class="noselection" data-toggle="tooltip" data-placement="bottom" title="Play Master ({{ Lop::playmaster1 }}+)" src="/img/icon/medal/big/gold/medal-gold-1-icon.png">
                        @elseif($user->play->count() >= Lop::playmaster2)
                            <img class="noselection" data-toggle="tooltip" data-placement="bottom" title="Play Master ({{ Lop::playmaster2 }}+)" src="/img/icon/medal/big/silver/medal-silver-1-icon.png">
                        @elseif($user->play->count() >= Lop::playmaster3)
                            <img class="noselection" data-toggle="tooltip" data-placement="bottom" title="Play Master ({{ Lop::playmaster3 }}+)" src="/img/icon/medal/big/bronze/medal-bronze-1-icon.png">
                        @endif
                        
                        @if($user->votes->count() >= Lop::votemaniac1)
                            <img class="noselection" data-toggle="tooltip" data-placement="bottom" title="Vote Maniac ({{ Lop::votemaniac1 }}+)" src="/img/icon/medal/big/gold/medal-gold-2-icon.png">
                        @elseif($user->votes->count() >= Lop::votemaniac2)
                            <img class="noselection" data-toggle="tooltip" data-placement="bottom" title="Vote Maniac ({{ Lop::votemaniac2 }}+)" src="/img/icon/medal/big/silver/medal-silver-2-icon.png">
                        @elseif($user->votes->count() >= Lop::votemaniac3)
                            <img class="noselection" data-toggle="tooltip" data-placement="bottom" title="Vote Maniac ({{ Lop::votemaniac3 }}+)" src="/img/icon/medal/big/bronze/medal-bronze-2-icon.png">
                        @endif
                        
                        @if($user->comments->count() >= Lop::commentator1)
                            <img class="noselection" data-toggle="tooltip" data-placement="bottom" title="Commentator ({{ Lop::commentator1 }}+)" src="/img/icon/medal/big/gold/medal-gold-3-icon.png">
                        @elseif($user->comments->count() >= Lop::commentator2)
                            <img class="noselection" data-toggle="tooltip" data-placement="bottom" title="Commentator ({{ Lop::commentator2 }}+)" src="/img/icon/medal/big/silver/medal-silver-3-icon.png">
                        @elseif($user->comments->count() >= Lop::commentator3)
                            <img class="noselection" data-toggle="tooltip" data-placement="bottom" title="Commentator ({{ Lop::commentator3 }}+)" src="/img/icon/medal/big/bronze/medal-bronze-3-icon.png">
                        @endif
                    @elseif(empty($data->medals))
                    This user doesn't have any awards.
                    @else
                        @foreach($data->medals as $title=>$medal)
                        <img class="noselection" data-toggle="tooltip" data-placement="bottom" title="{{ $title }}" src="/img/icon/medal/big/{{ $medal}}.png">
                        @endforeach
                    @endif
                </div>
                <div style="display: table-cell; padding-left: 5px; ">
                    <a href="javascript:;" data-toggle="modal" data-target="#medals" style="text-decoration: none; color: grey; font-size: 90%;"><span class="glyphicon glyphicon-new-window"></span></a>
                </div>
            </div>
        </div>
        
        <div class="panel panel-default">
            <div class="panel-body" >             
                <?php
      
                $sdata = array(
                    'last_request' => Server::getDate(),
                    'summoners' => array(
                        'Boscorex' => array(
                            'summonerid' => 30758529,
                            'league' => 'SILVER',
                            'rank' => 2,
                            'region' => 'eune',
                            'iconid' => 591,
                            'level' => 30,
                            'date' => Server::getDate(),
                            'active' => true,
                        ),
                        'sucker kennen' => array(
                            'summonerid' => 31846820,
                            'league' => 'GOLD',
                            'rank' => 3,
                            'region' => 'eune',
                            'iconid' => 588,
                            'level' => 30,
                            'date' => Server::getDate(),
                            'active' => true,
                        ),
                    ),
                );
                //echo json_encode($sdata);
                ?>
                <?php
                $data = json_decode($user->summoner_data);
                ?>
                @if(empty($data->summoners))
                No verified summoners. 
                @if(Auth::user()->id == $user->id)
                <a href="/account" style="text-decoration: none; color: grey; font-size: 90%;"><span class="glyphicon glyphicon-new-window"></span></a>
                @endif
                @else
                <?php 
                    $v = LeagueCDN::getCurrentVersion()
                ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Icon</th>
                            <th>Name</th>
                            <th>League</th>
                            <th>Region</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data->summoners as $array)
                        @foreach($array as $org_name=>$summoner)
                        @if($summoner->active==true)
                        <tr>
                            <td style="vertical-align: middle;">
                                <img src='{{ LeagueCDN::getIcon($v, $summoner->iconid)}}' class="profileavatar" style="height: 32px; width: 32px;">
                            </td>
                            <td style="vertical-align: middle;">
                                <a data-toggle="tooltip" data-placement="bottom" title="Last check: {{ Lop::time_elapsed_string(strtotime($summoner->date)) }}" target="_blank" href="http://www.lolking.net/summoner/{{ $summoner->region }}/{{ $summoner->summonerid }}">{{ $org_name }}</a>
                                <span data-toggle="tooltip" data-placement="bottom" title="Level">({{ $summoner->level }})</span>
                            </td>
                            <?php
                            $img = strtolower($summoner->league)."_".$summoner->rank;
                            $league_title = ucfirst(strtolower($summoner->league))." ".Lop::toRoman($summoner->rank);
                            ?>
                            <td style="vertical-align: middle;">
                                <img src="/img/leagues/{{ $img }}.png" data-toggle="tooltip" data-placement="bottom" title="{{ $league_title }}" style="height: 32px; width: 32px;">
                            </td>
                            <td style="vertical-align: middle;">
                                {{ strtoupper($summoner->region) }}
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                    Plays ({{ $user->play->count() }})
                    <span id='legend' style='float: right;'>
                      <span class="label label-default">Default</span>
                      <span class="label label-success">Featured</span>
                      <span class="label label-warning">Pending Validation</span>
                      <span class="label label-danger">Deleted</span>
                   </span>
                </a>
                </h4>
            </div>
            <?php
            $astyle = '';
            if($user->play->count() < 50)
            {
                $astyle = 'in';
            }
            ?>
            <div id="collapseThree" class="panel-collapse collapse {{ $astyle }}">
            <div class="panel-body">
                @if(!$user->play->isEmpty())
                <ul class="list-group">
                @foreach($user->play_latest as $play)
                <?php $data = json_decode($play->data); ?>
                <li class='list-group-item'>
                    <a href="/my/manager/{{ $play->id }}" >
                        <a href='/play/{{ $play->id }}' style='text-decoration: none;'>
                        @if($play->active==0)
                        @if($data->passedvalidation=='pending')
                        <span class="label label-warning">
                        @elseif($data->passedvalidation==false)
                        <span class="label label-danger">
                        @endif
                        @elseif($play->type==0)
                        <span class="label label-danger">
                        @elseif($play->type==1)
                        <span class="label label-default">
                        @elseif($play->type==2)
                        <span class="label label-success">
                        @endif
                        {{ $play->name }}</span> 
                        </a>
                        <small>{{ Lop::when($play->date) }}</small>
                    </a>
                </li>
                @endforeach
                </ul>
                @else
                <div class="alert alert-info">This user doesn't have any plays on our service.</div>
                @endif

            </div>
            </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">

                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            Vote history 
                            @if(!$user->votes->isEmpty())
                            <span style="float: right">
                                Total: {{ $user->votes->count() }}
                            </span>
                            @endif
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse">
                    <div class="panel-body">
                        @if(!$user->votes->isEmpty())
                        <?php $c = 0 ?>
                        @foreach($user->votes_latest as $vote)
                        @if($c<5)
                        <div class="well well-sm commentbox">
                            <div style="display: table-cell; vertical-align: top; " class="commenttext">
                                @if($vote->type=='upvote')
                                <span class="glyphicon glyphicon-thumbs-up" style='color: green;'></span>
                                @elseif($vote->type=='downvote')
                                <span class="glyphicon glyphicon-thumbs-down" style='color: darkred;'></span>
                                @endif
                                <?php
                                $data = json_decode($user->data);
                                ?>
                                @if($data->votehistory==true)
                                on <a href="/play/{{ $vote->play_id }}">{{ $vote->play->name }}</a>, 
                                @elseif($data->votehistory==false)
                                on {{ '<code data-toggle="tooltip" data-placement="bottom" title="This user choose not to display this information." style><i>hidden</i></code>' }},
                                @endif
                                <span data-toggle="tooltip" data-placement="right" title="{{ Lop::when($vote->date) }}" style='color: grey;'>{{ Lop::time_elapsed_string(strtotime($vote->date)) }}</span>
                            </div>
                        </div>
                        <?php $c++; ?>
                        @endif
                        @endforeach
                        @if($user->id==Auth::user()->id)
                        <?php
                        $data = json_decode($user->data);
                        ?>
                        @if($data->votehistory==false)
                        <div class="alert alert-warning"><b>Your vote history is hidden from everyone!</b> Edit your privacy settings <a href="/account">here</a>.</div>
                        @elseif($data->votehistory==true)
                        <div class="alert alert-warning"><b>Your vote history is visible to everyone!</b> Edit your privacy settings <a href="/account">here</a>.</div>
                        @endif
                        @endif
                        @else
                        <div class="alert alert-info">This user hasn't voted for any play yet.</div>
                        @endif
                    </div>
                </div>
            </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                    Latest comments 
                    @if(!$user->comments->isEmpty())
                    <span style="float: right">
                    Total: {{ $user->comments->count() }}
                    </span>
                    @endif
                </a>
              </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
            <div class="panel-body">
                @if(!$user->comments->isEmpty())
                <?php $c = 0 ?>
                @foreach($user->comments_latest as $comment)
                @if($c<5)
                <div class="well well-sm" style='padding: 3px 3px 3px ;'>
                    <div style="display: table-cell; vertical-align: top; " class="commenttext">
                        <p id="commtext">
                            <i>{{ $comment->text }}</i>
                        </p>
                        <span data-toggle="tooltip" data-placement="left" title="{{ Lop::when($comment->date) }}" style='color: grey;'>{{ Lop::time_elapsed_string(strtotime($comment->date)) }}</span>, on <a href="/play/{{ $comment->play_id }}">{{ $comment->play->name }}</a>
                    </div>
                </div> 
                <?php $c++; ?>
                @endif
                @endforeach
                @else
                        <div class="alert alert-info">This user hasn't posted any comments yet.</div>
                @endif
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
    
</div>
<br/>
@stop
@section('jsfooter')
@parent
{{ HTML::style('/dist/image-picker/image-picker.css') }}
{{ HTML::script('/dist/image-picker/image-picker.min.js') }}
<script type="text/javascript">
    $("select").imagepicker();
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip({html: true});
    });
</script>
@stop