<?php

namespace App\Helpers;

use Ixudra\Curl\Facades\Curl;

class ResponseHelper
{
    public static function user()
    {
        $header = \Request::header('user');
        $header = json_decode($header);
        if ($header) {
            return [
                'type' => $header->type,
                'username' => $header->username,
                'name' => $header->name,
                'id' => $header->id,
            ];
        }

        return [
            'type' => session('type'),
            'username' => session('username'),
            'name' => session('name'),
            'id' => session('id'),
        ]; 
    }
}