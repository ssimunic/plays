@extends('layouts.master')
@section('content')
<h1>Account <small>{{ Auth::user()->email }}</small></h1>
<hr>
@if(!$errors->isEmpty())
<div class="alert alert-danger">
    @if(Session::has('message'))
        {{ Session::get('message'); Session::forget('message') }}
    @endif
    <ul>
        @foreach($errors->all() as $error)
        <li> {{ $error }} </li>
        @endforeach
    </ul>
</div>
@endif
@if(Session::has('message_success'))
<div class="alert alert-success">
    {{ Session::get('message_success'); Session::forget('message_success') }}
</div>
@endif
@if(Session::has('message_fail'))
<div class="alert alert-danger">
    {{ Session::get('message_fail'); Session::forget('message_fail') }}
</div>
@endif
<div class="panel panel-default">
  <div class="panel-heading">Summoners</div>
  <div class="panel-body">
        <?php
        $sdata = json_decode($user->summoner_data);
        $v = LeagueCDN::getCurrentVersion()
        ?>
      @if(empty($sdata->summoners))
      No verified summoners.
      @else
      <table class="table table-hover">
          <thead>
              <tr>
                  <th>Icon</th>
                  <th>Name</th>
                  <th>Level</th>
                  <th>League</th>
                  <th>Region</th>
                  <th>Date added</th>
                  <th>Summoner ID</th>
                  {{--<th>Actions</th>--}}
              </tr>
          </thead>
          <tbody>
              @foreach($sdata->summoners as $array)
                @foreach($array as $org_name=>$summoner)
                @if($summoner->active==true)
                <tr>
                    <td style="vertical-align: middle;">
                      <img src='{{ LeagueCDN::getIcon($v, $summoner->iconid)}}' class="profileavatar" style="height: 32px; width: 32px;">
                    </td>
                    <td style="vertical-align: middle;">
                      <a data-toggle="tooltip" data-placement="bottom" title="Last check: {{ Lop::time_elapsed_string(strtotime($summoner->date)) }}" target="_blank" href="http://www.lolking.net/summoner/{{ $summoner->region }}/{{ $summoner->summonerid }}">{{ $org_name }}</a>
                    </td>
                    <td style="vertical-align: middle;">
                      <span data-toggle="tooltip" data-placement="bottom" title="Level">{{ $summoner->level }}</span>
                    </td>
                    <?php
                    $img = strtolower($summoner->league) . "_" . $summoner->rank;
                    $league_title = ucfirst(strtolower($summoner->league)) . " " . Lop::toRoman($summoner->rank);
                    ?>
                    <td style="vertical-align: middle;">
                      <img src="/img/leagues/{{ $img }}.png" data-toggle="tooltip" data-placement="bottom" title="{{ $league_title }}" style="height: 32px; width: 32px;">
                    </td>
                    <td style="vertical-align: middle;">
                      {{ strtoupper($summoner->region) }}
                    </td>
                    <td style="vertical-align: middle;">
                        {{ Lop::when($summoner->date) }}
                    </td>
                    <td style="vertical-align: middle;">{{ $summoner->summonerid }}</td>
                    {{--<td style="vertical-align: middle;">
                        <a href="/account/removesummoner/{{ base64_encode($org_name) }}" style="text-decoration: none; color: red;"><span class="glyphicon glyphicon-remove"></span></a>
                    </td>--}}
                </tr>
                @endif
                @endforeach
              @endforeach
          </tbody>
      </table>
      @endif
      <hr>
      {{-- Session::forget('code') --}}
      <?php
      $verification_code = strtoupper(Str::random(5));
      ?>
      @if(Session::has('code'))
      <?php $code = Session::get('code'); ?>
      @else
      <?php $code = $verification_code; Session::put('code', strtoupper($code)); ?>
      @endif
      <button id="bsummoner" type="button" class="btn btn-success">Verify summoner</button>

      <div id="vsummoner" style="display: none;">
        <div class='alert alert-info'>
          Please rename one of your rune pages to following verification code: <code>LOP{{ $code }}</code>
        </div>
          {{ Form::open(array(
                          'url' => 'account/verifysummoner',
                          'method' => 'POST',
                          'role' => 'form',
                          'class' => 'form-horizontal',
                          )) }}
            <div class="form-group">
                <label for="sname" class="col-sm-2 control-label">Summoner name</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="sname" id="sname" placeholder="Summoner name">
                </div>
            </div>
            <div class="form-group">
                <label for="region" class="col-sm-2 control-label">Region</label>
                <div class="col-sm-4">
                    <select name="region" class="form-control">
                        <option value="na">NA</option>
                        <option value="euw">EUW</option>
                        <option value="eune">EUNE</option>
                    </select>
                </div>
            </div>      
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Verify</button>
                </div>
            </div>
        {{ Form::close() }}
      </div>
  </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <?php
        $data = json_decode($user->data);
        ?>
        <legend>Display name</legend>
         {{ Form::open(array(
                        'url' => 'account/displayname',
                        'method' => 'POST',
                        'role' => 'form',
                        'class' => 'form-horizontal',
                        )) }}
            <div class="form-group">
                <div class="col-sm-3">
                    <input @if($user->display_name!="Undefined") value="{{ Auth::user()->display_name }}" @endif type="displayname" name="displayname" class="form-control" id="inputEmail3" @if(Auth::user()->user_type_id<2)  placeholder="Available for premium users only" disabled @endif>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    @if($user->display_name!="Undefined")
                    <button @if(Auth::user()->user_type_id<2) disabled @endif type="submit" name="remove" class="btn btn-danger">Remove</button>
                    @endif
                    <button @if(Auth::user()->user_type_id<2) disabled @endif type="submit" name="save" class="btn btn-default">Save</button>
                </div>
            </div>
        {{ Form::close() }}
        <br/>
        <?php
        $ignorelist = $data->ignorelist;
        ?>
        <legend>Change password</legend>
        <p>
            {{ Form::open(array(
                        'url' => 'account/changepassword',
                        'method' => 'POST',
                        'role' => 'form',
                        'class' => 'form-horizontal',
                        )) }}
        <form class="form-horizontal" role="form">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Current password</label>
                <div class="col-sm-10">
                    <input type="password" name="current" class="form-control" id="current" placeholder="Current password">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">New password</label>
                <div class="col-sm-10">
                    <input type="password" name="new" class="form-control" id="current" placeholder="New password">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Confirm password</label>
                <div class="col-sm-10">
                    <input type="password" name="new_confirmation" class="form-control" id="current" placeholder="Confirm password">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
            </div>
            {{ Form::close() }}
        </p>
        <br/>
        <legend>Ignore list</legend>
        <p>
            @if(empty($ignorelist))
                You don't have any user on ignore list.
            @else
                @foreach($ignorelist as $user)
                    <span class="label label-default">{{ $user }} <a href="/account/ignore/remove/{{ $user }}" style="text-decoration: none;"><span class="glyphicon glyphicon-remove" style="font-size: 90%; color: whitesmoke;"></span></a></span>
                @endforeach
            @endif
        </p>
        {{ Form::open(array(
                        'url' => 'account/ignore',
                        'method' => 'POST',
                        'role' => 'form',
                        'class' => 'form-horizontal',
                        )) }}
            <div class="form-group">
                <div class="col-sm-3">
                    <input type="text" name="username" class="form-control" placeholder="Enter username">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <button type="submit" name="ADD" class="btn btn-default">Add</button>
                </div>
            </div>
        {{ Form::close() }}
        
        <br/>
        <legend>Privacy</legend>   
        {{ Form::open(array(
                        'url' => 'account/votehistory',
                        'method' => 'POST',
                        'role' => 'form',
                        )) }}
                    @if($data->votehistory==false)
                    <button type="submit" name="show" class="btn btn-primary">Show vote history</button>
                    @elseif($data->votehistory==true)
                    <button type="submit" name="hide" class="btn btn-danger">Hide vote history</button>
                    @endif
        {{ Form::close() }}
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Last login</th>
                    <th>Last IP</th>
                    <th>Registration date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ Lop::time_elapsed_string(strtotime(Auth::user()->last_login)) }}, {{ Lop::when(Auth::user()->last_login) }}</td>
                    <td>{{ Auth::user()->last_ip }}</td>
                    <td>{{ Lop::when(Auth::user()->registration_date) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@stop
@section('jsfooter')
@parent
<script type="text/javascript">
    $("#bsummoner").click(function(){
        $("#bsummoner").hide('fast');
        $("#vsummoner").show('fast');
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip({html: true});
    });
</script>
@stop