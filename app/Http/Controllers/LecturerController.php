<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\DatabaseHelper;
use App\Traits\LecturerEtugasTrait;
use App\Traits\LecturerMateriTrait;

class LecturerController extends Controller
{
    use LecturerMateriTrait;
    use LecturerEtugasTrait;
    
    public function index()
    {
        $database = DatabaseHelper::getLecturerIndex();
        $view = view('lecturer');
        $view->lecturer = $database->lecturer;
        $view->program_study = $database->program_study;
        return $view;
    }

    public function schedule()
    {
        $database = DatabaseHelper::getScheduleIndex();
        return $database;
    }

    public function getBySemester($kuliah)
    {
        \Log::info($kuliah);
        $database = DatabaseHelper::getScheduleBySemester($kuliah);
        return $database;
    }
}
