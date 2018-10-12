<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Helpers\ResponseHelper;

class FilterController extends Controller
{
    public function getSemester()
    {
        $url = config('api.url').'/filter/get-semester';
        $response = Curl::to($url)->get();
        
        return $response;
    }

    public function getKelas($tahun, $semester)
    {
        $url = config('api.url').'/filter/get-kelas';
        $data = array('tahun' => $tahun, 'semester' => $semester);
        $response = Curl::to($url)->withData($data)->post();
        
        return $response;
    }

    public function getMatakuliah(Request $request)
    {
        $url = config('api.url').'/filter/get-matakuliah';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray());
        $response = Curl::to($url)->withData($data)->post();
        
        return $response;
    }

    public function getModul(Request $request)
    {
        $url = config('api.url').'/filter/get-modul';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray());
        $response = Curl::to($url)->withData($data)->post();
        return $response;
    }
}
