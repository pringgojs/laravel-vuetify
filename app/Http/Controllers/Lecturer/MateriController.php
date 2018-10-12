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

    public function delete($id)
    {
        $url = config('api.url').'/lecturer/materi/delete/'.$id;
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        
        return json_decode($response);
        if (file_exists($database->url)) {
            try {
                \File::delete($database->url);
            } catch (\Exception $e) {
            }
        }
        return 1;
    }

    public function getByKuliahMateri($kuliah)
    {
        $url = config('api.url').'/lecturer/materi/get-by-kuliah';
        $data = array('user' => ResponseHelper::user(), 'kuliah' => $kuliah);
        $response = Curl::to($url)
        ->withData($data)
        ->post();

        return $response;
    }
}
