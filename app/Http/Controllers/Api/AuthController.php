<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login' , 'register']]);
    }

    public function login(LoginRequest $request)
    {
        try {
            // Logic for user login
            $validatedData = $request->validated();
            $credentials = ['email' => $validatedData['email'], 'password' => $validatedData['password']];
            $token = Auth::guard('api')->attempt($credentials);
            if (!$token) {
                return response()->json(['status' => "false", 'message' => __('apiValidation.Something went wrong')], 400);
            }
            $user = Auth::guard('api')->user();
            return response()->json(["status" => "true", "data" => ["user" => $user, "token" => $token]], 200);
        } catch (Exception $e) {
            return response()->json(['status' => "false", 'message' => __('apiValidation.Something went wrong')], 500);
        }
    }


    public function register(RegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $validatedData['password'] = bcrypt($validatedData['password']);
            $validatedData['email_verified_at'] = now(); 
            unset($validatedData['password_confirmation']); // 
            
            $user = User::create($validatedData);
            $token = Auth::guard('api')->login($user);
            return response()->json(['status' => "true", 'data' => $user,'token' => $token], 201);
        } catch (Exception $e) {
            return response()->json(['status' => "false", 'message' => __($e->getMessage() ?? 'apiValidation.Something went wrong')], 500);
        }
    }

    public function profile(Request $request)
    {
        try {
            $user = Auth::guard('api')->user();
            if (!$user) {
                return response()->json(['status' => "false", 'message' => __('apiValidation.Unauthenticated user')], 401);
            }
            return response()->json(['status' => "true", 'data' => $user], 200);
        } catch (Exception $e) {
            return response()->json(['status' => "false", 'message' => __('apiValidation.Something went wrong')], 500);
        }
    }

    public function update(UpdateRequest $request)
    {
        try {
            $user = Auth::guard('api')->user();
            if (!$user) {
                return response()->json(['status' => "false", 'message' => __('apiValidation.Unauthenticated user')], 401);
            }
            $validatedData = $request->validated();
            $user->update($validatedData);
            return response()->json(['status' => "true", 'data' => $user], 200);
        } catch (Exception $e) {
            return response()->json(['status' => "false", 'message' => __('apiValidation.Something went wrong')], 500);
        }

    }

    public function logout(Request $request)
    {
        try {
            Auth::guard('api')->logout();
            return response()->json(['status' => "true", 'message' => __('apiValidation.Logout successful')], 200);
        } catch (Exception $e) {
            return response()->json(['status' => "false", 'message' => __('apiValidation.Something went wrong')], 500);
        }
    }
}