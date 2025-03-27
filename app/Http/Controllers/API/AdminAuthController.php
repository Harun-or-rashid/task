<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\AdminLoginRequest;

class AdminAuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(AdminLoginRequest $request)
    {
        $token = $this->authService->login($request->validated());
        if (!$token) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        return response()->json([
            'token' => $token,
            'redirect_url' => url('/dashboard')
        ], 200);
    }
    public function userLogin(Request $request)
    {
            $request->validate([
                'email' =>'required',
                'password' =>'required',
            ]);
            $user = User::where('email', $request->email)->first();

            if(!$user || !Hash::check($request->password,$user->password)){
                return [
                    'errors' => [
                        'email' => [' the credential are incorrect']
                    ]
                ];
            }
            $token = $user->createToken($user->name);
            return [
                'user' => $user,
                'token' => $token->plainTextToken,
            ];
    }
    public function logout(Request $request)
    {
        $admin = $request->user('admin');

        if ($admin) {
            $admin->tokens->each(function ($token) {
                $token->delete();
            });

            return response()->json(['message' => 'Successfully logged out'], 200);
        }

        return response()->json(['message' => 'No admin user authenticated'], 401);
    }


}
