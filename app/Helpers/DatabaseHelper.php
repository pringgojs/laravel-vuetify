<?php

namespace App\Helpers;

use Ixudra\Curl\Facades\Curl;
use App\Helpers\ResponseHelper;

class DatabaseHelper
{
    /**
     * LECTURER
     */
    public static function getLecturerIndex()
    {
        $url = config('api.url').'/lecturer/index';
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
        ->withData($data)
        ->post();
        
        return json_decode($response);
    }
    
    public static function getScheduleIndex()
    {
        $url = config('api.url').'/lecturer/schedule';
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
        ->withData($data)
        ->post();
        
        return $response;
    }

    public static function getScheduleBySemester($kuliah)
    {
        $url = config('api.url').'/lecturer/schedule/get-by-semester/'.$kuliah;
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
        ->withData($data)
        ->post();
        
        return $response;
    }

    // Materi
    public static function indexMateri()
    {
        $url = config('api.url').'/lecturer/materi';
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
        ->withData($data)
        ->post();

        return $response;
    }

    public static function storeMateri($request, $file)
    {
        $url = config('api.url').'/lecturer/materi/store';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray(), 'file' => $file);
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        return $response;
    }

    public static function deleteMateri($id)
    {
        $url = config('api.url').'/lecturer/materi/delete/'.$id;
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        
        return json_decode($response);
    }

    public static function getByKuliahMateri($kuliah)
    {
        $url = config('api.url').'/lecturer/materi/get-by-kuliah';
        $data = array('user' => ResponseHelper::user(), 'kuliah' => $kuliah);
        $response = Curl::to($url)
        ->withData($data)
        ->post();

        return $response;
    }

    // etugas
    public static function indexEtugas()
    {
        $url = config('api.url').'/lecturer/e-tugas';
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
        ->withData($data)
        ->post();

        return $response;
    }

    public static function storeEtugas($request, $file)
    {
        $url = config('api.url').'/lecturer/e-tugas/store';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray(), 'file' => $file);
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        return $response;
    }
    

    public static function editEtugas($id)
    {
        $url = config('api.url').'/lecturer/e-tugas/edit/'.$id;
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        return $response;
    }

    public static function detailEtugas($id)
    {
        $url = config('api.url').'/lecturer/e-tugas/detail/'.$id;
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        return $response;
    }

    public static function updateEtugas($request, $file, $id)
    {
        $url = config('api.url').'/lecturer/e-tugas/update/'.$id;
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray(), 'file' => $file);
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        return $response;
    }

    public static function deleteEtugas($id)
    {
        $url = config('api.url').'/lecturer/e-tugas/delete/'.$id;
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        
        return json_decode($response);
    }

    public static function getByKuliahEtugas($kuliah)
    {
        $url = config('api.url').'/lecturer/e-tugas/get-by-kuliah';
        $data = array('user' => ResponseHelper::user(), 'kuliah' => $kuliah);
        $response = Curl::to($url)
        ->withData($data)
        ->post();

        return $response;
    }

    public static function setNilaiEtugas($request)
    {
        $url = config('api.url').'/lecturer/e-tugas/set-nilai';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        return $response;
    }

}