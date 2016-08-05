<?php

class AdminController extends BaseController
{
    public function showIndex()
    {
        $title = 'Dashboard';
        $playsall = Play::all();
        $users = User::all();
        $comments = PlayComments::all();
        $votes = PlayVote::all();
        
        $newplays = Play::where('date', '>', date('Y-m-d H:i:s', time()-86400))->get()->count();
        $waitingvalidation = Play::where('active', '=', 0)->get()->count();
        $newusers = User::where('registration_date', '>', date('Y-m-d H:i:s', time()-86400))->get()->count();
        $newpayments = Payment::where('date', '>', date('Y-m-d H:i:s', time()-86400))->get()->count();
        return View::make('admin.index', array(
            'title' => $title,  
            'playsall' => $playsall,
            'users' => $users,
            'comments' => $comments,
            'votes' => $votes,
            'newplays' => $newplays,
            'waitingvalidation' => $waitingvalidation,
            'newusers' => $newusers,
            'newpayments' => $newpayments
        ));
    }
    
    public function showPlays()
    {
        $title = 'Plays';
        
        if(Input::get('type')=='validation')
        {
            $plays = Play::where('id', '>=', '1')->orderBy('date', 'desc')
                    ->where('active', '=', '0')
                    ->where(function($nested)
                    {
                        $query = Input::get('q');
                        $nested->where('name', 'LIKE', "%$query%")
                                ->orWhere('tags', 'LIKE', "%$query%")
                                ->orWhere('user_id', 'LIKE', "%$query%");
                    })
                    ->paginate(20);
        }
        else
        {
            $plays = Play::where('id', '>=', '1')->orderBy('date', 'desc')
                    ->where(function($nested)
                    {
                        $query = Input::get('q');
                        $nested->where('name', 'LIKE', "%$query%")
                                ->orWhere('tags', 'LIKE', "%$query%")
                                ->orWhere('user_id', 'LIKE', "%$query%");
                    })
                    ->paginate(20);
        }
        
        
        return View::make('admin.plays', array(
            'title' => $title, 
            'plays' => $plays,
            'totalplays' => Play::all()->count(),
        ));
    }
    
    public function showUsers()
    {
        $title = 'Users';
        $users = User::where('id', '>=', '1')->orderBy('registration_date', 'desc')
                    ->where(function($nested)
                    {
                        $query = Input::get('q');
                        $nested->where('username', 'LIKE', "%$query%")
                                ->orWhere('display_name', 'LIKE', "%$query%")
                                ->orWhere('email', 'LIKE', "%$query%");
                    })
                    ->paginate(20);
        
        return View::make('admin.users', array(
            'title' => $title, 
            'users' => $users,
            'totalusers' => User::all()->count(),
        ));
    }
    
    public function showNews()
    {
        $title = 'News';
        $news = News::orderBy('date', 'desc')->where('id', '>=', '1')->get();
        
        return View::make('admin.news', array(
            'title' => $title,  
            'news' => $news,
        ));
    }
    
    public function showPayments()
    {
        $title = 'Payments';
        $payments = Payment::orderBy('date', 'desc')->where('id', '>=', '1')->paginate(10);

        return View::make('admin.payments', array(
            'title' => $title, 
            'payments' => $payments,
        ));
    }
    
    public function newNews()
    {
       
        $rules = array(
            'title' => 'required',
            'editor' => 'required',
        );
        
        $messages = array(
            'editor.required' => 'The text field is required.'
        );
        
        $validation = Validator::make(Input::all(), $rules, $messages);
        
        if($validation->passes())
        {
            $title = Input::get('title');
            $text = Input::get('editor');
            $publisher = Auth::user()->username;
            $date = Server::getDate();
            $active = 0;
            
            $new = new News();
            $new->title = $title;
            $new->text = $text;
            $new->date = $date;
            $new->publisher_name = $publisher;
            $new->active = $active;
            $new->save();
        }
        else
        {
            return Redirect::route('admin_news')->withErrors($validation);
        }
        
        return Redirect::route('admin_news')->with('message_success', 'Your post has been submitted.');
    }
    
    public function showSingleNews($id)
    {
        $new = News::find($id);
        $new->active = 1;
        $new->save();
        
        return Redirect::route('admin_news')->with('message_success', $new->title.' is now public.');
    }
    
    public function hideSingleNews($id)
    {
        $new = News::find($id);
        $new->active = 0;
        $new->save();
        
        return Redirect::route('admin_news')->with('message_success', $new->title.' is now hidden.');
    }
    
    public function deleteSingleNews($id)
    {
        $new = News::find($id);
        $new->delete();
        return Redirect::route('admin_news')->with('message_success', $new->title.' has been deleted.');
    }
    
    public function editSingleNews($id)
    {
        $new = News::find($id);

        return View::make('admin.editnews')->with(array(
            'title' => 'Edit news',
            'new' => $new,
        ));
    }
    
