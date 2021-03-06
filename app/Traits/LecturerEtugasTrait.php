<?php

namespace App\Traits;

use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Helpers\DatabaseHelper;
use App\Helpers\ResponseHelper;

trait LecturerEtugasTrait
{
    public function indexEtugas()
    {
        $database = DatabaseHelper::indexEtugas();
        return $database;
    }

    public function editEtugas($id)
    {
        $database = DatabaseHelper::editEtugas($id);
        return $database;
    }

    public function storeEtugas(Request $request)
    {
        $file = FileHelper::upload($request->file('file'), 'uploads/e-tugas/');
        $database = DatabaseHelper::storeEtugas($request, $file);
        return $database;
    }

    public function updateEtugas(Request $request, $id)
    {
        $file = FileHelper::upload($request->file('file'), 'uploads/e-tugas/');
        $database = DatabaseHelper::updateEtugas($request, $file, $id);
        return $database;
    }

    public function deleteEtugas($id)
    {
        $database = DatabaseHelper::deleteEtugas($id);
        if (file_exists($database->url)) {
            try {
                \File::delete($database->url);
            } catch (\Exception $e) {
                // throw new AppException("Can't delete file photo", 503);
            }
        }
        return 1;
    }

    public function getByKuliahEtugas($kuliah)
    {
        $database = DatabaseHelper::getByKuliahEtugas($kuliah);
        return $database;
    }

    public function detailEtugas($id)
    {
        $database = DatabaseHelper::detailEtugas($id);
        return $database;
    }

    public function setNilaiEtugas(Request $request)
    {
        $database = DatabaseHelper::setNilaiEtugas($request);
        return $database;
    }

}
