<?php

namespace App\Http\Controllers\Lecturer;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $url = config('api.url').'/lecturer/index';
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        
        $response = json_decode($response);
        $view = view('lecturer');
        $view->lecturer = $response->lecturer;
        $view->program_study = $response->program_study;
        
        return $view;
    }
}
