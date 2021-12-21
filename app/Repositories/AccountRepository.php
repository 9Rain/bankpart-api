<?php

namespace App\Repositories;

use App\Models\Account;
use App\Models\User;

class AccountRepository extends CRUDRepository
{
    public function __construct(Account $account)
    {
        $this->entity = $account;
    }

    public function getUserAccount(string $userId, string $id)
    {
        return $this->entity->where(
            array(
                'id' => $id,
                'user_id' => $userId
            )
        )->firstOrFail();
    }

    public function getPartitions(string $id)
    {
        return $this->get($id)->partitions;
    }
}
