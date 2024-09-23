<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Controllers\BaseController;
use App\Http\Requests\LoginUserRequest;
use App\Http\Resources\UserResource;
use App\Services\Api\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class AuthController extends BaseController
{


    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        // Call the register method from the service
        $response = $this->authService->register($request->validated());

        if(! $response['success']){
            return $this->errorResponse($response['message'], $response['status_code']);
        }

        return response()->json([
            'message' => $response['message'],
            'data' => new UserResource($response['data']),
        ], 200);
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        // Call the login method from the service using validated data
        $response = $this->authService->login($request->validated());

        if (!$response['success']) {
            return response()->json(['message' => $response['message']], $response['status_code']);
        }

        return response()->json([
            'message' => $response['message'],
            'data' => new UserResource($response['data']),
        ], 200);
    }

    public function logout(Request $request): JsonResponse
    {
        // Call the logout method from the service using the authenticated user
        $response = $this->authService->logout($request->user());

        if (!$response['success']) {
            return response()->json(['message' => $response['message']], $response['status_code']);
        }

        return response()->json([
            'message' => $response['message'],
            'data' => new UserResource($response['data']),
        ], 200);
    }
}
