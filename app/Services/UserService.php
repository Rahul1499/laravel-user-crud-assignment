<?php

namespace App\Services;

use App\Business\UserBO;
use App\Models\User;
use Illuminate\Support\Facades\Cache;


class UserService
{
    protected $userBO;

    public function __construct(UserBO $userBO)
    {
        $this->userBO = $userBO;
    }

    public function createUser(array $data): User
    {
        $user = $this->userBO->createUser($data);
        Cache::forget('users');

        return $user;
    }

    public function updateUser(int $id, array $data): ?User
    {
        $user = $this->getUser($id);
        if (!$user) return null;

        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = bcrypt($data['password']);
        }

        $user->update($updateData);
        return $user;
    }

    public function getUser(int $id): ?User
    {
        return Cache::remember("user_{$id}", 3600, function () use ($id) {
            return $this->userBO->getUser($id);
        });
    }

    public function getAllUsers()
    {
        return Cache::remember('users', 3600, function () {
            return $this->userBO->getAllUsers();
        });
    }
}
