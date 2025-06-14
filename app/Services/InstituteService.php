<?php

namespace App\Services;

use App\Contexts\ValidationContext;
use App\Interfaces\DAOs\iInstituteDAO;
use App\Interfaces\Services\iInstituteService;
use App\Models\Institute;
use App\Observers\LogObserver;
use App\Observers\NotificationObserver;
use App\Strategies\InstituteValidationStrategy;
use Illuminate\Database\Eloquent\Collection;

class InstituteService implements iInstituteService
{
    private iInstituteDAO $dao;

    public function __construct(iInstituteDAO $dao)
    {
        $this->dao = $dao;
    }

    public function getAllInstitutes(array $filters): Collection
    {
        return $this->dao->getAll($filters);
    }

    public function findInstituteById(int $id): ?Institute
    {
        return $this->dao->findById($id);
    }

    public function createInstitute(array $data): Institute
    {

        $validationContext = new ValidationContext(new InstituteValidationStrategy());
        $validationContext->validate($data);

        $institute = $this->dao->create($data);

        $institute->addObserver(new LogObserver());
        $institute->addObserver(new NotificationObserver());
        $institute->notify();

        return $institute;
    }

    public function updateInstitute(int $id, array $data): bool
    {
        $data['id'] = $id;
        $validationContext = new ValidationContext(new InstituteValidationStrategy());
        $validationContext->validate($data);

        $success = $this->dao->update($id, $data);

        if ($success) {
            $institute = $this->dao->findById($id);
            $institute->addObserver(new LogObserver());
            $institute->notify();
        }

        return $success;
    }

    public function deleteInstitute(int $id): bool
    {
        return $this->dao->delete($id);
    }
}
