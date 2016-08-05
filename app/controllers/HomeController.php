<?php

class HomeController extends BaseController 
{
    public function AI($user)
    {
        $xml = 'https://gdata.youtube.com/feeds/api/users/'.$user.'/uploads?&max-results=50';

        function Parse($url) 
        {
            $fileContents = file_get_contents($url);
            $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
            $fileContents = trim(str_replace('"', "'", $fileContents));
            $simpleXml = simplexml_load_string($fileContents);
            $json = json_encode($simpleXml);

            return $json;
        }

        $array = json_decode(Parse($xml));
        $c = '';
        foreach ($array->entry as $video) 
        {
            $link = $video->link[0];

            foreach ($link as $n) 
            {
                $records = Play::where('link', '=', $n->href)->get()->first();
               
                if(is_null($records))
                {
                    $active = 1;
                    $passedvalidation = 'true';

                    $data = array(
                        'comments' => true,
                        'passedvalidation' => $passedvalidation,
                        'reports' => 0,
                    );
                    $play = new Play();
                    $play->link = $n->href;
                    $play->name = $video->title;
                    $play->description = 'None';
                    $play->tags = $video->title;
                    $play->date = Server::getDate();
                    $play->user_id = rand(2, User::where('id', '>', '1')->count());
                    $play->category_id = 1;
                    $play->positive = 1;
                    $play->score = 1;
                    $play->active = $active;
                    $play->data = json_encode($data);
                    $play->champion = null;
                    $play->save();
                    
                    $c .= $video->title . " - " . $n->href . "<br>";
                }
            }
        }
        
        return "NEW ENTRIES:<br>".$c;
    }
    
    public function showIndex()
    {
        $title = 'Homepage';
        $time = date('Y-m-d H:i:s',(strtotime(Server::getDate())-(86400*1)));
        $plays = Play::where('date', '>', $time)
                //->where('category_id', '=', '1')
                ->orderBy('type', 'desc')
                ->orderBy('score', 'desc')
                ->limit('10')
                ->with('user')
                ->with('category')
                ->with('comments')
                ->paginate(10);
        
        $votes = array();
        if(Auth::user())
        {
            $votes = PlayVote::where('user_id', '=', Auth::user()->id)
                    //->where('date', '>', $time)
                    ->get();
        }
        return View::make('site.index')->with(array(
            'title' => $title,
            'plays' => $plays,
            'votes' => $votes,
        ));
    }
    public function paymentSuccess()
    {
        $title = 'Success!';
        return View::make('other.payment_success')->with(array(
                'title' => $title,
        ));
    }
    
    public function paymentCancel()
    {
        $title = 'Cancel';
        return View::make('other.payment_cancel')->with(array(
                'title' => $title,
        ));
    }
    
    public function showRegistration()
    {
        $title = 'Registration';
        return View::make('site.registration')->with(array(
                'title' => $title,
        ));
    }
    
    public function showLogin()
    {
        $title = 'Login';
        return View::make('site.login')->with(array(
                'title' => $title,
        ));
    }
    
    public function showFAQ()
    {
        $title = 'FAQ';
        return View::make('other.faq')->with(array(
                'title' => $title,
        ));
    }
    
    public function showAbout()
    {
        $title = 'About';
        return View::make('other.about')->with(array(
                'title' => $title,
        ));
    }
    
    public function showToS()
    {
        $title = 'Terms and Conditions';
        return View::make('other.tos')->with(array(
                'title' => $title,
        ));
    }
    
    public function showContact()
    {
        $title = 'Contact';
        return View::make('other.contact')->with(array(
                'title' => $title,
        ));
    }
    
    public function handleContact()
    {       
        $rules = array(
            'name' => 'required|between:3,180',
            'email' => 'required|email',
            'message' => 'required|between:10,2000',
        );
        
        $validation = Validator::make(Input::all(), $rules);
                
        if ($validation->passes()) 
        {
            $data = array(
                'name' => Input::get('name'),
                'email' => Input::get('email'),
                '_message' => Input::get('message'),
            );

            Mail::send('emails.contact', $data, function($message) {
                $message->replyTo(Input::get('email'), Input::get('name'));
                $message->to('admin@artikan.co', 'Artikan')->subject(Lop::webname . ' - Contact');
            });

            return Redirect::route('contact')->with('message', 'Your message has been delivered.');
        } 
        else 
        {
            return Redirect::route('contact')->withErrors($validation);
        }
    }
    
    public function showMyPlays()
    {
        $title = 'My Plays';
        return View::make('site.myplays')->with(array(
           'title' => $title, 
        ));
    }
    
    public function showManager($id=null)
    {
        
        if($id)
        {
            $data = Play::where('id', '=', $id)
                    ->with('user')
                    ->with('category')
                    ->with('votes')
                    ->get();   
            $play = $data[0];
            
            if($play->user_id == Auth::user()->id)
            {
                $title = $play->name;
                $categories = Category::all();
                               
                return View::make('site.manageplay')->with(array(
                    'title' => $title,
                    'play' => $play,
                    'categories' => $categories,
                ));
            }
            else
            {
                App::abort(401, 'You are not authorized.');
            }
            
        }
        else
        {
            $title = 'Manager';
            $plays = Play::where('user_id', '=', Auth::user()->id)
                        ->orderBy('date', 'desc')
                        ->with('user')
                        ->with('comments')        
                        ->get();

            return View::make('site.mymanager')->with(array(
               'title' => $title, 
               'plays' => $plays,
            ));
        }
    }
    
    public function showStats()
    {
        $title = 'Statistics';
        
        $time = date('Y-m-d H:i:s',(strtotime(Server::getDate())-(86400*30)));
        $plays = Play::where('date', '>', $time)
                ->where('user_id', '=', Auth::user()->id)
                ->limit('5')
                ->with('comments')
                ->get();
        
        $playsall = Play::where('date', '>', $time)
                    ->get();
        
        $playsallmy = Play::where('user_id', '=', Auth::user()->id)
                    ->with('comments')
                    ->get();
        
        return View::make('site.mystatistics')->with(array(
           'title' => $title, 
           'plays' => $plays,
           'playsall' => $playsall,
           'playsallmy' => $playsallmy,
        ));
    }
    
    public function showSubmit()
    {
        $title = 'Submit new play';
        $categories = Category::all();
        return View::make('site.submitplay', compact('categories'))->with(array(
           'title' => $title, 
        ));
    }
    
    public function showPremium()
    {
        $title = 'Premium';
        
        return View::make('site.premium')->with(array(
            'title' => $title,
        ));
    }
}
