<?php 
namespace App\Business;

use App\DAO\UserDAO;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserBO
{
    protected $userDAO;

    public function __construct(UserDAO $userDAO)
    {
        $this->userDAO = $userDAO;
    }

    public function createUser(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userDAO->create($data);
    }

    public function updateUser(User $user, array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->userDAO->update($user, $data);
    }

    public function getUser(int $id): ?User
    {
        return $this->userDAO->findById($id);
    }

    public function getAllUsers()
    {
        return $this->userDAO->all();
    }
}
