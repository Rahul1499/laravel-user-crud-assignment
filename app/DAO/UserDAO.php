<?php
namespace App\DAO;

use App\Models\User;

class UserDAO
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function all()
    {
        return User::all();
    }
}
