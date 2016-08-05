<?php

class UserController extends BaseController 
{
    public function handleRegistration()
    {
        $messages = array(
            'terms.required' => 'Please agree to Terms and Conditions',
        );
        
        $validation = Validator::make(Input::all(), User::$rules, $messages);
        
        if($validation->passes())
        {
            $summoner_data = array(
                'last_request' => array(),
                'summoners' => array(),
            );
            
            $data = array(
                'theme' => Lop::default_theme,
                'votehistory' => false,
                'medals' => array(),
                'ignorelist' => array(),
            );
            
            $user = new User;
            $user->username = Input::get('username');
            $user->password = Hash::make(Input::get('password'));
            $user->email = Input::get('email');
            $user->last_ip = Server::getClientIP();
            $user->registration_date = Server::getDate();
            $user->data = json_encode($data);
            $user->summoner_data = json_encode($summoner_data);
            $user->save();
            
            return Redirect::route('log')->with('message', 'Thanks for registering. You can login now.');
        }
        else
        {
            return Redirect::route('reg')->with('message', 'The following errors occurred:')->withErrors($validation);
        }

    }
    
    public function handleLogin()
    {
        if(Input::get('remember')) {
            $remember = true;
        } else {
            $remember = false;
        }
        
        $auth = Auth::attempt(array(
            'username' => Input::get('username'),
            'password' => Input::get('password'), 
        ), $remember);
        
        if($auth)
        {
            $user = User::find(Auth::user()->id);
            $user->last_login = Server::getDate();
            $user->last_ip = Server::getClientIP();
            $user->save();
            
            return Redirect::route('index');
        }
        else
        {
            return Redirect::route('log')->with(array(
               'message_error' => 'Your username or password combination was incorrect.',
            ));
        }
    }
    
    public function Logout()
    {
        Auth::logout();
        return Redirect::route('log')->with('message', 'You have been logged out.');
    }
    
    // PROFILE
    public function Profile($profile=null)
    {
        $user = new User;

        if(!$profile)
        {
            $collection = $user->where('id', '=', Auth::user()->id)
                            ->with('comments_latest')
                            ->with('play_latest')
                            ->with('votes_latest')
                            ->get();
            
            $user = $collection[0];
        }
        elseif(is_numeric($profile))
        {
            $collection = $user->where('id', '=', $profile)
                            ->with('comments_latest')
                            ->with('play_latest')
                            ->with('votes_latest')
                            ->get();
            
            $user = $collection[0];
        }
        else 
        {
            $collection = $user->where('username', '=', $profile)
                            ->with('comments_latest')
                            ->with('play_latest')
                            ->with('votes_latest')
                            ->get();
            
            $user = $collection[0];
        }
        
        $title = 'Profile';
        return View::make('site.profile')->with(array(
            'title' => $title,
            'user' => $user,
        ));
    }
    
    // change avatar
    public function changeAvatar()
    {
        $avatar = Input::get('avatar');
        
        if($avatar)
        {
            if(Auth::user())
            {
                $user = User::find(Auth::user()->id);
                $user->avatar = $avatar;
                $user->save();

                return Redirect::to('/profile');
            }
        }
    }
    // ACCOUNT
    public function Account()
    {
        $user = User::find(Auth::user()->id);
        $title = 'Account';
        return View::make('site.account')->with(array(
            'title' => $title,
            'user' => $user,
        ));
    }
    
    // change display name
    public function changeDisplayName()
    {
        if(Input::get('save', true))
        {
            if(Auth::user())
                {
                    $user = User::find(Auth::user()->id);
                    $user->display_name = 'Undefined';
                    $user->save();

                    return Redirect::to('/account')->with('message_success', 'Your display name has been removed.');
                }
        }
        
        $rules = array(
            'displayname' => 'required|between:3,16', 
        );
        
        $validation = Validator::make(Input::all(), $rules);
        
        if($validation->passes())
        {
            $dn = Input::get('displayname');
            if($dn)
            {
                if(Auth::user() && Auth::user()->user_type_id>=2)
                {
                    $user = User::find(Auth::user()->id);
                    $user->display_name = $dn;
                    $user->save();

                    return Redirect::to('/account')->with('message_success', 'Your display name has been changed.');
                }
            }
        }
        else
        {
                return Redirect::to('/account')->withErrors($validation);
        }
    }
    
