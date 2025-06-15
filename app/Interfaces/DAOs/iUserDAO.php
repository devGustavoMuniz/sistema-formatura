<?php

namespace App\Interfaces\DAOs;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface iUserDAO
{
    public function getPaginatedAdmins(array $filters): LengthAwarePaginator;
    public function createAdmin(array $data): User;
    public function deleteAdmin(int $id): bool;
}
