<?php

class ApiKey extends Eloquent
{
    public $table = 'api_keys';
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo('User');
    }
}