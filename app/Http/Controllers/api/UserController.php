<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\User\{
    CreateUserRequest,
    UpdateUserRequest
};


class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): AnonymousResourceCollection
    {
        $users = $this->userService->getAll();
        return UserResource::collection($users);
    }

    public function store(CreateUserRequest $request): UserResource
    {
        $userData = $request->validated();

        $user = $this->userService
            ->create($userData);

        return new UserResource($user);
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        $userData = $request->validated();

        $updatedUser = $this->userService
            ->update($user, $userData);

        return new UserResource($updatedUser);
    }

    public function destroy(User $user): JsonResponse
    {
        $this->userService->delete($user);
        return response()->json([], 204);
    }
}
