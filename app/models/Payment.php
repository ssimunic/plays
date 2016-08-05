<?php

class Payment extends Eloquent
{
    public $table = 'payments';
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo('User');
    }
}