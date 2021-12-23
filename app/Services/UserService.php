<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $repository;

    public function __construct(UserRepository $todoRepository)
    {
        $this->repository = $todoRepository;
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function get(string $id)
    {
        return $this->repository->get($id);
    }

    public function getByEmail(string $email)
    {
        return $this->repository->getByEmail($email);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update(string $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete(string $id)
    {
        return $this->repository->delete($id);
    }

    public function getAccounts(string $id)
    {
        return $this->repository->getAccounts($id);
    }

    public function userExists(string $email)
    {
        return $this->getByEmail($email)
            ->count() > 0;
    }
}
