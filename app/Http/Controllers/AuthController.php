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
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email', // Add unique validation for email
            'password' => 'required|string|min:6',
            'phone_number' => 'required|string'
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Check if the email already exists manually (in case it wasn't caught)
        if (User::where('email', $req->email)->exists()) {
            return response()->json(['message' => 'Email already exists'], 400);
        }

        // Store the password as plain text (not recommended for security reasons)
        $password = $req->password;

        // Create new user in users table with plain text password
        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => $password, // Store plain text password
            'phone_number' => $req->phone_number
        ]);

        // Create token for the newly registered user
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        // Return response with user data and token
        $response = ['user' => $user, 'token' => $token];
        return response()->json($response, 200);
    }


    public function login(Request $req)
{
    $rules = [
        'email' => 'required|string|email',
        'password' => 'required|string'
    ];
    $req->validate($rules);

    $user = User::where('email', $req->email)->first();

    if (!$user) {
        return response()->json(['message' => 'Incorrect email'], 400);  // Specific error for email
    }

    if ($user->password !== $req->password) {
        return response()->json(['message' => 'Incorrect password'], 400);  // Specific error for password
    }

    $token = $user->createToken('Personal Access Token')->plainTextToken;

    return response()->json(['user' => $user, 'token' => $token], 200);
}

}