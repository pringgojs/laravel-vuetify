<?php

namespace App\Http\Controllers\Lecturer;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;

class FilterController extends Controller
{
    public function getSemester()
    {
        $url = config('api.url').'/filter/lecturer/get-semester';
        $response = Curl::to($url)->get();
        
        return $response;
    }

    public function getKelas($tahun, $semester)
    {
        $url = config('api.url').'/filter/lecturer/get-kelas';
        $data = array('tahun' => $tahun, 'semester' => $semester);
        $response = Curl::to($url)->withData($data)->post();
        
        return $response;
    }

    public function getMatakuliah(Request $request)
    {
        $url = config('api.url').'/filter/lecturer/get-matakuliah';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray());
        $response = Curl::to($url)->withData($data)->post();
        
        return $response;
    }

    public function getMatakuliahStudent(Request $request)
    {
        $url = config('api.url').'/filter/lecturer/get-matakuliah/student';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray());
        $response = Curl::to($url)->withData($data)->post();
        
        return $response;
    }

    public function getModul(Request $request)
    {
        $url = config('api.url').'/filter/lecturer/get-modul';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray());
        $response = Curl::to($url)->withData($data)->post();
        return $response;
    }
}
