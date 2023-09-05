<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'string'],
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status_error' => true,
                'message' => $validator->errors(),
            ]);
        }

        $payload = [
            'uuid' => Uuid::uuid4()->toString(),
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ];

        if ($userData = User::create($payload)) {
            Auth::login($userData);
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            $userReturn = User::where('uuid', $user->uuid)->first();
            return response()->json([
                'status_error' => false,
                'message' => 'Registration Successful',
                'user' => $userReturn,
                'token' => $token
            ]);
        }


        return response()->json([
            'status_error' => true,
            'message' => 'Registration Failed',
        ]);
    }
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status_error' => true,
                'message' => $validator->errors(),
            ]);
        }

        $payload = [
            'email' => $request->email,
            'password' => $request->password
        ];

        try {
            Auth::attempt($payload);
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status_error' => false,
                'message' => 'Login success',
                'user' => $user,
                'token' => $token,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status_error' => true,
                'message' => 'Email or password salah',
            ]);
        }
    }

    public function logout(Request $request)
    {
        if (Auth::user()->tokens()->delete()) {
            return response()->json([
                'status_error' => false,
                'message' => 'Logout Successful',
            ]);
        }

        return response()->json([
            'status_error' => true,
            'message' => 'Logout Failed',
        ]);
    }
}
