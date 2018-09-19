<?php

namespace App\Helpers;

use Ixudra\Curl\Facades\Curl;
use App\Helpers\ResponseHelper;

class StudentDatabaseHelper
{
    public static function getScheduleIndex()
    {
        $url = config('api.url').'/student/schedule';
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
        ->withData($data)
        ->post();
        
        return $response;
    }

    public static function getScheduleBySemester($kuliah)
    {
        $url = config('api.url').'/student/schedule/get-by-semester/'.$kuliah;
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
        ->withData($data)
        ->post();
        
        return $response;
    }

}