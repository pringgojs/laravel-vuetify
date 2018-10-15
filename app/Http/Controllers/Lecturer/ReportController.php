<?php

namespace App\Http\Controllers\Lecturer;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Helpers\DatabaseHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;

class ReportController extends Controller
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

    public function filter(Request $request)
    {
        $url = config('api.url').'/lecturer/report/nilai-permodul/filter';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray());
        $response = Curl::to($url)
            ->withData($data)
            ->post();

        return $response;
    }

    public function detailModul($id_modul)
    {
        $url = config('api.url').'/lecturer/report/nilai-permodul/detail';
        $data = array('user' => ResponseHelper::user(), 'id_modul' => $id_modul);
        $response = Curl::to($url)
            ->withData($data)
            ->post();

        return $response;
    }

    public function sync($id_modul)
    {
        $url = config('api.url').'/lecturer/report/nilai-permodul/sync';
        $data = array('user' => ResponseHelper::user(), 'id_modul' => $id_modul);
        $response = Curl::to($url)
            ->withData($data)
            ->post();

        return $response;
    }

}
