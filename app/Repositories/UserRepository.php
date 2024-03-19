<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAllUsers($perPage = 10)
    {
        return $this->user->paginate($perPage);
    }

    public function getUserById($id)
    {
    return $this->user->find($id);
    }
    public function createUser($data)
    {
        return $this->user->create($data);
    }
    public function updateUser($id, $data)
    {
        return $this->user->where('user_id', $id)->update($data);
    }
    public function deleteUser($id)
    {
        return $this->user->where('user_id', $id)->delete();
    }
}
