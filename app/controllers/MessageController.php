<?php

class MessageController extends BaseController
{
    public function showIndex()
    {
        $title = 'Messages';
        $messages = UserMessage::where('receiver', '=', Auth::user()->id)
                            //->orWhere('sender', '=', Auth::user()->id)
                            ->orderBy('date', 'desc')
                            ->get();
        return View::make('messages.index')->with(array(
                'title' => $title,
                'messages' => $messages,
        ));
    }

    public function showRead($id)
    {
        $message = UserMessage::find($id);
        $data = json_decode($message->data);
        if($message->receiver == Auth::user()->id || $message->sender == Auth::user()->id)
        {
            if($message->read=='0')
            {
                $message->read = '1';
                $message->save();
                
            }
            return View::make('messages.read')->with(array(
                'title' => $data->title,
                'message' => $message,
            ));
        }
        else
        {
            return App::abort('401');
        }
    }
    
    public function showSend($id=null, $mtitle=null)
    {
        $title = 'Compose';
        if(is_numeric($id))
        {
            $user = User::find($id);
            return View::make('messages.new')->with(array(
                    'title' => $title,
                    'user' => $user,
                    'mtitle' => $mtitle,
            ));
        }
        else
        {
            return View::make('messages.new')->with(array(
                    'title' => $title,
                    'user' => array(),
                    'mtitle' => $mtitle,
            ));
        }
    }
    
    public function send()
    {
        if(Input::get('message')=='')
        {
            return Redirect::to('/messages/new')->with('message_fail', 'You can\'t send blank message.'); 
        }
        if(Input::get('title')=='')
        {
            return Redirect::to('/messages/new')->with('message_fail', 'You must enter title.'); 
        }
        
        $receiver_input = Input::get('receiver');
        $data = User::where('username', '=', $receiver_input)
                ->get();
        
        $receiver_c = User::where('username', '=', $receiver_input)->get()->toArray();
        $hisdata = json_decode($receiver_c[0]['data'], true);
        $ignorelist = $hisdata['ignorelist'];
        
        if(in_array(Auth::user()->username, $ignorelist))
        {
            return Redirect::to('/messages/new')->with('message_fail', 'This user ignores you.');
        }
        
        if(!$data->isEmpty())
        {
            $data_db = array(
                'title' => Input::get('title'),
                'sender' => Auth::user()->username,
                'receiver' => Input::get('receiver'),
            );
            
            $message = new UserMessage;
            $message->text = Input::get('message');
            $message->date = Server::getDate();
            $message->data = json_encode($data_db);
            $message->receiver = $data[0]->id;
            $message->sender = Auth::user()->id;
            $message->save();
            
            return Redirect::to('/messages/new')->with('message_success', 'Your message has been sent.');
        }
        else
        {
            return Redirect::to('/messages/new')->with('message_fail', 'Receiver doesn\'t exist.');
        }
    }
    
    public function emptyall()
    {
        UserMessage::where('receiver', '=', Auth::user()->id)->delete();
        return Redirect::to('/messages');
    }
    
    public function delete($id)
    {
        $message = UserMessage::find($id);
        if($message->receiver == Auth::user()->id)
        {
            $message->delete();
            return Redirect::to('/messages');
        }
        else
        {
            return App::abort('401');
        }
    }
    public function markasread($id)
    {
        $message = UserMessage::find($id);
        if($message->receiver == Auth::user()->id)
        {
            $message->read = '1';
            $message->save();
            return Redirect::to('/messages');
        }
        else
        {
            return App::abort('401');
        }
    }
}