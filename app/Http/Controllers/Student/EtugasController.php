<?php

namespace App\Http\Controllers\Student;

use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;

class EtugasController extends Controller
{
    public function index()
    {
        $url = config('api.url').'/student/etugas';
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        
        return $response;
    }

    public function detail($id)
    {
        $url = config('api.url').'/student/etugas/detail/'.$id;
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        
        return $response;
    }

    public function store(Request $request)
    {
        $file = FileHelper::upload($request->file('file'), 'uploads/tugas-mahasiswa/');

        $url = config('api.url').'/student/etugas/store';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray(), 'file' => $file);
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        
        return $response;
    }

    public function filter(Request $request)
    {
        $url = config('api.url').'/student/etugas/filter';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        
        return $response;
    }
}
