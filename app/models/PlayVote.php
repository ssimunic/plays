<?php

class PlayVote extends Eloquent
{
    public $table = 'plays_votes';
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo('User');
    }
    
    public function play()
    {
        return $this->belongsTo('Play');
    }
}