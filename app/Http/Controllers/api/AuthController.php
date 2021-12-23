<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterUserRequest $request): \App\Http\Resources\UserResource
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);
        $user = $this->userService
            ->create($data);

        return new UserResource($user);
    }

    public function login(LoginUserRequest $request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->validated();

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me(): \Illuminate\Http\JsonResponse
    {
        return response()->json(auth('api')->user());
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth('api')->logout();

        return response()->json([], 204);
    }

    protected function respondWithToken($token): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
