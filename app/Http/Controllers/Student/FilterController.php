<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;

class FilterController extends Controller
{
    public function getSemester($type)
    {
        $url = config('api.url').'/filter/student/get-semester/'.$type;
        $response = Curl::to($url)->get();
        
        return $response;
    }

    public function getKelas($type, $tahun, $semester)
    {
        $url = config('api.url').'/filter/student/get-kelas';
        $data = array('user' => ResponseHelper::user(), 'type' => $type, 'tahun' => $tahun, 'semester' => $semester);
        $response = Curl::to($url)->withData($data)->post();
        
        return $response;
    }

    public function getMatakuliah(Request $request)
    {
        $url = config('api.url').'/filter/student/get-matakuliah';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray());
        $response = Curl::to($url)->withData($data)->post();
        
        return $response;
    }

    public function getModul(Request $request)
    {
        $url = config('api.url').'/filter/student/get-modul';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray());
        $response = Curl::to($url)->withData($data)->post();
        return $response;
    }
}
