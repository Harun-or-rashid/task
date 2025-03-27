<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }
    public function submitLogin(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            return redirect()->route('dashboard');
        }
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        try {
            $user = Admin::where('email', $request->email)->first();
            if (!$user) {
                throw new \Exception('Email not found');
            }
            if (!Hash::check($request->password, $user->password)) {
                throw new \Exception('Password is incorrect');
            }
            $remember = $request->remember_me ? true : false;
            auth()->guard('admin')->login($user, $remember);
            return redirect()->route('dashboard')->with(['success' => 'Login successfully']);
        } catch (\Exception $exception) {
            return redirect()->back()->with(['error' => $exception->getMessage()]);
        }
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully');
    }

}
