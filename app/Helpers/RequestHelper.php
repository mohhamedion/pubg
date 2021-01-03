<?php

namespace App\Helpers;

use Request;

class RequestHelper
{
    public static function isApiRequest(): bool
    {
        if (is_null(Request::route())) {
            return false;
        }

        $middlewares = Request::route()->middleware();

        return in_array('api', $middlewares);
    }
}
