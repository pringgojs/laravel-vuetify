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
    Route::get('/', 'StudentController@index');
});

Route::group(['prefix' => 'lecturer', 'middleware' => 'role:lecturer'], function () {
    Route::get('materi/get-by-semester/{kuliah}', 'LecturerController@getByKuliahMateri');
    Route::get('materi/remove/{id}', 'LecturerController@deleteMateri');
    Route::post('materi/store', 'LecturerController@storeMateri');
    Route::get('materi', 'LecturerController@indexMateri');

    Route::get('schedule/get-by-semester/{kuliah}', 'LecturerController@getBySemester');
    Route::get('schedule', 'LecturerController@schedule');
    Route::get('/', 'LecturerController@index');
});

Route::post('login', 'Auth\LoginController@login');
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::get('/', 'Auth\LoginController@checkAuth');
