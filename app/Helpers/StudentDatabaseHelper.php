<?php

namespace App\Helpers;

use Ixudra\Curl\Facades\Curl;
use App\Helpers\ResponseHelper;

class StudentDatabaseHelper
{
    public static function getScheduleIndex()
    {
        $url = config('api.url').'/student/schedule';
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
        ->withData($data)
        ->post();
        
        return $response;
    }

    public static function getMateriIndex()
    {
        $url = config('api.url').'/student/materi';
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
        ->withData($data)
        ->post();
        
        return $response;
    }

    public static function getMateriGetBySemester($kuliah)
    {
        $url = config('api.url').'/student/materi/kuliah/'.$kuliah;
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
        ->withData($data)
        ->post();
        
        return $response;
    }

    public static function getEtugasIndex()
    {
        $url = config('api.url').'/student/etugas';
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
        ->withData($data)
        ->post();
        
        return $response;
    }

    public static function getEtugasDetail($id)
    {
        $url = config('api.url').'/student/etugas/detail/'.$id;
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
        ->withData($data)
        ->post();
        
        return $response;
    }

    public static function storeEtugas($request, $file)
    {
        $url = config('api.url').'/student/etugas/store';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray(), 'file' => $file);
        $response = Curl::to($url)
        ->withData($data)
        ->post();
        
        return $response;
    }

    public static function getEtugasGetBySemester($kuliah)
    {
        $url = config('api.url').'/student/etugas/kuliah/'.$kuliah;
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
        ->withData($data)
        ->post();
        
        return $response;
    }
}