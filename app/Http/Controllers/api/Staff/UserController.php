<?php

namespace App\Http\Controllers\api\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\User\{
    CreateUserRequest,
    UpdateUserRequest
};
use App\Http\Resources\Staff\UserResource;
use App\Models\User;
use App\Services\Staff\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $users = $this->userService->getAll();
        return UserResource::collection($users);
    }

    public function store(CreateUserRequest $request): \App\Http\Resources\Staff\UserResource
    {
        $userData = $request->validated();

        $user = $this->userService
            ->create($userData);

        return new UserResource($user);
    }

    public function show(User $user): \App\Http\Resources\Staff\UserResource
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user): \App\Http\Resources\Staff\UserResource
    {
        $userData = $request->validated();

        $updatedUser = $this->userService
            ->update($user, $userData);

        return new UserResource($updatedUser);
    }

    public function destroy(User $user): \Illuminate\Http\JsonResponse
    {
        $this->userService->delete($user);
        return response()->json([], 204);
    }
}
