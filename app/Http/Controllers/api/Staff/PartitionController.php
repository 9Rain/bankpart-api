<?php

namespace App\Http\Controllers\api\Staff;


use App\Http\Controllers\Controller;
use App\Http\Resources\Staff\PartitionResource;
use App\Services\Staff\AccountService;
use App\Services\Staff\PartitionService;
use App\Http\Requests\Staff\Partition\{
    CreatePartitionRequest,
    ShowDeletePartitionRequest,
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

    public function index(User $user, Account $account, AccountService $accountService): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $partitions = $accountService->getAllPartitions($account);
        return PartitionResource::collection($partitions);
    }

    public function store(User $user, Account $account, CreatePartitionRequest $request): \App\Http\Resources\Staff\PartitionResource
    {
        $partition = $this->partitionService
            ->create($request->validated() + ['account_id' => $account->id]);
        return new PartitionResource($partition);
    }

    public function show(User $user, Account $account, Partition $partition, ShowDeletePartitionRequest $request): \App\Http\Resources\Staff\PartitionResource
    {
        $request->validated();
        return new PartitionResource($partition);
    }

    public function update(User $user, Account $account, Partition $partition, UpdatePartitionRequest $request): \App\Http\Resources\Staff\PartitionResource
    {
        $partition = $this->partitionService
            ->update($partition, $request->validated());
        return new PartitionResource($partition);
    }

    public function destroy(User $user, Account $account, Partition $partition, ShowDeletePartitionRequest $request): \Illuminate\Http\JsonResponse
    {
        $request->validated();
        $this->partitionService->delete($partition);
        return response()->json([], 204);
    }

    public function addMoney(User $user, Account $account, Partition $partition, IncomePartitionRequest $request): \App\Http\Resources\Staff\PartitionResource
    {
        $partition = $this->partitionService
            ->addMoney($partition, $request->validated());
        return new PartitionResource($partition);
    }

    public function removeMoney(User $user, Account $account, Partition $partition, OutcomePartitionRequest $request): \App\Http\Resources\Staff\PartitionResource
    {
        $partition = $this->partitionService
            ->removeMoney($partition, $request->validated());
        return new PartitionResource($partition);
    }
}
