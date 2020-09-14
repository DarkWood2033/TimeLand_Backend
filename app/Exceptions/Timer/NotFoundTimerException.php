<?php

namespace App\Exceptions\Timer;

use Exception;

class NotFoundTimerException extends Exception
{
    public static function byId($id)
    {
        return new NotFoundTimerException(trans('exception.timer.not_found.byId', ['id' => $id]));
    }
}
