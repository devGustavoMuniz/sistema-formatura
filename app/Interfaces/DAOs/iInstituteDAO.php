<?php

namespace App\Interfaces\DAOs;

use App\Models\Institute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


interface iInstituteDAO
{
    public function getAll(array $filters): LengthAwarePaginator;
    public function getAllNoPagination(array $filters): Collection;
    public function findById(int $id): ?Institute;
    public function create(array $data): Institute;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
