<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use App\Helpers\DatabaseHelper;
use App\Helpers\StudentDatabaseHelper;

class StudentController extends Controller
{
    public function index()
    {
        return $view = view('student');
    }

    public function dashboard()
    {
        $database = StudentDatabaseHelper::getDashboard();
        return $database;
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
        $file = FileHelper::upload($request->file('file'), 'uploads/tugas-mahasiswa/');

        $database = StudentDatabaseHelper::storeEtugas($request, $file);
        return $database;
    }

    public function eTugasFilter(Request $request)
    {
        $database = StudentDatabaseHelper::eTugasFilter($request);
        return $database;
    }
}
