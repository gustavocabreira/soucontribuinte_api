<?php

namespace App\Services;

use App\Exceptions\WrongCredentialsException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthenticationService {

    public function __construct() {}

    public function registerUser(array $payload): User
    {
        return User::create($payload);
    }

    public function login(array $credentials): array
    {
        if(!Auth::attempt($credentials)) {
            throw new WrongCredentialsException('Invalid email or password', 422);
        }

        $token = Auth::user()->createToken('user_token')->plainTextToken;

        return [
            'id' => Auth::id(),
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'token' => $token,
        ];
    }
}