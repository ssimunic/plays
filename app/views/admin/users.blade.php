@extends('layouts.admin')
@section('content')
<h1>Users ({{ $totalusers }})</h1>
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
@if(!$users->isEmpty())
{{ Form::open(array(
            'url' => '/admin/users',
            'method' => 'GET',
            'role' => 'form'
            )) }}
<div class="input-group">
    <input type="text" name="q" class="form-control" placeholder="Search by username, display name or email" value="{{ Input::get('q') }}">
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
                    <th>Username &nbsp;<span class="glyphicon glyphicon-sort small"></span></th>
                    <th>Email &nbsp;<span class="glyphicon glyphicon-sort small"></span></th>
                    <th>Type &nbsp;<span class="glyphicon glyphicon-sort small"></span></th>
                    <th>Plays &nbsp;<span class="glyphicon glyphicon-sort small"></span></th>
                    <th>Registration date &nbsp;<span class="glyphicon glyphicon-sort small"></span></th>
                    <th>Last login &nbsp;<span class="glyphicon glyphicon-sort small"></span></th>
                    <th>Last IP &nbsp;<span class="glyphicon glyphicon-sort small"></span></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        <a href="/admin/users/edit/{{ $user->id }}">{{ $user->username }}</a>
                        @if($user->display_name!='Undefined')
                        ({{ $user->display_name }})
                        @endif
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->user_type_id==0)
                        <span class="text-muted">Banned</span>
                        @elseif($user->user_type_id==1)
                        Default
                        @elseif($user->user_type_id==2)
                        <b>Premium</b>
                        @elseif($user->user_type_id==4)
                        <b><span style="color: purple">Admin</span></b>
                        @endif
                    </td>
                    <td>
                        @if($user->play->count()>0)
                        <a href="/admin/plays?q={{ $user->id }}">{{ $user->play->count() }}</a>
                        @else
                        0
                        @endif
                    </td>
                    <td>{{ Lop::when($user->registration_date) }}</td>
                    <td>
                        <?php
                        if ($user->last_login == null) {
                            echo 'Never';
                        } else {
                            echo Lop::time_elapsed_string(strtotime($user->last_login));
                        }
                        ?>
                    </td>
                    <td>{{ $user->last_ip }}</td>
                    <td>
                        @if($user->user_type_id==0)
                            <a href="/admin/users/unban/{{ $user->id }}" ><span data-toggle="tooltip" data-placement="top" title="Unban" style="text-decoration: none; color: green;" class="glyphicon glyphicon-ok-circle"></span></a>
                        @endif
                        @if($user->user_type_id==1)
                        <a href="/admin/users/gift/{{ $user->id }}"><span data-toggle="tooltip" data-placement="top" title="Gift 1 Month Premium" style="text-decoration: none; color: grey;" class="glyphicon glyphicon-gift"></span></a>
                        &nbsp;
                        @endif
                        
                        @if($user->user_type_id<=2 && $user->user_type_id>0)
                            <a href="/admin/users/ban/{{ $user->id }}" ><span data-toggle="tooltip" data-placement="top" title="Ban" style="text-decoration: none; color: red;" class="glyphicon glyphicon-ban-circle"></span></a>
                        @endif
                        
                        @if($user->user_type_id>=3)
                        None
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<center><?php echo $users->appends(array_except(Input::all(), 'page'))->links(); ?></center>
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
</script>
@stop