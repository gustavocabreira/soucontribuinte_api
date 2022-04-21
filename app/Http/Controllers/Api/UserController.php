<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\WrongCredentialsException;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['string', 'required'],
            'email' => ['email', 'required', 'unique:users,email'],
            'password' => ['string', 'required'],
        ]);

        $user = User::create($request->all());

        return response()->json($user, 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['email', 'required'],
            'password' => ['string', 'required'],
        ]);

        $credentials = $request->only('email', 'password');

        if(!Auth::attempt($credentials)) {
            throw new WrongCredentialsException('Invalid email or password');
        }

        $token = Auth::user()->createToken('user_token')->plainTextToken;

        return response()->json([
            'id' => Auth::id(),
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'token' => $token,
        ]);
    }
}