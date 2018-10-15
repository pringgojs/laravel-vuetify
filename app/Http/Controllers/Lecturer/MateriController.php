<?php

namespace App\Http\Controllers\Lecturer;

use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;

class MateriController extends Controller
{
    public function index()
    {
        $url = config('api.url').'/lecturer/materi';
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();

        return $response;
    }

    public function store(Request $request)
    {
        $file = FileHelper::upload($request->file('file'), 'uploads/materi/');
        $url = config('api.url').'/lecturer/materi/store';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray(), 'file' => $file);
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        return $response;
    }

    public function edit($id)
    {
        $url = config('api.url').'/lecturer/materi/edit/'.$id;
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        return $response;
    }

    public function update(Request $request, $id)
    {
        $file = FileHelper::upload($request->file('file'), 'uploads/materi/');
        $url = config('api.url').'/lecturer/materi/update/'.$id;
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray(), 'file' => $file);
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        return $response;
    }

    public function delete($id)
    {
        $url = config('api.url').'/lecturer/materi/delete/'.$id;
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
        $url = config('api.url').'/lecturer/materi/filter';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray());
        $response = Curl::to($url)
            ->withData($data)
            ->post();

        return $response;
    }
}
