<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Helpers\isExist;

class UserController extends Controller
{
    //register
    public function register(Request $request)
    {
        // validate request, if email and username is not unique, return 409
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'username' => 'required',
        ]);

        if (isExist::isExist('User', 'email', $request->email)) {
            return response()->json([
                'message' => 'Email already exist'
            ], 409);
        }
        else if (isExist::isExist('User', 'username', $request->username)) {
            return response()->json([
                'message' => 'Username already exist'
            ], 409);
        }
        

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password,
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    //login
    public function login(Request $request)
    {

        //  if remember me token is exist
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials, $request->remember)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();

        $tokenResult = $user->createToken('authToken')->plainTextToken;

        

        return response()->json([
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    function isLoggedIn(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'user' => $user
        ]);
    }

    function logout(Request $request)
    {


        $request->user()->tokens()->delete();
        Auth::logout();
        return response()->json([
            'message' => 'Logged out'
        ]);
    }

    function adminPage(Request $request)
    {
        return response()->json([
            'message' => 'Admin page'
        ]);
    }
}
