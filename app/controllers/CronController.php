<?php

class CronController extends BaseController
{
    // run this every minute
    public function premium()
    {
        $time = date('Y-m-d H:i:s',(strtotime(Server::getDate())));
        User::where('premium_till', '<', $time)->where('user_type_id', '=', '2')->update(array('user_type_id' => 1));
    }
}