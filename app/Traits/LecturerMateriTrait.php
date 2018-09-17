<?php

namespace App\Traits;

use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Helpers\DatabaseHelper;
use App\Helpers\ResponseHelper;

trait LecturerMateriTrait
{
    public function indexMateri()
    {
        $database = DatabaseHelper::indexMateri();
        return $database;
    }

    public function storeMateri(Request $request)
    {
        $file = FileHelper::upload($request->file('file'), 'uploads/materi/');
        $database = DatabaseHelper::storeMateri($request, $file);
        return $database;
    }

    public function deleteMateri($id)
    {
        $database = DatabaseHelper::deleteMateri($id);
        if (file_exists($database->url)) {
            try {
                \File::delete($database->url);
            } catch (\Exception $e) {
                // throw new AppException("Can't delete file photo", 503);
            }
        }
        return 1;
    }

    public function getByKuliahMateri($kuliah)
    {
        $database = DatabaseHelper::getByKuliahMateri($kuliah);
        return $database;
    }

}
