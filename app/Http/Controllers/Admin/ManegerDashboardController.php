<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ManegerDashboardController extends Controller
{
    public function dashboard(){
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();

            if ($user->role === 'Manager') {
                $permissions = [
                    'manage_organization' => $user->manage_organization,
                    'manage_team' => $user->manage_team,
                    'manage_employee' => $user->manage_employee,
                    'manage_report' => $user->manage_report,
                ];

                return view('employee.index', compact('permissions'));
            } elseif ($user->role === 'Manager') {
                return redirect()->route('dashboard');
            } else {
                abort(403, 'Unauthorized access');
            }
        }

        return redirect()->route('admin.login')->with(['error' => 'Please login first']);
    }
}
