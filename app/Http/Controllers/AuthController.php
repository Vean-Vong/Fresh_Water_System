<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $req)
    {
        $rules = [
            'username' => 'required|string|unique:users,username',
            'email' => 'required|string|email|unique:users,email', // Unique check handles duplicate emails
            'password' => 'required|string|min:6',
            'phone_number' => 'nullable|string',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string'
        ];

        // Validate the request
        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Create new user
        $user = User::create([
            'username' => $req->username,
            'email' => $req->email,
            'password' => Hash::make($req->password), // Hash password before storing
            'phone_number' => $req->phone_number,
            'gender' => $req->gender,
            'address' => $req->address,
            'role' => 'user',
        ]);

        // Generate token
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    public function login(Request $req)
    {
        // Validate input
        $rules = [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ];
        $req->validate($rules);

        // Find user by email
        $user = User::where('email', $req->email)->first();

        // Check if email exists
        if (!$user) {
            return response()->json(['message' => 'Incorrect email'], 400);
        }

        // Validate password using Hash::check()
        if (!Hash::check($req->password, $user->password)) {
            return response()->json(['message' => 'Incorrect password'], 400);
        }

        // Generate token
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        // Custom message after successful login
        $message = "Welcome back, " . $user->username . "! You have successfully logged in!";

        return response()->json([
            'message' => $message,  // Custom success message
            'user' => $user,
            'token' => $token
        ], 200);
    }
}