    // change display name
    public function votehistory()
    {
        if(Input::get('show', true))
        {
            if(Auth::user())
            {
                $user = User::find(Auth::user()->id);
                $data = json_decode($user->data);
                $data->votehistory = false;
                
                $user->data = json_encode($data);
                $user->save();
                
                return Redirect::to('/account')->with('message_success', 'Your vote history will be <b>hidden</b> to everyone now.');
            }
        }
        elseif(Input::get('hide', true))
        {
            $user = User::find(Auth::user()->id);
                $data = json_decode($user->data);
                $data->votehistory = true;
                
                $user->data = json_encode($data);
                $user->save();
                
                return Redirect::to('/account')->with('message_success', 'Your vote history will be <b>visible</b> from everyone now.');
        }
    }
    
    public function ignore()
    {
        $rules = array(
            'username' => 'required', 
        );
        
        $validation = Validator::make(Input::all(), $rules);
        
        if($validation->passes())
        {
            if(Auth::user())
            {
                $username = Input::get('username');
                $username = str_replace(' ', '', $username);
                
                $validusernames = User::where('username', '=', $username)->get();
                if($validusernames->isEmpty())
                {
                    return Redirect::to('/account')->with('message_fail', 'Invalid username.');
                }
                else
                {
                    $user = User::find(Auth::user()->id)->toArray();

                    $data = json_decode($user['data'], true);
                    $ignorelist = $data['ignorelist'];
                    
                 
                    
                    if(in_array($username, $ignorelist))
                    {
                        return Redirect::to('/account')->with('message_fail', 'This user is already on your ignore list.');
                    }
                    else
                    {
                        array_push($ignorelist, $username);
                        $data['ignorelist'] = $ignorelist;

                        $usern = User::find(Auth::user()->id);
                        $usern->data = json_encode($data);

                        $usern->save();

                        return Redirect::to('/account')->with('message_success', $username. ' has been added to your ignore list.');
                    }
                }
            }
        }
        else
        {
            return Redirect::to('/account')->withErrors($validation);
        }
    }
    
    public function removeignore($username)
    {
        if(Auth::user())
        {
            $user = User::find(Auth::user()->id)->toArray();
            
            $data = $user['data'];
            $array = json_decode($data, true);
            $ignorelist = $array['ignorelist'];
            
            if(($key = array_search($username, $ignorelist)) !== false) 
            {
                unset($ignorelist[$key]);
            }
            
            $array['ignorelist'] = $ignorelist;
           
            $encoded = json_encode($array);
            
            $usern = User::find(Auth::user()->id);
            $usern->data = $encoded;
            $usern->save();
            
            return Redirect::to('/account')->with('message_success', $username. ' has been removed from your ignore list.');
        }
    }
    
    public function changepassword()
    {
        $rules = array(
            'current' => 'required',
            'new'  => 'required|between:6,18|confirmed',
            'new_confirmation' => 'required|between:6,18',
        );
        
        $validation = Validator::make(Input::all(), $rules);
        
        if($validation->passes())
        {
            if(Auth::user())
            {
                $check = Auth::attempt(array(
                    'username' => Auth::user()->username,
                    'password' => Input::get('current'),
                ));
                if($check)
                {
                    $user = User::find(Auth::user()->id);
                    $user->password = Hash::make(Input::get('new'));
                    $user->save();
                    
                    return Redirect::to('/account')->with('message_success', 'Your password has been changed.');
                }
                else
                {
                    return Redirect::to('/account')->with('message_fail', 'Incorrect current password.');
                }
            }
        }
        else
        {
            return Redirect::to('/account')->withErrors($validation);
        }
    }
    
