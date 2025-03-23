<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login(array $data)
    {
        $admin = Admin::where('email', $data['email'])->first();

        if (!$admin || !Hash::check($data['password'], $admin->password)) {
            return null;
        }

        return $admin->createToken('admin_auth_token')->plainTextToken;
    }
}
