<?php

namespace App\Traits;

use Storage;

trait HandleUploads {
    public function uploadFile($file, $oldFile = null, $folder = 'uploads') {
        if(!$file) {
            return $oldFile;
        }

        $filename = $file->hashName();

        $file->storeAs($folder, $filename, 'public');

        if($oldFile && Storage::disk('public')->exists($folder . '/' . $oldFile)) {
            Storage::disk('public')->delete($folder . '/' . $oldFile);
        }

        return $filename;
    }

    public function deleteFile($file, $folder = 'uploads') {
        if ($file && Storage::disk('public')->exists($folder . '/' . $file)) {
            Storage::disk('public')->delete($folder . '/' . $file);
        }
    }
}