<?php

namespace App\Http\Controllers\api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Resources\Staff\AccountResource;
use App\Http\Requests\Staff\Account\{
    CreateAccountRequest,
    ShowDeleteAccountRequest,
    UpdateAccountRequest
};
use App\Models\{
    Account,
    User
};
use App\Services\Staff\{
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

    public function index(User $user, UserService $userService): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $accounts = $userService->getAllAccounts($user);
        return AccountResource::collection($accounts);
    }

    public function store(User $user, CreateAccountRequest $request): \App\Http\Resources\Staff\AccountResource
    {
        $account = $this->accountService
            ->create($request->validated() + ['user_id' => $user->id]);
        return new AccountResource($account);
    }

    public function show(User $user, Account $account, ShowDeleteAccountRequest $request): \App\Http\Resources\Staff\AccountResource
    {
        $request->validated();
        return new AccountResource($account);
    }

    public function update(User $user, Account $account, UpdateAccountRequest $request): \App\Http\Resources\Staff\AccountResource
    {
        $account = $this->accountService
            ->update($account, $request->validated());
        return new AccountResource($account);
    }

    public function destroy(User $user, Account $account, ShowDeleteAccountRequest $request): \Illuminate\Http\JsonResponse
    {
        $request->validated();
        $this->accountService->delete($account);
        return response()->json([], 204);
    }
}
