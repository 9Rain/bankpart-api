<?php

namespace App\Services;

use App\Repositories\AccountRepository;

class AccountService
{
    protected $repository;

    public function __construct(AccountRepository $accountRepository, UserService $userService)
    {
        $this->repository = $accountRepository;
        $this->userService = $userService;
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function get(string $id)
    {
        return $this->repository->get($id);
    }

    public function create(string $userId, array $data)
    {
        $user = $this->userService->get($userId);
        $data['user_id'] = $user->id;

        return $this->repository->create($data);
    }

    public function update(string $userId, string $id, array $data)
    {
        $this->userHasAccount($userId, $id);
        return $this->repository->update($id, $data);
    }

    public function delete(string $userId, string $id)
    {
        $this->userHasAccount($userId, $id);
        return $this->repository->delete($id);
    }

    public function getUserAccount(string $userId, string $id)
    {
        return $this->repository->getUserAccount($userId, $id);
    }

    public function getPartitions(string $userId, string $id)
    {
        $this->userHasAccount($userId, $id);
        return $this->repository->getPartitions($id);
    }

    public function userHasAccount(string $userId, string $id)
    {
        $this->userService->get($userId);
        $this->getUserAccount($userId, $id);
    }
}
