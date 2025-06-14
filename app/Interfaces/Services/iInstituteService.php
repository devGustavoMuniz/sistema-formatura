<?php

namespace App\Interfaces\Services;

use App\Models\Institute;
use Illuminate\Database\Eloquent\Collection;

interface iInstituteService
{
    public function getAllInstitutes(array $filters): Collection;
    public function findInstituteById(int $id): ?Institute;
    public function createInstitute(array $data): Institute;
    public function updateInstitute(int $id, array $data): bool;
    public function deleteInstitute(int $id): bool;
}
