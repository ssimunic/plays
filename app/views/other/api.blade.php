@extends('layouts.master')
@section('content')
<h1>API <small>For developers</small></h1>
<hr>
<?php
if($data->isEmpty())
{
    $key = Str::random(32);
}
else
{
    $key = $data[0]->key;
}
?>
<p>
    @if(!$data->isEmpty()) 
        <span class="label label-success">Key available</span> <span class="label label-default">{{ $key }}<span>
    @else 
        <span class="label label-danger">Key not available</span> <span class="label label-default">Keys are not currently given out by request, sorry.</span>
    @endif
</p>
<div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" style="text-decoration: none;">
            <span class="label label-primary">GET</span> /api/{key}/plays/latest
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse">
      <div class="panel-body">
        <table class="table">
            <tbody>
              <tr>
                <td style='width: 150px;'><b><span style='color: grey'>Example request</span></b></td>
                <td>
                    <a href="/api/{{ $key }}/plays/latest">http://{{ Lop::domain }}/api/{{ $key }}/plays/latest</a>
                </td>
              </tr>
              <tr>
                <td style='width: 150px;'><b><span style='color: grey'>Example response</span></b></td>
                <td>
                    <pre><?php
                echo JSON::prettyPrint('[{"id":22,"link":"http:\/\/www.youtube.com\/watch?v=ogbtlm8bNA8","name":"Yasuo \"Ninja\" Gank | A sneaky, unpredictable gank utilizing Wraiths","description":"<span style=\"font-family: arial, sans-serif; font-size: 13px; line-height: 17px;\">A very helpful trick I found while playing Yasuo in the Jungle. Basically, you can charge up your q on any wraith camp, fly through the wall and kill whoever is in your way. This makes for a very sneaky and unpredictable gank in the mid lane. Its kind of hard to get right, but once you do, it will suprise your opponent and hopefully grant you and your teammate the kill.<\/span>","tags":"Yasuo","date":"2014-01-02 09:09:24","score":1,"positive":1,"negative":0,"type":2,"active":1,"data":null,"user_id":1,"category_id":1,"category":{"id":1,"name":"Default"}},{"id":17,"link":"https:\/\/www.youtube.com\/watch?v=_o3k2-tvW0c","name":"Super Secret Backdoor Ninjas!","description":"<span style=\"font-family: arial, sans-serif; font-size: 13px; line-height: 17px;\">Stream is up and Live! Come check it out on the link below:<\/span><br style=\"font-family: arial, sans-serif; font-size: 13px; line-height: 17px;\"><br style=\"font-family: arial, sans-serif; font-size: 13px; line-height: 17px;\">a href=\"http:\/\/www.twitch.tv\/snacksna\" target=\"_blank\" title=\"http:\/\/www.twitch.tv\/snacksna\" rel=\"nofollow\" dir=\"ltr\" class=\"yt-uix-redirect-link\" style=\"margin: 0px; padding: 0px; border: 0px; font-size: 13px; background-color: rgb(255, 255, 255); cursor: pointer; color: rgb(39, 147, 230); font-family: arial, sans-serif; line-height: 17px;\">http:\/\/www.twitch.tv\/snacksna<\/a>","tags":"Backdoor","date":"2014-01-02 09:04:12","score":1,"positive":1,"negative":0,"type":1,"active":0,"data":null,"user_id":1,"category_id":1,"category":{"id":1,"name":"Default"}},<i>...and others</i>]', true);
                ?>
                    </pre>
                </td>
              </tr>
            </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" style="text-decoration: none;">
          <span class="label label-primary">GET</span> /api/{key}/play/{id}
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse">
      <div class="panel-body">
        <table class="table">
            <tbody>
              <tr>
                <td style='width: 150px;'><b><span style='color: grey'>Example request</span></b></td>
                <td>
                    <a href="/api/{{ $key }}/play/22">http://{{ Lop::domain }}/api/{{ $key }}/play/22</a>
                </td>
              </tr>
              <tr>
                <td style='width: 150px;'><b><span style='color: grey'>Example response</span></b></td>
                <td>
                    <pre>{{ JSON::prettyPrint('{"id":22,"link":"http:\/\/www.youtube.com\/watch?v=ogbtlm8bNA8","name":"Yasuo \"Ninja\" Gank | A sneaky, unpredictable gank utilizing Wraiths","description":"A very \"helpful trick I found while playing Yasuo in the Jungle<\/u>. Basically, you can charge up your q on any wraith camp, fly through the wall and kill whoever is in your way. This makes for a very sneaky and unpredictable gank in the mid lane. It\'s kind of hard to get right, but once you do, it will suprise your opponent and hopefully grant you and your teammate the kill.d unpredictable gank in the mid lane. It\'s kind of hard to get right, but once you do, it will suprise your opponent and hopef&nbsp;hopef&nbsp;hopef&nbsp;hopef&nbsp;hopef","tags":"Yasuo","date":"2014-01-30 09:02:24","score":15,"positive":18,"negative":3,"type":2,"active":1,"data":"{\"comments\":true,\"passedvalidation\":true}","champion":"Yasuo","user_id":1,"category_id":1}', true) }}
                    </pre>
                </td>
              </tr>
            </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" style="text-decoration: none;">
          <span class="label label-primary">GET</span> /api/{key}/user/{id}
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse">
      <div class="panel-body">
        <table class="table">
            <tbody>
              <tr>
                <td style='width: 150px;'><b><span style='color: grey'>Example request</span></b></td>
                <td>
                    <a href="/api/{{ $key }}/user/1">http://{{ Lop::domain }}/api/{{ $key }}/user/1</a>
                </td>
              </tr>
              <tr>
                <td style='width: 150px;'><b><span style='color: grey'>Example response</span></b></td>
                <td>
                    <pre>{{ JSON::prettyPrint('[{"id":1,"username":"artikan","user_type_id":2,"display_name":"Undefined","registration_date":"2013-12-30 00:52:42","avatar":"avatar\/default"}]', true) }}
                    </pre>
                </td>
              </tr>
            </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour" style="text-decoration: none;">
          <span class="label label-danger">POST</span> /api/authorize
        </a>
      </h4>
    </div>
    <div id="collapseFour" class="panel-collapse collapse">
      <div class="panel-body">
        <table class="table">
            <tbody>
              <tr>
                <td style='width: 150px;'><b><span style='color: grey'>URL</span></b></td>
                <td>
                    <a href="/api/authorize">http://{{ Lop::domain }}/api/authorize</a>
                </td>
              </tr>
              <tr>
                <td style='width: 150px;'><b><span style='color: grey'>Required</span></b></td>
                <td>
                    key, username, password
                </td>
              </tr>
              <tr>
                <td style='width: 150px;'><b><span style='color: grey'>Example response</span></b></td>
                <td>
                    <pre>{{ JSON::prettyPrint('{"response":"valid"}', true) }}</pre>
                    <pre>{{ JSON::prettyPrint('{"response":"invalid"}', true) }}</pre>
                </td>
              </tr>
            </tbody>
        </table>
      </div>
    </div>
  </div>  
</div>
@stop