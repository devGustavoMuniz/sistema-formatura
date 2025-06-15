<?php

namespace App\DAOs;

use App\Enums\UserType;
use App\Interfaces\DAOs\iUserDAO;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserDAO implements iUserDAO
{
    public function getPaginatedAdmins(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return User::where('type', UserType::ADMIN)
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            })
            ->paginate($perPage);
    }

    public function createAdmin(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => UserType::ADMIN,
        ]);
    }

    public function deleteAdmin(int $id): bool
    {
        $user = User::find($id);
        if ($user && $user->type === UserType::ADMIN) {
            return $user->delete();
        }
        return false;
    }
}
