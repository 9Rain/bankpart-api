<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PartitionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Services\{
    AccountService,
    PartitionService
};
use App\Http\Requests\Partition\{
    CreatePartitionRequest,
    UpdatePartitionRequest,
    IncomePartitionRequest,
    OutcomePartitionRequest
};
use App\Models\{
    Account,
    Partition,
    User
};


class PartitionController extends Controller
{
    protected $partitionService;

    public function __construct(PartitionService $partitionService)
    {
        $this->partitionService = $partitionService;
    }

    public function index(User $user, Account $account, AccountService $accountService): AnonymousResourceCollection
    {
        $partitions = $accountService->getAllPartitions($account);
        return PartitionResource::collection($partitions);
    }

    public function store(User $user, Account $account, CreatePartitionRequest $request): PartitionResource
    {
        $partition = $this->partitionService
            ->create($request->validated() + ['account_id' => $account->id]);
        return new PartitionResource($partition);
    }

    public function show(User $user, Account $account, Partition $partition): PartitionResource
    {
        return new PartitionResource($partition);
    }

    public function update(User $user, Account $account, Partition $partition, UpdatePartitionRequest $request): PartitionResource
    {
        $partition = $this->partitionService
            ->update($partition, $request->validated());
        return new PartitionResource($partition);
    }

    public function destroy(User $user, Account $account, Partition $partition): JsonResponse
    {
        $this->partitionService->delete($partition);
        return response()->json([], 204);
    }

    public function addMoney(
        User $user,
        Account $account,
        Partition $partition,
        IncomePartitionRequest $request
    ): PartitionResource {
        $partition = $this->partitionService
            ->addMoney($partition, $request->validated());
        return new PartitionResource($partition);
    }

    public function removeMoney(
        User $user,
        Account $account,
        Partition $partition,
        OutcomePartitionRequest $request
    ): PartitionResource {
        $partition = $this->partitionService
            ->removeMoney($partition, $request->validated());
        return new PartitionResource($partition);
    }
}
