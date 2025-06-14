<?php

namespace App\Interfaces\DAOs;

use App\Models\Photo;
use Illuminate\Http\UploadedFile;

interface iPhotoDAO
{
    public function create(array $data, UploadedFile $file): Photo;
    public function delete(int $id): bool;
}
