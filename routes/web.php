<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['prefix' => 'student', 'middleware' => 'role:student'], function () {
    
    Route::get('materi/kuliah/{kuliah}', 'StudentController@materiGetBySemester');
    Route::get('materi', 'StudentController@materi');
    Route::get('schedule', 'StudentController@schedule');
    Route::get('e-tugas/kuliah/{kuliah}', 'StudentController@eTugasGetBySemester');
    Route::post('e-tugas/store', 'StudentController@eTugasStore');
    Route::get('e-tugas/detail/{id}', 'StudentController@eTugasDetail');
    Route::get('e-tugas', 'StudentController@eTugas');
    Route::get('dashboard', 'StudentController@dashboard');
    Route::get('/', 'StudentController@index');
});

Route::group(['prefix' => 'lecturer', 'middleware' => 'role:lecturer'], function () {
    // materi
    Route::get('materi/get-by-semester/{kuliah}', 'LecturerController@getByKuliahMateri');
    Route::get('materi/remove/{id}', 'LecturerController@deleteMateri');
    Route::post('materi/store', 'LecturerController@storeMateri');
    Route::get('materi', 'LecturerController@indexMateri');

    // e-tugas
    Route::post('e-tugas/set-nilai', 'LecturerController@setNilaiEtugas');
    Route::get('e-tugas/get-by-semester/{kuliah}', 'LecturerController@getByKuliahEtugas');
    Route::post('e-tugas/update/{id}', 'LecturerController@updateEtugas');
    Route::get('e-tugas/detail/{id}', 'LecturerController@detailEtugas');
    Route::get('e-tugas/edit/{id}', 'LecturerController@editEtugas');
    Route::get('e-tugas/remove/{id}', 'LecturerController@deleteEtugas');
    Route::post('e-tugas/store', 'LecturerController@storeEtugas');
    Route::get('e-tugas', 'LecturerController@indexEtugas');

    // Report
    Route::group(['prefix' => 'report', 'namespace' => 'Lecturer'], function () {
        Route::get('nilai-permodul/kuliah/{id}', 'LecturerReportController@kuliah');
        Route::get('nilai-permodul', 'LecturerReportController@nilaiPermodul');
    });
    // schedule
    Route::get('schedule/get-by-semester/{kuliah}', 'LecturerController@getBySemester');
    Route::get('schedule', 'LecturerController@schedule');
    Route::get('/', 'LecturerController@index');
});

Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout');
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::get('/', 'Auth\LoginController@checkAuth');
