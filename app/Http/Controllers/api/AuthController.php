<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signUp(SignUpRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);
            $token = $user->createToken('auth-token')->plainTextToken;
            return response()->json([
                'data' => new UserResource($user),
                'token' => $token,
                'message' => "Register successful 😉",
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => "Somthing went wrong !"],400);
        }
    }
    public function signIn(SignInRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Invalid credentials'],400);
            }
            $token = $user->createToken('auth-token')->plainTextToken;
            return response()->json([
                'data' => new UserResource($user),
                'token' => $token,
                'message' => 'Login successful 🫡',
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => "Somthing went wrong !"],400);
        }
    }

    public function signOut(Request $request) {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => "Sign Out Successfully, will miss you 🥲"]);
        } catch (\Throwable $th) {
            return response()->json(['message' => "Somthing went wrong !"],400);
        }
    }
}
