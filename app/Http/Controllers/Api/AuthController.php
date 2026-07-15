<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register User
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return ApiResponseService::success(
            'Register berhasil.',
            [
                'token' => $token,
                'user'  => new UserResource($user),
            ],
            201
        );
    }

    /**
     * Login User
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ApiResponseService::error(
                'Email atau password salah.',
                null,
                401
            );
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return ApiResponseService::success(
            'Login berhasil.',
            [
                'token' => $token,
                'user'  => new UserResource($user),
            ]
        );
    }

    /**
     * Profile
     */
    public function profile(Request $request)
    {
        return ApiResponseService::success(
            'Data user.',
            new UserResource($request->user())
        );
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return ApiResponseService::success(
            'Logout berhasil.'
        );
    }
}