<?php

class CommentController extends BaseController
{
    public function comment()
    {
        if(Auth::user())
        {
            if(Input::get('reply'))
            {
                    $comment = new PlayComments;
                    $comment->text = Input::get('reply');
                    $comment->date = Server::getDate();
                    $comment->play_id = Input::get('playid');
                    $comment->user_id = Auth::user()->id;
                    $comment->parent_id = Input::get('parent_id');
                    $comment->save();

                    return Redirect::to('/play/'.Input::get('playid').'#comments');
            }
            elseif(Input::get('comment'))
            {
                    $comment = new PlayComments;
                    $comment->text = Input::get('comment');
                    $comment->date = Server::getDate();
                    $comment->play_id = Input::get('playid');
                    $comment->user_id = Auth::user()->id;
                    $comment->save();

                    return Redirect::to('/play/'.Input::get('playid').'#comments');
            }
            elseif(Input::get('comment')==null || Input::get('reply')==null)
            {
                return Redirect::route('index');
            }
        }
        else
        {
            return App::abort('401');
        }
    }
    
    public function deleteComment($playid, $id)
    {
        if(Auth::user())
        {
            $comment = PlayComments::find($id);
            
            if($comment->user_id == Auth::user()->id)
            {
                DB::statement('SET FOREIGN_KEY_CHECKS = 0'); //disable
                $comment->delete();
                DB::statement('SET FOREIGN_KEY_CHECKS = 1'); //emable
                
                return Redirect::to('/play/'.$playid.'#comments')->with('message', 'Your comment has been successfully deleted.');
            }
            else
            {
                return App::abort('401');
            }            
        }
        else
        {
            return App::abort('401');
        }
    }
    
    public function editComment()
    {
        if(Auth::user())
        {
            $comment = PlayComments::find(Input::get('commentid'));
            
            if($comment->user_id == Auth::user()->id)
            {
                $playid = Input::get('playid');
                
                $comment->text = Input::get('edit');
                $comment->save();
                
                return Redirect::to('/play/'.$playid.'#comments')->with('message', 'Your comment has been successfully saved.');
            }
            else
            {
                return App::abort('401');
            }            
        }
        else
        {
            return App::abort('401');
        }
    }
}