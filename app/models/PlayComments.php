<?php

class PlayComments extends Eloquent
{
    public $table = 'plays_comments';
    public $timestamps = false;
    
    public function play()
    {
        return $this->belongsTo('Play');
    }
    
    public function user()
    {
        return $this->belongsTo('User');
    }
}