<?php

namespace App\DAOs;

use App\Interfaces\DAOs\iInstituteDAO;
use App\Models\Institute;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class InstituteDAO implements iInstituteDAO
{
    private function getQuery(array $filters): Builder
    {
        return Institute::filter($filters);
    }

    public function getPaginated(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return $this->getQuery($filters)->paginate($perPage);
    }

    public function getCollection(array $filters): Collection
    {
        return $this->getQuery($filters)->get();
    }

    public function getAllWithStudentCount(): Collection
    {
        return Institute::withCount('students')->get();
    }

    public function findById(int $id): ?Institute
    {
        return Institute::find($id);
    }

    public function create(array $data): Institute
    {
        return Institute::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $institute = Institute::find($id);
        return $institute ? $institute->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $institute = Institute::find($id);
        return $institute ? $institute->delete() : false;
    }
}
