<?php

namespace App\DAOs;

use App\Interfaces\DAOs\iPhotoDAO;
use App\Models\Photo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PhotoDAO implements iPhotoDAO
{
    /**
     * @param array $data Contém 'student_id'
     * @param UploadedFile $file O arquivo da foto
     * @return Photo
     */
    public function create(array $data, UploadedFile $file): Photo
    {
        $path = $file->store('photos', 'public');
        $filesize = $file->getSize();

        return Photo::create([
            'student_id' => $data['student_id'],
            'path' => $path,
            'filesize' => $filesize,
        ]);
    }

    public function delete(int $id): bool
    {
        $photo = Photo::find($id);

        if ($photo) {
            Storage::disk('public')->delete($photo->path);
            return $photo->delete();
        }

        return false;
    }
}
