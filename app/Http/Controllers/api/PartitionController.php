<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IncomeOutcomePartition;
use App\Http\Requests\StoreUpdatePartition;
use App\Http\Resources\PartitionResource;
use App\Services\AccountService;
use App\Services\PartitionService;
use InvalidArgumentException;

class PartitionController extends Controller
{
    protected $userService;
    protected $accountService;

    public function __construct(AccountService $accountService, PartitionService $partitionService)
    {
        $this->accountService = $accountService;
        $this->partitionService = $partitionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $userId
     * @param int $accountId
     * @return \Illuminate\Http\Response
     */
    public function index(int $userId, int $accountId)
    {
        $partitions = $this->accountService->getPartitions($userId, $accountId);
        return PartitionResource::collection($partitions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int $userId
     * @param int $accountId
     * @param  \App\Http\Requests\StoreUpdatePartition  $request
     * @return \Illuminate\Http\Response
     */
    public function store(int $userId, int $accountId, StoreUpdatePartition $request)
    {
        $partition = $this->partitionService
            ->create($userId, $accountId, $request->validated());
        return new PartitionResource($partition);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $userId
     * @param  int  $accountId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $userId, int $accountId, int $id)
    {
        $partition = $this->partitionService->getUserAccountPartition($userId, $accountId, $id);
        return new PartitionResource($partition);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdatePartition  $request
     * @param  int  $userId
     * @param  int  $accountId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdatePartition $request, int $userId, int $accountId, int $id)
    {
        $partition = $this->partitionService
            ->update($userId, $accountId, $id, $request->validated());
        return new PartitionResource($partition);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $userId
     * @param  int  $accountId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $userId, int $accountId, int $id)
    {
        $this->partitionService->delete($userId, $accountId, $id);
        return response()->json([], 204);
    }


    /**
     * Add money to partition.
     *
     * @param  \App\Http\Requests\IncomeOutcomePartition  $request
     * @param  int  $userId
     * @param  int  $accountId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addMoney(IncomeOutcomePartition $request, int $userId, int $accountId, int $id)
    {
        $partition = $this->partitionService
            ->addMoney($userId, $accountId, $id, $request->validated());
        return new PartitionResource($partition);
    }

    /**
     * Remove money from partition.
     *
     * @param  \App\Http\Requests\IncomeOutcomePartition  $request
     * @param  int  $userId
     * @param  int  $accountId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeMoney(IncomeOutcomePartition $request, int $userId, int $accountId, int $id)
    {
        try {
            $partition = $this->partitionService
                ->removeMoney($userId, $accountId, $id, $request->validated());
            return new PartitionResource($partition);
        } catch (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
