<?php

namespace App\Helpers;

use Ixudra\Curl\Facades\Curl;
use App\Helpers\ResponseHelper;

class DatabaseHelper
{
    /**
     * LECTURER
     */
    public static function getLecturerIndex()
    {
        $url = config('api.url').'/lecturer/index';
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
        ->withData($data)
        ->post();
        
        return json_decode($response);
    }
    
    public static function getScheduleIndex()
    {
        $url = config('api.url').'/lecturer/schedule';
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
        ->withData($data)
        ->post();
        
        return $response;
    }

    public static function getScheduleBySemester($kuliah)
    {
        $url = config('api.url').'/lecturer/schedule/get-by-semester/'.$kuliah;
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
        ->withData($data)
        ->post();
        
        return $response;
    }
}