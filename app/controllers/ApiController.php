<?php

class ApiController extends BaseController
{
    public function showIndex()
    {
        $title = 'API';
        
        if(!Auth::user())
        {
            App::abort('401');
        }
        $data = ApiKey::where('user_id', '=', Auth::user()->id)
                ->get();
        
        return View::make('other.api', array(
            'title' => $title,
            'data' => $data,
        ));
    }
    
    public function playslatest($key)
    {
        $key = ApiKey::where('key', '=', $key)->get();
        
        if(!$key->isEmpty())
        {
            $time = date('Y-m-d H:i:s',(strtotime(Server::getDate())-(86400*3)));
            $plays = Play::where('date', '>', $time)
                    ->orderBy('type', 'desc')
                    ->orderBy('score', 'desc')
                    ->limit('10')
                    ->with('category')
                    ->get();
            return Response::json($plays);
        }
        else 
        {
            return Response::json(array('response' => 'Invalid auth key.'));
        }
    }
    
    public function play($key, $id)
    {
        $key = ApiKey::where('key', '=', $key)->get();
        
        if(!$key->isEmpty())
        {
            $play = Play::find($id);
            return Response::json($play);
        }
        else 
        {
            return Response::json(array('response' => 'Invalid auth key.'));
        }
    }
    
    public function user($key, $id)
    {
        $key = ApiKey::where('key', '=', $key)->get();
        
        if(!$key->isEmpty())
        {
            $user = User::where('id', '=', $id)
                    ->select('id', 'username', 'user_type_id', 'display_name', 'registration_date', 'avatar')
                    ->get();
            return Response::json($user);
        }
        else 
        {
            return Response::json(array('response' => 'Invalid auth key.'));
        }
    }
    
    public function authorize()
    {
        $key = ApiKey::where('key', '=', Input::get('key'))->get();
        
        if(!$key->isEmpty())
        {
            $auth = Auth::attempt(array(
                'username' => Input::get('username'),
                'password' => Input::get('password'), 
            ));

            if($auth)
            {
                return Response::json(array('response' => 'valid'));
            }
            else
            {
                return Response::json(array('response' => 'invalid'));
            }
        }
        else 
        {
            return Response::json(array('response' => 'Invalid auth key.'));
        }
    }
}

