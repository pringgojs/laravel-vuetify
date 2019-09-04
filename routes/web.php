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

Route::group(['prefix' => 'student', 'middleware' => 'role:student',  'namespace' => 'Student'], function () {
    Route::group(['prefix' => 'e-tugas'], function () {
        Route::post('filter', 'EtugasController@filter');
        Route::post('store', 'EtugasController@store');
        Route::get('detail/{id}', 'EtugasController@detail');
        Route::get('/', 'EtugasController@index');
    });

    Route::group(['prefix' => 'materi'], function () {
        Route::post('filter', 'MateriController@filter');
        Route::get('/', 'MateriController@index');
    });
    
    Route::get('dashboard', 'DashboardController@dashboard');
    Route::get('/', 'DashboardController@index');
});

Route::group(['prefix' => 'lecturer', 'middleware' => 'role:lecturer', 'namespace' => 'Lecturer'], function () {

    Route::group(['prefix' => 'materi'], function () {
        Route::post('filter', 'MateriController@filter');
        Route::post('update/{id}', 'MateriController@update');
        Route::get('edit/{id}', 'MateriController@edit');
        Route::get('remove/{id}', 'MateriController@delete');
        Route::post('store', 'MateriController@store');
        Route::get('/', 'MateriController@index');
    });

    Route::group(['prefix' => 'e-tugas'], function () {
        Route::post('set-nilai', 'EtugasController@setNilai');
        Route::post('filter', 'EtugasController@filter');
        Route::post('update/{id}', 'EtugasController@update');
        Route::get('detail/{id}', 'EtugasController@detail');
        Route::get('download/{id}', 'EtugasController@download');
        Route::get('edit/{id}', 'EtugasController@edit');
        Route::get('remove/{id}', 'EtugasController@delete');
        Route::get('create', 'EtugasController@create');
        Route::post('store', 'EtugasController@store');
        Route::get('/', 'EtugasController@index');
    });

    Route::group(['prefix' => 'report'], function () {
        Route::get('nilai-permodul/sync/{id_master_modul}', 'ReportController@sync');
        Route::get('nilai-permodul/detail/{id_master_modul}', 'ReportController@detailModul');
        Route::post('nilai-permodul/filter', 'ReportController@filter');
        Route::get('nilai-permodul', 'ReportController@nilaiPermodul');
    });

    Route::group(['prefix' => 'schedule'], function () {
        Route::post('filter', 'ScheduleController@filter');
        Route::get('/', 'ScheduleController@index');
    });

    Route::get('/', 'DashboardController@index');
});

Route::group(['prefix' => 'filter'], function () {
    Route::group(['prefix' => 'lecturer', 'namespace' => 'Lecturer'], function () {
        Route::post('get-modul', 'FilterController@getModul');
        Route::post('get-matakuliah', 'FilterController@getMatakuliah');
        Route::get('get-kelas/{tahun}/{semester}', 'FilterController@getKelas');
        Route::get('get-semester', 'FilterController@getSemester');
    });

    Route::group(['prefix' => 'student', 'namespace' => 'Student'], function () {
        Route::post('get-modul', 'FilterController@getModul');
        Route::post('get-matakuliah/{type}', 'FilterController@getMatakuliah');
        Route::get('get-kelas/{type}/{tahun}/{semester}', 'FilterController@getKelas');
        Route::get('get-semester/{type}', 'FilterController@getSemester');
    });
});

Route::post('reset-password', 'Auth\LoginController@resetPassword');
Route::get('download/{folder}/{name}', 'DownloadFileController@download');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout');
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::get('/', 'Auth\LoginController@checkAuth');
