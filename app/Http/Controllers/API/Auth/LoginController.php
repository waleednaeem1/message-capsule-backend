<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Generate both access token and refresh token
            $tokens = $user->createToken('authToken');
            $accessToken = $tokens->plainTextToken;
            $refreshToken = $tokens->accessToken;

            return response()->json([
                'message' => 'User logged in successfully',
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
                'user' => $user,
                'status' => true
            ], 200);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'User logged out successfully and hw is in peace now'], 200);
    }
}
