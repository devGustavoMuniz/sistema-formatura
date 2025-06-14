<?php

namespace App\Interfaces\DAOs;

use App\Models\Institute;
use Illuminate\Database\Eloquent\Collection;

interface iInstituteDAO
{
    public function getAll(array $filters): Collection;
    public function findById(int $id): ?Institute;
    public function create(array $data): Institute;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
