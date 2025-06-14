<?php

namespace App\Interfaces\Services;

use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;

interface iStudentService
{
    public function getAllStudents(array $filters): Collection;
    public function findStudentById(int $id): ?Student;
    public function createStudent(array $data): Student;
    public function updateStudent(int $id, array $data): bool;
    public function deleteStudent(int $id): bool;
}
