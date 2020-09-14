<?php

namespace App\Exceptions\User;

use Exception;

class NotFoundUserException extends Exception
{
    public static function byId($id)
    {
        return new NotFoundUserException(trans('exception.user.not_found.byId', ['id' => $id]));
    }

    public static function byEmail($email)
    {
        return new NotFoundUserException(trans('exception.user.not_found.byEmail', ['email' => $email]));
    }
}
