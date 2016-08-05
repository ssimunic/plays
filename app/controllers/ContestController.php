<?php

class ContestController extends BaseController
{
    public function showIndex()
    {
        $title = 'Contests';
        return View::make('contests.index', array(
            'title' => $title,
        ));
    }
}