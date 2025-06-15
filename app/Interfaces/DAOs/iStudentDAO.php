<?php

namespace App\Interfaces\DAOs;

use App\Models\Student;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface iStudentDAO
{
    public function getPaginated(array $filters, int $perPage = 15): LengthAwarePaginator;
    public function getCollection(array $filters): Collection;
    public function findById(int $id): ?Student;
    public function create(array $data): Student;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    /**
     * Retorna todos os alunos com a contagem de fotos.
     */
    public function getAllWithPhotoCount(): Collection;
}
