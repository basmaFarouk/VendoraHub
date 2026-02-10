<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait FileUploadTrait {

    public function uploadFile(?UploadedFile $file,$oldPath = null, $path = 'uploads') {

        if(!$file->isValid()) {
            return null;
        }

        $ignorePath = ['/defaults/avatar', '/defaults/store_banner.png', '/defaults/store_logo.png'];

        if($oldPath && File::exists(public_path($oldPath)) && !in_array($oldPath, $ignorePath)){
            File::delete(public_path($oldPath));
        }

        $folderPath = public_path($path);
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move($folderPath, $fileName);
        $filePath = $path . '/' . $fileName;
        return $filePath;
    }


        public function uploadPrivateFile(?UploadedFile $file,$oldPath = null, $path = 'uploads') {

        if(!$file->isValid()) {
            return null;
        }
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($path, $fileName, 'local');
        return $path;
    }
}
