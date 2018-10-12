<?php

namespace App\Http\Controllers\Lecturer;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    public static function index()
    {
        $url = config('api.url').'/lecturer/schedule';
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        
        return $response;
    }

    public static function getBySemester($kuliah)
    {
        $url = config('api.url').'/lecturer/schedule/get-by-semester/'.$kuliah;
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
        ->withData($data)
        ->post();
        
        return $response;
    }
}
