<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait FileUploadTrait {

    public function uploadFile(UploadedFile $file, $path = 'uploads') {

        if(!$file->isValid()) {
            return null;
        }

        $folderPath = public_path($path);
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move($folderPath, $fileName);
        $filePath = $path . '/' . $fileName;
        return $filePath;
    }
}
