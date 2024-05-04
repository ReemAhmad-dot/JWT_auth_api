<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        // create user data + save
        User::create([
        "name" => $request->name,
        "email" => $request->email,
        "phone_no"=>$request->phone_no,
        "password" => $request->password,
        ]);

        // send response
        return response()->json([
            "status" => true,
            "message" => "User registered successfully"
        ], 200);
    }

    // USER LOGIN API - POST
    public function login(Request $request)
    {
        // validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // verify user + token
        $token = JWTAuth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ]);
        if (!empty($token)) {
            // send response
        return response()->json([
            "status" => true,
            "message" => "User Logged in successfully",
            "access_token" => $token
        ]);
        }
        return response()->json([
            "status" => false,
            "message" => "Invalid credentials"
        ]);
    }
    

    // USER PROFILE API - GET
    public function profile()
    {
        $user_data = auth()->user();

        return response()->json([
            "status" => 1,
            "message" => "User profile data",
            "data" => $user_data
        ]);
    }
    public function refreshToken()
    {
        $newToken=Auth::refresh();
        return response()->json([
            "status" => true,
            "message" => "New access token",
            "data"=> $newToken
        ]);
    }
    // USER LOGOUT API - GET
    public function logout()
    {
        auth()->logout();

        return response()->json([
            "status" => true,
            "message" => "User logged out"
        ]);
    }
}