    public function saveSingleNews()
    {
        $rules = array(
            'title' => 'required',
            'editor' => 'required',
        );
        
        $messages = array(
            'editor.required' => 'The text field is required.'
        );
        
        $validation = Validator::make(Input::all(), $rules, $messages);
        
        if($validation->passes())
        {
            $id = Input::get('id');
            $title = Input::get('title');
            $text = Input::get('editor');
            
            $new = News::find($id);
            $new->title = $title;
            $new->text = $text;
            $new->save();
        }
        else
        {
            return Redirect::route('admin_news')->withErrors($validation);
        }
        
        return Redirect::route('admin_news')->with('message_success', 'Your post has been saved.');
    }
    
    public function giftUsers($id)
    {
        $user = User::find($id);
        
        if($user->user_type_id==1)
        {
            $time = date('Y-m-d H:i:s',time()+86400*30);

            $user->user_type_id = 2;
            $user->premium_till = $time;
            $user->save();
            
            $data_db = array(
                'title' => '<span class="glyphicon glyphicon-gift"></span> Gift!',
                'sender' => Auth::user()->username,
                'receiver' => $user->username,
            );
            
            $message = new UserMessage;
            $message->text = 'You have been granted <b>1 Month Premium Membership</b>. Enjoy!';
            $message->date = Server::getDate();
            $message->data = json_encode($data_db);
            $message->receiver = $id;
            $message->sender = Auth::user()->id;
            $message->save();
            
            return Redirect::route('admin_users')->with('message_success', $user->username.' has now Premium Membership.');
        }
    }
    
    public function banUsers($id)
    {
        $user = User::find($id);
        
        if($user->user_type_id<4)
        {
            $user->user_type_id = 0;
            $user->save();
            
            return Redirect::route('admin_users')->with('message_success', $user->username.' is now banned.');
        }
    }
    
    public function unbanUsers($id)
    {
        $user = User::find($id);
        
        if($user->user_type_id==0)
        {
            $user->user_type_id = 1;
            $user->save();
            
            return Redirect::route('admin_users')->with('message_success', $user->username.' is now unbanned.');
        }
    }
    
    public function editUsers($id)
    {
        $user = User::find($id);

        return View::make('admin.editusers')->with(array(
            'title' => 'Edit user',
            'user' => $user,
        ));
    }
    
    public function saveUsers()
    {
        $rules = array(
            'email' => 'required|email',
            'p_email' => 'required',
            'usertype' => 'required',
            'display_name' => 'required',
            'avatar' => 'required',
            'data' => 'required',
            'sdata' => 'required',
        );
        
        $messages = array(
            'p_email.required' => 'The payment email field is required.',
            'display_name.required' => 'The display name email field is required.',
            'sdata.required' => 'The summoner data field is required.'
        );
        
        $validation = Validator::make(Input::all(), $rules, $messages);
        
        if($validation->passes())
        {
            $id = Input::get('id');
            $email = Input::get('email');
            $p_email = Input::get('p_email');
            $usertype = Input::get('usertype');
            $display_name = Input::get('display_name');
            $avatar = Input::get('avatar');
            $data = Input::get('data');
            $sdata = Input::get('sdata');
            $premium_till = Input::get('premium_till');
            
            $user = User::find($id);
            $user->email = $email;
            $user->p_email = $p_email;
            $user->user_type_id = $usertype;
            $user->display_name = $display_name;
            $user->avatar = $avatar;
            $user->data = $data;
            $user->summoner_data = $sdata;
            $user->premium_till = $premium_till;
            $user->save();
        }
        else
        {
            return Redirect::route('admin_users')->withErrors($validation);
        }
        
        return Redirect::route('admin_users')->with('message_success', $user->username.' has been saved.');
        
    }
    
    public function deletePlays($id)
    {
        $play = Play::find($id);
        $play->type = 0;
        $play->save();
        
        return Redirect::route('admin_plays')->with('message_success', $play->name.' has been deleted.');
    }
    
    public function restorePlays($id)
    {
        $play = Play::find($id);
        $play->type = 1;
        $play->save();
        
        return Redirect::route('admin_plays')->with('message_success', $play->name.' has been restored.');
    }
    
    public function featurePlays($id)
    {
        $play = Play::find($id);
        $play->type = 2;
        $play->save();
        
        return Redirect::route('admin_plays')->with('message_success', $play->name.' has been featured.');
    }
    
    public function validatePlays($id)
    {
        $play = Play::find($id);
        $data = json_decode($play->data);
        $data->passedvalidation = true;
        $data->reports = 0;
        $data_new = json_encode($data);
        
        $play->data = $data_new;
        $play->active = 1;
        $play->save();
        
        return Redirect::route('admin_plays')->with('message_success', $play->name.' has been validated.');
    }
}