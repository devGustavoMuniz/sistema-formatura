<?php

namespace App\Services;

use App\Contexts\ValidationContext;
use App\Interfaces\DAOs\iPhotoDAO;
use App\Interfaces\Services\iPhotoService;
use App\Models\Photo;
use App\Observers\LogObserver;
use App\Strategies\PhotoValidationStrategy;
use Illuminate\Http\UploadedFile;

class PhotoService implements iPhotoService
{
    private iPhotoDAO $dao;

    public function __construct(iPhotoDAO $dao)
    {
        $this->dao = $dao;
    }

    public function uploadPhoto(array $data, UploadedFile $file): Photo
    {

        $validationData = array_merge($data, ['photo' => $file]);


        $validationContext = new ValidationContext(new PhotoValidationStrategy());
        $validationContext->validate($validationData);

        $photo = $this->dao->create($data, $file);


        $photo->addObserver(new LogObserver());
        $photo->notify();

        return $photo;
    }

    public function deletePhoto(int $id): bool
    {
        return $this->dao->delete($id);
    }
}
