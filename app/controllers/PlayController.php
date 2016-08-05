<?php

class PlayController extends BaseController 
{
    public function handleSubmit()
    {
        $messages = array(
            'terms.required' => 'Please agree to Terms and Conditions',
            'link.youtubevideo' => 'Invalid video link.',
        );
        
        $data = Input::all();
        
        $validation = Validator::make($data, Play::$val_rules, $messages);
        
        if($validation->passes())
        {
            if(Auth::user()->user_type_id>0) // !!!!!! this was firstly 1, because only premium could go without validation, now different system
            {
                $active = 1;
                $passedvalidation = 'true';
                $message = 'Your play has been received and it is ready to be shared.';
            }
            else
            {
                $active = 0;
                $passedvalidation = 'pending';
                $message = 'Your play has been received and currently it is going through content validation.'
                    . 'You will know when it is ready in <a href="my/manager/">Manager</a> section.';
            }
            $data = array(
                'comments' => true,
                'passedvalidation' => $passedvalidation,
                'reports' => 0,
            );
            
            $champ = Input::get('champ');
            if($champ == '')
            {
                $champ = null;
            }
            
            $play = new Play;
            $play->link = Input::get('link');
            $play->name = Input::get('name');
            $play->description = Input::get('description');
            $play->tags = Input::get('tags');
            $play->date = Server::getDate();
            $play->user_id = Auth::user()->id;
            $play->category_id = Input::get('category');
            $play->positive = 1;
            $play->score = 1;
            $play->active = $active;
            $play->data = json_encode($data);
            $play->champion = $champ;
            $play->save();
            
            return Redirect::route('my')->with('message_success', $message);

        }
        else
        {
            return Redirect::route('submit')->with('message', 'The following errors occurred:')->withErrors($validation);
        }
    }
    
    public function manage()
    {
        $messages = array(
            'terms.required' => 'Please agree to Terms and Conditions',
            'link.youtubevideo' => 'Invalid video link.',
        );
        
        $data = Input::all();
        
        $validation = Validator::make($data, Play::$val_rules, $messages);
        
        if($validation->passes())
        {
            $play = Play::find(Input::get('id'));
            $data = json_decode($play->data);
            if(Auth::user()->id!=$play->user_id) {
                App::abort('401');
            }
            
            if(Input::get('delete')=='true') {
                $play->type = 0;
            }
            
            if (Input::get('comments')) {
                $data->comments = true;
            } else {
                $data->comments = false;
            }

            $play->link = Input::get('link');
            $play->name = Input::get('name');
            $play->description = Input::get('description');
            $play->tags = Input::get('tags');
            $play->category_id = Input::get('category');
            $play->data = json_encode($data);
            $play->save();
            
            if(Input::get('delete')=='true')
            {
                return Redirect::to('/my/manager');
            }
            else
            {
                return Redirect::route('my')->with('message_success', 'Your play has been saved.');
            }

        }
        else
        {
            return Redirect::to('/my/manager/'.Input::get('id'))->with('message', 'The following errors occurred:')->withErrors($validation);
        }
    }
    
    // normal play
    public function showPlay($id)
    {
        $time = date('Y-m-d H:i:s',(strtotime(Server::getDate())-(86400*3)));

        $plays = Play::where('id', '=', $id)
                ->with('comments')
                ->with('user')
                ->with('category')
                ->get();
        
        $play = $plays[0];
        
        $votes = array();
        if(Auth::user())
        {
            $votes = PlayVote::where('user_id', '=', Auth::user()->id)
                    //->where('date', '>', $time)
                    ->get();
        }
        
        /*$comments = PlayComments::where('play_id', '=', $play->id)
                            ->orderBy('date', 'desc')
                            ->paginate(100);*/
        
        return View::make('site.play')->with(array(
            'title' => $play->name,
            'play' => $play,
            //'comments' => $comments,
            'votes' => $votes,
        ));
    }
    
    //
    public function mobilePlay($id)
    {
        $time = date('Y-m-d H:i:s',(strtotime(Server::getDate())-(86400*3)));

        $plays = Play::where('id', '=', $id)
                ->with('comments')
                ->with('user')
                ->with('category')
                ->get();
        
        $play = $plays[0];
        
        $votes = array();
        if(Auth::user())
        {
            $votes = PlayVote::where('user_id', '=', Auth::user()->id)
                    ->where('date', '>', $time)
                    ->get();
        }
        
        /*$comments = PlayComments::where('play_id', '=', $play->id)
                            ->orderBy('date', 'desc')
                            ->paginate(100);*/
        
        return View::make('mobile.play')->with(array(
            'title' => $play->name,
            'play' => $play,
            //'comments' => $comments,
            'votes' => $votes,
        ));
    }
    
    // upvote comment
    public function likeComment()
    {
        if(Request::ajax())
        {
            if(Auth::user())
            {
                $id = Input::get('id');

                if(Session::has("comment$id"))
                {
                    return 'failure';
                }

                Session::put("comment$id", true);

                $comment = PlayComments::find($id);
                $comment->score = $comment->score+1;
                $comment->save();

                return 'success';
            }
            else
            {
                return 'failure';
            }
        }
    }
    
