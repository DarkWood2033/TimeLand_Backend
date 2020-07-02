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
        if(($sub_domain = explode('.', explode('/', url()->current())[2])[0]) !== 'soundrelax'){

            return $sub_domain;
        }

        return 'site';
    }
}
