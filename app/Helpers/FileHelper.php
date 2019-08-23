<?php

namespace App\Helpers;

class FileHelper
{
    public static function upload($file, $path)
    {
        if (!$file) return null;

        $valid_array_extension = ['pdf', 'jpeg', 'jpg', 'png', 'zip', 'rar', 'xls', 'xlxs', 'doc', 'docx', 'ppt', 'pptx'];

        if (!in_array(strtolower($file->extension()), $valid_array_extension)) {
            return null;
        }

        $file_prop = [];
        if (\Input::file()) {
            $filename = date("YmdHis"). '-' . $file->getClientOriginalName();
            $file_prop['original_name'] = $file->getClientOriginalName();
            $file_prop['original_extension'] = $file->getClientOriginalExtension();
            $file_prop['original_size'] = $file->getClientSize();

            if($file->move($path, $filename)){
                $file_prop['original_path'] = $path.$filename;
                return $file_prop;
            }
            return null;
        }

        return null;
    }
    
}