    // ajax comments, currently disabled
    public function refreshComments()
    {
        if(Request::ajax())
        {
            $playid = Input::get('playid');
            $plays = Play::where('id', '=', $playid)
                    ->with('comments')
                    ->with('user')
                    ->with('category')
                    ->get();

            $play = $plays[0];

            $comments = PlayComments::where('play_id', '=', $play->id)
                                ->orderBy('date', 'desc')
                                ->paginate(100);

            return View::make('other.commentsarea')->with(array(
                'play' => $play,
                'comments' => $comments,
            ));
        }
    }
    
    // check if any new comments
    public function checkComments()
    {
        if(Request::ajax())
        {
            $playid = Input::get('playid');
            $commentsnum = Input::get('commentsnum');
            
            $data = Play::where('id', '=', $playid)
                    ->with('comments')
                    ->get();
            $play = $data[0];
                        
            $currentnum = $play->comments->count();
            
            if($currentnum==$commentsnum)
            {
                return false;
            }
            else
            {
                return $currentnum-$commentsnum;
            }
        }
    }
    
    public function ajaxVote()
    {
        if(Request::ajax())
        {
            $play_id = Input::get('postid');
            $action = Input::get('action');
            
            $data = PlayVote::where('user_id', '=', Auth::user()->id)
                    ->where('play_id', '=', $play_id)
                    ->get();
            
            if($data->isEmpty())
            {
                if($action=='up')
                {
                    $vote = new PlayVote();
                    $vote->type = 'upvote';
                    $vote->date = Server::getDate();
                    $vote->user_id = Auth::user()->id;
                    $vote->play_id = $play_id;
                    $vote->save();
                    
                    $play = Play::find($play_id);
                    $play->score = $play->score+1;
                    $play->positive = $play->positive+1;
                    $play->save();
                    return 'up';
                }
                else if($action=='down')
                {
                    $vote = new PlayVote();
                    $vote->type = 'downvote';
                    $vote->date = Server::getDate();
                    $vote->user_id = Auth::user()->id;
                    $vote->play_id = $play_id;
                    $vote->save();
                    
                    $play = Play::find($play_id);
                    $play->score = $play->score-1;
                    $play->negative = $play->negative+1;
                    $play->save();
                    return 'down';
                }
            }
            else
            {
                return 'failure';
            }
        }
    }
    
    // all plays
    public function plays()
    {
        $pagination = 12;
        
        if(Request::isMethod('GET'))
        {
            
            $date = Input::get('date');
            $sort = Input::get('sort');
            if($sort=='')
            {
                $sort = 'date';
            }
            if($date=='hour') {
                $time = date('Y-m-d H:i:s',(strtotime(Server::getDate())-(3600)));
            } elseif($date=='today') {
                $time = date('Y-m-d H:i:s',(strtotime(Server::getDate())-(86400*1)));
            } elseif($date=='week') {
                $time = date('Y-m-d H:i:s',(strtotime(Server::getDate())-(86400*7)));
            } elseif($date=='month') {
                $time = date('Y-m-d H:i:s',(strtotime(Server::getDate())-(86400*30)));
            } elseif($date=='year') {
                $time = date('Y-m-d H:i:s',(strtotime(Server::getDate())-(86400*365)));
            } else 
            {
                $time = date('Y-m-d H:i:s',(strtotime(Server::getDate())-(8640*36500)));
            }
           
            
            $plays = Play::where('date', '>', $time)
                    //->where('category_id', '=', '1')
                    //->orderBy('type', 'desc')
                    //->orderBy('score', 'desc')
                    //->limit('10')
                    ->where(function($nested)
                    {
                        $query = Input::get('q');
                        $nested->where('tags', 'LIKE', "%$query%")
                                ->orWhere('name', 'LIKE', "%$query%");
                    })
                    ->where(function($nested)
                    {
                        $champ = Input::get('champ');
                        if($champ!='')
                        {
                            $nested->where('champion', 'LIKE', "%$champ%");
                        }
                    })
                    ->orderBy($sort, 'desc')
                    ->where('type', '>=', '1')
                    ->where('active', '>=', '1')
                    ->with('user')
                    ->with('category')
                    ->with('comments')
                    ->paginate($pagination);
        }
        else
        {
            $time = date('Y-m-d H:i:s',(strtotime(Server::getDate())-(86400*30)));
            $plays = Play::where('date', '>', $time)
                    //->where('category_id', '=', '1')
                    //->orderBy('type', 'desc')
                    //->orderBy('score', 'desc')
                    //->limit('10')
                    ->orderBy('date', 'desc')
                    ->where('type', '>=', '0')
                    ->where('active', '>=', '1')
                    ->with('user')
                    ->with('category')
                    ->with('comments')
                    ->paginate($pagination);
        }
        
        $title = 'Plays';
        $categories = Category::all();
        
        return View::make('site.plays')->with(array(
            'title' => $title,
            'plays' => $plays,
            'categories' => $categories,
        ));
    }
    
    public function reportPlay($id)
    {
        if (Session::has("report$id")) 
        {
            return App::abort('401');
        }

        Session::put("report$id", true);

        $play = Play::find($id);
        $data = json_decode($play->data);
        $data->reports = $data->reports+1;
        $data_new = json_encode($data);
        
        if($data->reports>=10)
        {
            $play->active = 0;
        }
        
        $play->data = $data_new;
        
        $play->save();
        
        return Redirect::to('/'.$play->id)->with('message_success', 'Thank you for reporting!');
    }
}