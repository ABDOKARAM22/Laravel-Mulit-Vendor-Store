<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaUploader
{
    public function store(UploadedFile $file, string $directory): string
    {
        return $file->store($directory, ['disk' => 'uploads']);
    }

    public function delete(?string $path): void
    {
        if ($path !== null && $path !== '') {
            Storage::disk('uploads')->delete($path);
        }
    }
}
