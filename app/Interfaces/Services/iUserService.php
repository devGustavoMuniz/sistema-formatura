<?php

namespace App\Interfaces\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface iUserService
{
    public function getPaginatedAdmins(array $filters): LengthAwarePaginator;
    public function createAdmin(array $data): User;
    public function deleteAdmin(int $id): bool;
}
