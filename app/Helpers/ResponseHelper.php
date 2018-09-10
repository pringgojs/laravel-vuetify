<?php

namespace App\Helpers;

use Ixudra\Curl\Facades\Curl;

class ResponseHelper
{
    public static function user()
    {
        return [
            'type' => session('type'),
            'username' => session('username'),
            'name' => session('name'),
            'id' => session('id'),
        ];
    }
}