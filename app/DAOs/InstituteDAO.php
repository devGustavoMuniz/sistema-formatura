<?php

namespace App\DAOs;

use App\Interfaces\DAOs\iInstituteDAO;
use App\Models\Institute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class InstituteDAO implements iInstituteDAO
{
   public function getAll(array $filters): LengthAwarePaginator
    {
        return Institute::filter($filters)->paginate(15);
    }

      public function getAllNoPagination(array $filters): Collection
    {
        return Institute::filter($filters)->get();
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
