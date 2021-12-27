<?php

namespace App\Services;

use App\Models\Partition;

class PartitionService
{
    public function getAll()
    {
        return Partition::getAll();
    }

    public function create(array $data)
    {
        return Partition::create($data);
    }

    public function update(Partition $partition, array $data)
    {
        $partition->update($data);
        return $partition;
    }

    public function delete(Partition $partition)
    {
        return $partition->delete();
    }

    public function addMoney(Partition $partition, array $data)
    {
        $amount = $data['amount'];
        $newBalance = $partition->balance + $amount;
        $partition->update(['balance' => $newBalance]);
        return $partition;
    }

    public function removeMoney(Partition $partition, array $data)
    {
        $amount = $data['amount'];
        $newBalance = $partition->balance - $amount;
        $partition->update(['balance' => $newBalance]);
        return $partition;
    }
}
