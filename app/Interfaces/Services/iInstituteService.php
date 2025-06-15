<?php

namespace App\Interfaces\Services;

use App\Models\Institute;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface iInstituteService
{
    public function getPaginatedInstitutes(array $filters): LengthAwarePaginator;
    public function getAllInstitutesCollection(array $filters): Collection;
    public function findInstituteById(int $id): ?Institute;
    public function createInstitute(array $data): Institute;
    public function updateInstitute(int $id, array $data): bool;
    public function deleteInstitute(int $id): bool;
}
