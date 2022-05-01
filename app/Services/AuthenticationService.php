<?php

namespace App\Services;

use App\Exceptions\WrongCredentialsException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthenticationService {

    public function __construct() {}

    public function registerUser(array $payload): array
    {
        $user = User::create($payload);

        $token = $this->generateToken($user);

        $user = $user->toArray();
        $user['token'] = $token;

        return $user;
    }

    public function login(array $credentials): array
    {
        if(!Auth::attempt($credentials)) {
            throw new WrongCredentialsException('Invalid email or password', 422);
        }

        $token = $this->generateToken(Auth::user());

        return [
            'id' => Auth::id(),
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'token' => $token,
        ];
    }

    private function generateToken(User $user): string
    {
        return $user->createToken('user_token')->plainTextToken;
    }
}