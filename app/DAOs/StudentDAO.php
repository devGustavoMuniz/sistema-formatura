<?php

namespace App\DAOs;

use App\Interfaces\DAOs\iStudentDAO;
use App\Models\Student;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class StudentDAO implements iStudentDAO
{
    private function getQuery(array $filters): Builder
    {
        return Student::with('institute')->filter($filters);
    }

    public function getPaginated(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return $this->getQuery($filters)->paginate($perPage);
    }

    public function getCollection(array $filters): Collection
    {
        return $this->getQuery($filters)->get();
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

    public function getAllWithPhotoCount(): Collection
    {
        // Utiliza o withCount para obter a contagem de fotos de forma eficiente
        return Student::withCount('photos')->get();
    }
}
