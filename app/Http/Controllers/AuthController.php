<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        User::create($data);
        return response()->json([
            "status" => true,
            "message" => "User created successfully"
        ]);

    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                "status" => false,
                "message" => "Invalid Credentials"

            ]);
        }

        $user = Auth::user();
        $token = $user->createToken('myToken')->plainTextToken;

        return response()->json([
            "status" => true,
            "message" => "User logged in successfully",
            "token" => $token,
            "user" => $user
        ]);
    }

    public function profile()
    {
        $user = Auth::user();
        return response()->json([
            "status" => true,
            "message" => "User profile info",
            "user" => $user
        ]);
    }

    public function validateToken()
    {
        try {
            $user = auth()->user();
            return response()->json([
                'status' => true,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid token'
            ], 401);
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => true,
            'message' => 'User logged out successfully'
        ]);
    }

}
