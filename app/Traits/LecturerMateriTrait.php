<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Helpers\ResponseHelper;

trait LecturerMateriTrait
{
    public function storeMateri(Request $request)
    {
        $file = $request->file('file');
        if ($request->hasFile('file')) {
            \Log::info($file);
        } else {
            \Log::info('0');
        }
    }

}
