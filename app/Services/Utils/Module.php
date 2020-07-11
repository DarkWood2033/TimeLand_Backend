<?php

namespace App\Services\Utils;

class Module
{
    public static function check($env)
    {
        if(self::get() === $env){

            return true;
        }

        return false;
    }

    public static function get()
    {
        return 'site';
    }
}
