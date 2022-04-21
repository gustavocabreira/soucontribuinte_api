<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\AuthenticationService;

class UserController extends Controller
{
    private AuthenticationService $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function register(RegisterUserRequest $request)
    {
        $user = $this->authenticationService->registerUser($request->validated());
        return response()->json($user, 201);
    }

    public function login(LoginUserRequest $request)
    {
        $response = $this->authenticationService->login($request->validated());
        return response()->json($response, 200);
    }
}

