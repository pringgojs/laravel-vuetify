<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public static function index()
    {
        return $view = view('student');
    }

    public function dashboard()
    {
        $url = config('api.url').'/student/dashboard';
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        
        return $response;
    }
}
