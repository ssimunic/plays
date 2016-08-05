<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface 
{
    public static $rules = array(
        'username'  => 'required|alpha_num|min:3|unique:users',
        'password'  => 'required|between:6,18',
        'email'     => 'required|email|unique:users',
        'terms'     => 'required',
    );

    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier() 
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword() 
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail() 
    {
        return $this->email;
    }
    
    /**
     * Get user Profile required data.
     * 
     * @return string
     */
    
    public function getProfileData()
    {
        return array(
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'p_email' => $this->p_email,
            'user_type_id' => $this->user_type_id,
            'display_name' => $this->display_name,
            'avatar' => $this->avatar,
        );
    }
    
    /*
     * User plays
     */
    public function play()
    {
        return $this->hasMany('Play');
    }
    public function play_latest()
    {
        return $this->hasMany('Play')
                ->orderBy('date', 'desc');
    }
    
    //votes
    public function votes()
    {
        return $this->hasMany('PlayVote');
    }
    public function votes_latest()
    {
        return $this->hasMany('PlayVote')
                    ->orderBy('date', 'desc');
    }
    
    //comms
    public function comments()
    {
        return $this->hasMany('PlayComments');
    }
    public function comments_latest()
    {
        return $this->hasMany('PlayComments')
                ->orderBy('date', 'desc');
    }
    
    //msgs
    public function messages()
    {
        return $this->hasMany('UserMessage');
    }
    public function messages_latest()
    {
        return $this->hasMany('UserMessage')
                ->orderBy('date', 'desc');
    }
}
