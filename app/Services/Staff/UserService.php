<?php

namespace App\Services\Staff;

use App\Helpers\StringHelper;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAll()
    {
        return User::paginate();
    }

    public function create(array $data)
    {
        $data['password'] = $this->getEncryptedPassword($data['password']);
        return User::create($data);
    }

    public function update(User $user, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = $this->getEncryptedPassword($data['password']);
        }
        $user->update($data);
        return $user;
    }

    public function delete(User $user)
    {
        return $user->delete();
    }

    public function getAllAccounts(User $user)
    {
        return $user->accounts;
    }

    private function getEncryptedPassword(string $password = null)
    {
        if (!$password) {
            $password = StringHelper::generateRandom(8);
        }
        return Hash::make($password);
    }
}
