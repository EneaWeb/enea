<?php

namespace App;
use Session;

/*
|--------------------------------------------------------------------------
|   Notification
|--------------------------------------------------------------------------
|
| calls toastr notifications
|
*/

class Alert
{
    protected $name;
    protected $value;

    private function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    private function run()
    {
        Session::put('_notification.name', $this->name);
        Session::put('_notification.value', $this->value);
    }

    public static function info($value)
    {
        $a = new self('info', $value);
        $a->run();
    }

    public static function success($value)
    {
        $a = new self('success', $value);
        $a->run();
    }

    public static function warning($value)
    {
        $a = new self('warning', $value);
        $a->run();
    }

    public static function error($value)
    {
        $a = new self('error', $value);
        $a->run();
    }

}