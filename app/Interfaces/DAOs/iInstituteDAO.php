<?php

namespace App\Interfaces\DAOs;

use App\Models\Institute;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface iInstituteDAO
{
    public function getPaginated(array $filters, int $perPage = 15): LengthAwarePaginator;
    public function getCollection(array $filters): Collection;
    public function findById(int $id): ?Institute;
    public function create(array $data): Institute;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getAllWithStudentCount(): Collection;
}
