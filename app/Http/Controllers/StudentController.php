<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\DatabaseHelper;
use App\Helpers\StudentDatabaseHelper;

class StudentController extends Controller
{
    public function index()
    {
        return $view = view('student');
    }

    public function schedule()
    {
        $database = StudentDatabaseHelper::getScheduleIndex();
        return $database;
    }

    public function materi()
    {
        $database = StudentDatabaseHelper::getMateriIndex();
        return $database;
    }

    public function materiGetBySemester($kuliah)
    {
        $database = StudentDatabaseHelper::getMateriGetBySemester($kuliah);
        return $database;
    }

    public function eTugas()
    {
        $database = StudentDatabaseHelper::getEtugasIndex();
        return $database;
    }

    public function eTugasDetail($id)
    {
        $database = StudentDatabaseHelper::getEtugasDetail($id);
        return $database;
    }

    public function eTugasStore(Request $request)
    {
        $database = StudentDatabaseHelper::storeEtugas($request);
        return $database;
    }
}
