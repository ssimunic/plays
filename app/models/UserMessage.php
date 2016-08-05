<?php

class UserMessage extends Eloquent
{
    public $table = 'user_messages';
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo('User');
    }
    
}