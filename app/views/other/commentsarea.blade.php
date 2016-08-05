{{-- COMMENTS START --}}
<div class="panel panel-info">
    <div class="panel-heading">Comments ({{ $play->comments->count() }})</div>
    <div class="panel-body">
        @if($play->comments->isEmpty())
        This play doesn't have any comments yet.
        @else

        <?php

        function getComments($comment, $id) {
            echo "<li style='list-style-type: none;'>";
            ?>
            <?php
            $panelstyle = '';
            ?>     
            <div class="well well-sm commentbox" style="{{ $panelstyle }}">
                <div style="display: table-cell;">
                    <div style="background: url('/img/{{ $comment->user->avatar }}.jpg'); background-size: 100%;" class="commentavatar"></div>
                </div>
                <div style="display: table-cell; vertical-align: top; " class="commenttext">
                    @if($comment->user->display_name=='Undefined')
                    <a href="/profile/{{ $comment->user->username }}">{{ $comment->user->username }}</a>
                    @else
                    <a href="/profile/{{ $comment->user->username }}">{{ $comment->user->display_name }}</a>
                    @endif
                    @if($comment->user->user_type_id==0)
                        {{ '<font size="1">[<span style="color: red">Banned</span>]</font>' }}
                    @elseif($comment->user->user_type_id==2)
                        {{--<img title="Premium" src='/img/icon/medal/small/page-white-medal-icon.png'>--}}
                        <font size="2"><span class="glyphicon glyphicon-star" style="color: #005580;"></span></font>
                    @elseif($comment->user->user_type_id==4)
                        {{ '<font size="1">[<span style="color: purple">Admin</span>]</font>' }}                 
                    @endif
                    <small><span style="color: grey" data-toggle="tooltip" data-placement="top" title="{{ Lop::when($comment->date) }}" >{{ Lop::time_elapsed_string(strtotime($comment->date)) }}</span></small>
                    @if(Auth::user() && Auth::user()->id==$comment->user_id)
                    <a href="/comment/delete/{{ $id }}/{{ $comment->id}}"><span data-toggle="tooltip" data-placement="top" title="Delete" class="glyphicon glyphicon-remove" style="float: right; color: #e74c3c;"></span></a>
                    @endif
                    @if(Auth::user() && Auth::user()->id==$comment->user_id)
                    <a href="javascript:;" onclick="$(this).editComment({{ $comment->id }}, '{{ str_replace('"', '\'', addslashes($comment->text)) }}');"><span data-toggle="tooltip" data-placement="top" title="Edit" class="glyphicon glyphicon-pencil" style="margin-right: 5px; float: right; color: #3498db;"></span></a>
                    @endif
                    @if(Auth::user())
                    <a href="javascript:;" onclick="$(this).newForm({{ $comment->id }});"><span data-toggle="tooltip" data-placement="top" title="Reply"  class="glyphicon glyphicon-comment" style="margin-right: 5px; float: right; color: #2c3e50;"></span></a>
                    @endif
                    <span class="likes" style="color: green; cursor: pointer; float: right; margin-top: -3px; margin-right: 5px; @if($comment->score==0) display: none; @endif">{{ $comment->score }}</span>
                    <a href="javascript:;" class="likec" data-id="{{ $comment->id }}" data-score="{{ $comment->score }}"> <span data-toggle="tooltip" data-placement="top" title="@if(Auth::user()) Like @else Please login first @endif" class="glyphicon glyphicon-thumbs-up" style="color: green; cursor: pointer; float: right; margin-top: -1px; margin-right: 5px;"></span></a>
                    <p id="commtext" style="margin-bottom: 3px;">
                        {{ $comment->text }}
                    </p>                    
                </div>
                <div style="display: table-row;">
                    <div style="display: table-cell; vertical-align: top;">
                       
                    </div>
                    <div id="commentnewsubmit" style="display: table-cell; vertical-align: top;" class="commenttext">
                       
                    </div>
                </div>
            </div>  

            <?php
            $q = PlayComments::where('parent_id', '=', $comment->id)
                    ->where('play_id', '=', $id)
                    ->orderBy('date', 'asc')
                    ->get();
            
            if (!$q->isEmpty()) { // there is at least reply  
                echo "<ul class='commentli'>";
                foreach ($q as $row) {
                    getComments($row, $id);
                }
                echo "</ul>";
                echo "</li>";
            }
        }

        $q = PlayComments::where('parent_id', '=', null)
                ->where('play_id', '=', $play->id)
                ->orderBy('score', 'desc')
                ->orderBy('date', 'desc')
                ->paginate(100);
        
        foreach ($q as $row) {
            getComments($row, $play->id);
        }
        ?>
        <center>{{ $q->fragment('comments')->links() }}</center>
        @endif
    </div>
</div>
{{-- COMMENTS END --}}
