<?php

namespace App\Interfaces\Services;

use App\Models\Photo;
use Illuminate\Http\UploadedFile;

interface iPhotoService
{
    public function uploadPhoto(array $data, UploadedFile $file): Photo;
    public function deletePhoto(int $id): bool;
}
