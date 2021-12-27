<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccountResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\Account\{
    CreateAccountRequest,
    UpdateAccountRequest
};
use App\Models\{
    Account,
    User
};
use App\Services\{
    AccountService,
    UserService
};


class AccountController extends Controller
{
    protected $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index(User $user, UserService $userService): AnonymousResourceCollection
    {
        $accounts = $userService->getAllAccounts($user);
        return AccountResource::collection($accounts);
    }

    public function store(User $user, CreateAccountRequest $request): AccountResource
    {
        $account = $this->accountService
            ->create($request->validated() + ['user_id' => $user->id]);
        return new AccountResource($account);
    }

    public function show(User $user, Account $account): AccountResource
    {
        return new AccountResource($account);
    }

    public function update(User $user, Account $account, UpdateAccountRequest $request): AccountResource
    {
        $account = $this->accountService
            ->update($account, $request->validated());
        return new AccountResource($account);
    }

    public function destroy(User $user, Account $account): JsonResponse
    {
        $this->accountService->delete($account);
        return response()->json([], 204);
    }
}
