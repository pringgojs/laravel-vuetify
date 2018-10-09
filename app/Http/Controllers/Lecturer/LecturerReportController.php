<?php

namespace App\Http\Controllers\Lecturer;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Helpers\DatabaseHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;

class LecturerReportController extends Controller
{
    public function nilaiPermodul()
    {
        $url = config('api.url').'/lecturer/report/nilai-permodul';
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
        ->withData($data)
        ->post();

        return $response;
    }

    public function kuliah($id)
    {
        $url = config('api.url').'/lecturer/report/nilai-permodul/kuliah';
        $data = array('user' => ResponseHelper::user(), 'kuliah' => $id);
        $response = Curl::to($url)
        ->withData($data)
        ->post();

        return $response;
    }

}
