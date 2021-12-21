<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends CRUDRepository
{
    public function __construct(User $user)
    {
        $this->entity = $user;
    }

    public function getAccounts(string $id)
    {
        return $this->get($id)->accounts;
    }
}
