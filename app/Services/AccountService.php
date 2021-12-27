<?php

namespace App\Services;

use App\Models\Account;

class AccountService
{
    public function getAll()
    {
        return Account::paginate();
    }

    public function create(array $data)
    {
        return Account::create($data);
    }

    public function update(Account $account, array $data)
    {
        $account->update($data);
        return $account;
    }

    public function delete(Account $account)
    {
        return $account->delete();
    }

    public function getAllPartitions(Account $account)
    {
        return $account->partitions;
    }
}
