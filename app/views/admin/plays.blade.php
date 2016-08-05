@extends('layouts.admin')
@section('content')
<h1>Plays ({{ $totalplays }})</h1>
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
@if(!$plays->isEmpty())
{{ Form::open(array(
            'url' => '/admin/plays',
            'method' => 'GET',
            'role' => 'form'
            )) }}
<div class="input-group">
    <input type="text" name="q" class="form-control" placeholder="Search by name or tag" value="{{ Input::get('q') }}">
    <div class="input-group-btn">
        <button type="submit" class='btn btn-default'>&nbsp; Search &nbsp;</button> 
    </div>
</div>
            
{{ Form::close() }}
<hr>
<div class="panel panel-default">
    <div class="panel-body">

        <table id="users" class="table table-hover tablesorter">
            <thead>
                <tr>
                    <th>ID &nbsp;<span class="glyphicon glyphicon-sort small"></span></th>
                    <th>Preview</th>
                    <th>Name &nbsp;<span class="glyphicon glyphicon-sort small"></span></th>
                    <th>User &nbsp;<span class="glyphicon glyphicon-sort small"></span></th>
                    <th>Date &nbsp;<span class="glyphicon glyphicon-sort small"></span></th>
                    <th>Status &nbsp;<span class="glyphicon glyphicon-sort small"></span></th>
                    <th>Score &nbsp;<span class="glyphicon glyphicon-sort small"></span></th>
                    <th>Champion</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($plays as $play)
                <tr>
                    <td>{{ $play->id }}</td>
                    <td>
                        <img data-toggle="tooltip" data-placement="top" title="Click to quick view" src="{{ YouTube::getThumbnail($play->link) }}" class="img-responsive previewvid" style="cursor: pointer; height: 50px; border-radius:5px;">
                    </td>
                    <td>
                        <a href="/{{ $play->id}}" target="_blank">{{ $play->name }}</a>
                        <style type="text/css">
                            .playyoutubevideo
                            {
                                border: 3px solid #cccccc; 
                                border-radius: 5px; 
                                display: block;
                                //height: 100%;
                                //width: 100%;
                            }
                        </style>
                        <div id="standout" class='playvideo' data-name="{{ $play->id }}" style="display: none;">
                            <hr>
                            <p class="playyoutubevideo">
                                <object width="560" height="315">
                                    <param name="movie" value="https://www.youtube.com/v/{{ YouTube::getID($play->link) }}?version=3&amp;hl=hr_HR"></param>
                                    <param name="allowFullScreen" value="true"></param>
                                    <param name="allowscriptaccess" value="always"></param>
                                    <embed id="video"  src="https://www.youtube.com/v/{{ YouTube::getID($play->link) }}?enablejsapi=1&version=3&autohide=1&showinfo=0&rel=0&iv_load_policy=3" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true"></embed>
                                </object>
                            </p>
                        </div>
                    </td>
                    <td><a href="/admin/users?q={{ $play->user->username }}">{{ $play->user->username }}</a></td>
                    <td>{{ Lop::time_elapsed_string(strtotime($play->date)) }}</td>
                    <td>@if($play->active==0) <span style="color: orange;"><b>Validation</b></span> @elseif($play->type==0) <span class="text-muted">Deleted</span>  @elseif($play->type==2) <span style="color: green;"><b>Featured</b></span> @else OK  @endif</td>
                    <td>{{ $play->score }}</td>
                    <td>@if($play->champion!=null)<img style="height: 50px; width: 50px; border-radius:5px;" src="/img/champions/squares/{{ Lop::getChampImg($play->champion) }}Square.png">@else Not specified @endif</td>
                    <td>
                        
                        @if($play->active==0)
                            <a href="/admin/plays/validate/{{ $play->id }}" ><span data-toggle="tooltip" data-placement="top" title="Validate" style="text-decoration: none; color: green;" class="glyphicon glyphicon-ok"></span></a>
                            &nbsp;
                        @endif
                        
                        @if($play->type==0)
                            <a href="/admin/plays/restore/{{ $play->id }}" ><span data-toggle="tooltip" data-placement="top" title="Restore" style="text-decoration: none; color: green;" class="glyphicon glyphicon-ok-circle"></span></a>
                            &nbsp;
                        @endif
                        
                        @if($play->type>=1)
                            <a href="/admin/plays/delete/{{ $play->id }}" ><span data-toggle="tooltip" data-placement="top" title="Delete" style="text-decoration: none; color: red;" class="glyphicon glyphicon-ban-circle"></span></a>
                            &nbsp;
                        @endif
                        
                        @if($play->type!=2)
                            <a href="/admin/plays/feature/{{ $play->id }}" ><span data-toggle="tooltip" data-placement="top" title="Feature" style="text-decoration: none; color: purple;" class="glyphicon glyphicon-star"></span></a>
                            &nbsp;
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<center><?php echo $plays->appends(array_except(Input::all(), 'page'))->links(); ?></center>
@else
<div class="alert alert-info">
    No results.
</div>
@endif
@stop
@section('jsfooter')
@parent
{{ HTML::script('/dist/tablesorter/jquery.tablesorter.js') }}
<script type="text/javascript">
$(document).ready(function() { 
    $("#users").tablesorter(); 
    $('[data-toggle="tooltip"]').tooltip({html: true});
    
}); 

</script>

{{ HTML::script('/dist/jquery.fitvids.js') }}

<script type="text/javascript">
    $(".playvideo").fitVids();
    $(".previewvid").click(function() {
        $(this).parent().parent().find('.playvideo').toggle('slow');
    });
</script>
@stop