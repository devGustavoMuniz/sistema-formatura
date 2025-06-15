<?php

namespace App\DAOs;

use App\Interfaces\DAOs\iStudentDAO;
use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class StudentDAO implements iStudentDAO
{
     public function getAll(array $filters): LengthAwarePaginator
    {
        return Student::with('institute')->filter($filters)->paginate(15);
    }

      public function getAllNoPagination(array $filters): Collection
    {
        return Student::with('institute')->filter($filters)->get();
    }


    public function findById(int $id): ?Student
    {
        return Student::with(['institute', 'photos'])->find($id);
    }

    public function create(array $data): Student
    {
        return Student::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $student = Student::find($id);
        return $student ? $student->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $student = Student::find($id);
        return $student ? $student->delete() : false;
    }
}
