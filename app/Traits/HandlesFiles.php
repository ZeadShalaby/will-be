<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait HandlesFiles
{
    /**
     * @param array $filesArray ['input_name' => 'type']
     * @param array|null $multipleFiles ['child_photos'] => 'child_photo'
     */
    public function saveFiles(array $filesArray = [], array $multipleFiles = [])
    {
        // ✅ الملفات المتعددة
        foreach ($multipleFiles as $inputName => $type) {
            if (request()->hasFile($inputName)) {
                foreach (request()->file($inputName) as $file) {
                    $path = $file->store("uploads/$type", 'public');

                    $this->documents()->create([
                        'type' => $type,
                        'file_path' => $path,
                    ]);
                }
            }
        }

        // ✅ الملفات المفردة
        foreach ($filesArray as $inputName => $type) {
            if (request()->hasFile($inputName)) {
                $file = request()->file($inputName);
                $path = $file->store("uploads/$type", 'public');

                $this->documents()->create([
                    'type' => $type,
                    'file_path' => $path,
                ]);
            }
        }
    }
}
