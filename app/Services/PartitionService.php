<?php

namespace App\Services;

use App\Repositories\PartitionRepository;
use InvalidArgumentException;

class PartitionService
{
    protected $repository;

    public function __construct(PartitionRepository $partitionRepository, AccountService $accountService)
    {
        $this->repository = $partitionRepository;
        $this->accountService = $accountService;
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function get(string $id)
    {
        return $this->repository->get($id);
    }

    public function create(string $userId, string $accountId, array $data)
    {
        $this->accountService->userHasAccount($userId, $accountId);
        $data['account_id'] = $accountId;

        return $this->repository->create($data);
    }

    public function update(string $userId, string $accountId, string $id, array $data)
    {
        $this->accountHasPartition($userId, $accountId, $id);
        return $this->repository->update($id, $data);
    }

    public function delete(string $userId, string $accountId, string $id)
    {
        $this->accountHasPartition($userId, $accountId, $id);
        return $this->repository->delete($id);
    }

    public function getUserAccountPartition(string $userId, string $accountId, string $id)
    {
        $this->accountService->userHasAccount($userId, $accountId);
        return $this->repository->getAccountPartition($accountId, $id);
    }

    private function accountHasPartition(string $userId, string $accountId, string $id)
    {
        $this->getUserAccountPartition($userId, $accountId, $id);
    }

    public function addMoney(string $userId, string $accountId, string $id, array $data)
    {
        $partition = $this->getUserAccountPartition($userId, $accountId, $id);

        $amount = $data['amount'];
        $newBalance = $partition->balance + $amount;

        return $this->repository->update($id, array('balance' => $newBalance));
    }

    public function removeMoney(string $userId, string $accountId, string $id, array $data)
    {
        $partition = $this->getUserAccountPartition($userId, $accountId, $id);

        $amount = $data['amount'];
        $newBalance = $partition->balance - $amount;

        if ($newBalance < 0) {
            throw new InvalidArgumentException(
                'The amount can\'t be greater than the current balance',
                400
            );
        } else {
            return $this->repository->update($id, array('balance' => $newBalance));
        }
    }
}
