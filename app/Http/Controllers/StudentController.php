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
}
