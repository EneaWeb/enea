<?php

namespace App;
use Session;

class Alert
{

    //protected $message;
    //protected $type;

    public static function error($message)
    {
        $type = 'error';
        Alert::send($type, $message);
    }
    
    public static function success($message)
    {
        $type = 'success';
        Alert::send($type, $message);
    }
    
    public static function message($message)
    {
        $type = 'message';
        Alert::send($type, $message);
    }
    
    public static function send($type, $message)
    {
        $type_name = 'alert_'.$type;
        Session::put($type_name, $message);
    }

}
