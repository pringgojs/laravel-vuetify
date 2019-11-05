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
        'lecturer/e-tugas/set-nilai',
        'lecturer/e-tugas/filter',
        'lecturer/materi/filter',
        'lecturer/schedule/filter',
        'lecturer/nilai-permodul/filter',
        'lecturer/nilai-permodul/filter',
        'lecturer/report/nilai-permodul/filter',
        'lecturer/e-tugas/store',
        'lecturer/materi/store',

        'student/e-tugas/store',
        'student/materi/filter',
        'student/e-tugas/filter',
        'filter/student/get-modul',
        'filter/student/get-matakuliah/*',
    ];
}
