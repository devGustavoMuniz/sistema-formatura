<?php

namespace App\Services;

use App\Contexts\ValidationContext;
use App\Interfaces\DAOs\iUserDAO;
use App\Interfaces\Services\iUserService;
use App\Models\User;
use App\Strategies\AdminValidationStrategy;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService implements iUserService
{
    private iUserDAO $dao;

    public function __construct(iUserDAO $dao)
    {
        $this->dao = $dao;
    }

    public function getPaginatedAdmins(array $filters): LengthAwarePaginator
    {
        return $this->dao->getPaginatedAdmins($filters);
    }

    public function createAdmin(array $data): User
    {
        $validationContext = new ValidationContext(new AdminValidationStrategy());
        $validationContext->validate($data);

        return $this->dao->createAdmin($data);
    }

    public function deleteAdmin(int $id): bool
    {
        return $this->dao->deleteAdmin($id);
    }
}

