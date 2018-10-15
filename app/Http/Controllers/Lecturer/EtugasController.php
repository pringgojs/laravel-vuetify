<?php

namespace App\Http\Controllers\Lecturer;

use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;

class EtugasController extends Controller
{
    public function index()
    {
        $url = config('api.url').'/lecturer/e-tugas';
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();

        return $response;
    }

    public function edit($id)
    {
        $url = config('api.url').'/lecturer/e-tugas/edit/'.$id;
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        return $response;
    }

    public function store(Request $request)
    {
        $file = FileHelper::upload($request->file('file'), 'uploads/e-tugas/');
        $url = config('api.url').'/lecturer/e-tugas/store';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray(), 'file' => $file);
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        return $response;
    }

    public function update(Request $request, $id)
    {
        $file = FileHelper::upload($request->file('file'), 'uploads/e-tugas/');
        $url = config('api.url').'/lecturer/e-tugas/update/'.$id;
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray(), 'file' => $file);
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        return $response;
    }

    public function delete($id)
    {
        $url = config('api.url').'/lecturer/e-tugas/delete/'.$id;
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();

        $response = json_decode($response);
        if (file_exists($response->url)) {
            try {
                \File::delete($response->url);
            } catch (\Exception $e) {
            }
        }
        return 1;
    }

    public function filter(Request $request)
    {
        $url = config('api.url').'/lecturer/e-tugas/filter';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray());
        $response = Curl::to($url)
            ->withData($data)
            ->post();

        return $response;
    }

    public function detail($id)
    {
        $url = config('api.url').'/lecturer/e-tugas/detail/'.$id;
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        return $response;
    }

    public function setNilai(Request $request)
    {
        $url = config('api.url').'/lecturer/e-tugas/set-nilai';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        return $response;
    }
}
