<?php

namespace App\Traits;

use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Helpers\DatabaseHelper;
use App\Helpers\ResponseHelper;

trait LecturerMateriTrait
{
    public function storeMateri(Request $request)
    {
        $file = FileHelper::upload($request->file('file'), 'public/uploads/materi/');
        $database = DatabaseHelper::storeMateri($request, $file);
        return $database;
    }

}
