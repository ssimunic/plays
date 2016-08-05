<?php

class HofController extends BaseController
{
    public function showIndex()
    {
        $title = 'Hall of Fame';
        
        return View::make('hof.index', array(
            'title' => $title,
        ));
    }
}