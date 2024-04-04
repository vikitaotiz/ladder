<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Users\UserResource;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = null;
        if(Auth::attempt($request->only('email', 'password'))) $user = Auth::user();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'status' => 'error',
                'message' => 'User does not exist, invalid credentials. Register'
            ], 401);
        }

        if($user && !$user->active) {
            return response([
                'status' => 'error',
                'message' => 'User has been disabled. Contact admin'
            ], 401);
        }

        $token = $user->createToken('token')->plainTextToken;
        $user = new UserResource($user);

        $response = [
            'status' => 'success',
            'message' => 'User logged in successfully.',
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function register(Request $request) {
        $userExist = User::where('name', $request->name)
            ->where('email', $request->email)
            ->first();

        if($userExist) return response([
            'status' => 'error',
            'message' => 'User already exists, try a different one.'
        ]);

        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $user->roles()->sync([2]);

        if(!$user) return response([
            'status' => 'error',
            'message' => 'Registration failed.',
        ]);

        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'status' => 'success',
            'message' => 'User registered successfully.',
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }


    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'status' => 'success',
            'message' => 'Logged out successfully.'
        ];
    }
}
