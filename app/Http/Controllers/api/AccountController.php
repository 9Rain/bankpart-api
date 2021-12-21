<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateAccount;
use App\Http\Resources\AccountResource;
use App\Services\AccountService;
use App\Services\UserService;

class AccountController extends Controller
{
    protected $userService;
    protected $accountService;

    public function __construct(UserService $userService, AccountService $accountService)
    {
        $this->userService = $userService;
        $this->accountService = $accountService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        $accounts = $this->userService->getAccounts($userId);
        return AccountResource::collection($accounts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param string $userId
     * @param  \App\Http\Requests\StoreUpdateAccount  $request
     * @return \Illuminate\Http\Response
     */
    public function store(string $userId, StoreUpdateAccount $request)
    {
        $account = $this->accountService
            ->create($userId, $request->validated());
        return new AccountResource($account);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $userId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($userId, $id)
    {
        $account = $this->accountService->getUserAccount($userId, $id);
        return new AccountResource($account);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdateAccount  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateAccount $request, $userId, $id)
    {
        $account = $this->accountService
            ->update($userId, $id, $request->validated());
        return new AccountResource($account);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $userId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId, $id)
    {
        $this->accountService->delete($userId, $id);
        return response()->json([], 204);
    }
}
