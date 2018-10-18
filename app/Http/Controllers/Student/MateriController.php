<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;

class MateriController extends Controller
{
    public static function index()
    {
        $url = config('api.url').'/student/materi';
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        
        return $response;
    }

    public function filter(Request $request)
    {
        $url = config('api.url').'/student/materi/filter';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
            
        return $response;
    }
}
