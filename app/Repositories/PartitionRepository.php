<?php

namespace App\Repositories;

use App\Models\Partition;

class PartitionRepository extends CRUDRepository
{
    public function __construct(Partition $partition)
    {
        $this->entity = $partition;
    }

    public function getAccountPartition(string $accountId, string $id)
    {
        return $this->entity->where(
            array(
                'id' => $id,
                'account_id' => $accountId
            )
        )->firstOrFail();
    }
}
