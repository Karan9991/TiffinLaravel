<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'user_type' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_type' => $request->user_type,
        ]);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }
    

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $credentials['email'])->first();
            $token = $request->user()->createToken('auth_token')->plainTextToken;
            return response()->json([
                'success' => true,
                'message' => 'Login successful!',
                'user' => $user,
                'access_token' => $token,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid login details',
            ]);
        }
    }

    public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'success' => true,
        'message' => 'Logout successful!',
    ]);
}

public function getUserById($id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User not found'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $user
    ]);
}

    public function getAllUsers()
    {
        $user = User::all();

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function getAllCustomers()
{
    $customers = User::where('user_type', 'Customer')->get();

    return response()->json([
        'success' => true,
        'data' => $customers
    ]);
}
public function getAllSellers()
{
    $customers = User::where('user_type', 'Seller')->get();

    return response()->json([
        'success' => true,
        'data' => $customers
    ]);
}

}