    public function verifysummoner()
    {
        $rules = array(
            'sname' => 'required',
            'region' => 'required',
        );
        
        $messages = array(
            'sname.required' => 'Summoner name is required',
        );
        
        $validation = Validator::make(Input::all(), $rules, $messages);
        
        if($validation->passes())
        {
            $me = User::find(Auth::user()->id);
            $me_sdata = json_decode($me->summoner_data);

            $sname = Input::get('sname');
            $region = Input::get('region');
            $cleanname = str_replace(' ', '', $sname);

            $api = new RiotAPI($region);
            
            $basic = json_decode($api->getSummonerByName($cleanname), true);
            $summoner_id = $basic['id'];
            $icon = $basic['profileIconId'];
            $level = $basic['summonerLevel'];
            
            $runes = $api->getSummoner($summoner_id, 'runes');
            
            if (strpos($runes, Session::get('code')) !== false) 
            {
                $user = User::find(Auth::user()->id)->toArray();

                $data = json_decode($user['summoner_data'], true);
                $summoners = $data['summoners'];
                $last_request = $data['last_request'];
                $last_request[0] = Server::getDate();
                
                foreach($summoners as $array)
                {              
                    if (array_key_exists($sname, $array))
                    {
                        return Redirect::to('/account')->with('message_fail', 'This summoner is already verified.');
                    }   
                }
                $season = 'SEASON4';
                $sstats = json_decode($api->getStats($summoner_id, 'summary?season='.$season), true);
                $statsummary = $sstats['playerStatSummaries'];
                
                foreach($statsummary as $stat)
                {
                    if($stat['playerStatSummaryType']=='RankedSolo5x5')
                    {
                        $total = $stat['wins']+$stat['losses'];
                    }
                }
                
                if($total<10)
                {
                    $league = 'Unknown';
                    $rank = 0;
                }
                else
                {
                    $leaguedata = json_decode($api->getLeague($summoner_id), true);
                    $smx = $leaguedata[$summoner_id];
                    $league = ucfirst(strtolower($smx['tier']));
                    $entries = $smx['entries'];
                    foreach($entries as $entry)
                    {
                        if($entry['playerOrTeamId']==$summoner_id)
                        {
                            $rank = Lop::toArabic($entry['rank']);
                        }
                    }
                }
                

                $summoner = array(
                    $basic['name'] => array(
                        'summonerid' => $summoner_id,
                        'league' => $league,
                        'rank' => $rank,
                        'region' => $region,
                        'iconid' => $icon,
                        'level' => $level,
                        'date' => Server::getDate(),
                        'active' => true,
                    ),
                );

                array_push($summoners, $summoner);
                $data['summoners'] = $summoners;
                $data['last_request'] = $last_request;

                //return json_encode($summoners);
                $usern = User::find(Auth::user()->id);
                $usern->summoner_data = json_encode($data);

                $usern->save();
                Session::forget('code');
                return Redirect::to('/account')->with('message_success', $sname . ' has been verified as your summoner!');
            }
            else
            {
                return Redirect::to('/account')->with('message_fail', 'Seems like you haven\'t changed any rune page name to required code.');
            }
            
        }
        else
        {
            return Redirect::to('/account')->withErrors($validation);
        }
    }
    
    public function removesummoner($sname)
    {
        if(Auth::user())
        {
            /*
            $sname = base64_decode($sname);
            
            $user = User::find(Auth::user()->id)->toArray();
            
            $data = $user['summoner_data'];
            $array = json_decode($data, true);
            $summoners = $array['summoners'];
            

            $array['summoners'] = $sn;

            $encoded = json_encode($array);
            
            $usern = User::find(Auth::user()->id);
            $usern->summoner_data = $encoded;
            $usern->save();
            
            return Redirect::to('/account')->with('message_success', 'Summoner '.$sname. ' has been removed from your acoount.');
            
             
            */
        }
    }
}

