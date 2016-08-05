<?php

class Play extends Eloquent
{
    public static $val_rules = array(
        'link' => 'required|youtubevideo',
        'name' => 'required|min:3|max:100',
        'description' => 'required|max:2000',
        'category' => 'required|numeric',
        'tags' => 'required|min:3',
    );
    
    public $table = 'plays';
    public $timestamps = false;
    

    public function user()
    {
        return $this->belongsTo('User');
    }
    
    public function category()
    {
        return $this->belongsTo('Category');
    }
    
    public function comments()
    {
        return $this->hasMany('PlayComments');
    }
    
    public function votes()
    {
        return $this->hasMany('PlayVote');
    }
}