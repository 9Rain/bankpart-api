<?php

namespace App\Repositories;

abstract class CRUDRepository
{
    protected $entity;

    public function getAll()
    {
        return $this->entity::paginate();
    }

    public function get(string $id)
    {
        return $this->entity->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->entity->create($data);
    }

    public function update(string $id, array $data)
    {
        $entity = $this->get($id);
        $entity->update($data);
        return $entity;
    }

    public function delete(string $id)
    {
        $entity = $this->get($id);
        return $entity->delete();
    }
}
