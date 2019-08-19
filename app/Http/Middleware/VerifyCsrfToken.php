<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'filter/lecturer/get-modul',
        'filter/lecturer/get-matakuliah',
        'lecturer/materi/filter',
        'lecturer/schedule/filter',
        'lecturer/nilai-permodul/filter',
        'lecturer/nilai-permodul/filter',
        'lecturer/report/nilai-permodul/filter',

        'student/e-tugas/filter',
        'filter/student/get-modul',
        'filter/student/get-matakuliah/*',
    ];
}
