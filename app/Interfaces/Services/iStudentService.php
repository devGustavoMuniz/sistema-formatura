<?php

namespace App\Interfaces\Services;

use App\Models\Student;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface iStudentService
{
    public function getPaginatedStudents(array $filters): LengthAwarePaginator;
    public function getAllStudentsCollection(array $filters): Collection;
    public function findStudentById(int $id): ?Student;
    public function createStudentAndUser(array $data): Student;
    public function updateStudent(int $id, array $data): bool;
    public function deleteStudent(int $id): bool;
}
