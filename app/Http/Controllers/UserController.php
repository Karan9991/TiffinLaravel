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
        // $user = new User();
        // $user->name = $request->input('name');
        // $user->email = $request->input('email');
        // $user->password = Hash::make($request->input('password'));
        // $user->address = $request->input('address');
        // $user->user_type = $request->input('user_type');
        // $user->save();

        // // Return a response with the newly created user's data
        // return response()->json([
        //     'success' => true,
        //     'user' => $user
        // ], 201);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'address' => 'nullable',
            'user_type' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'address' => $request->address,
            'user_type' => $request->user_type,
        ]);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $credentials['email'])->first();
            $token = $user->createToken('authToken')->accessToken;
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
}
