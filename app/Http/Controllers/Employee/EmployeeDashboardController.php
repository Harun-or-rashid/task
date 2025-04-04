<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeDashboardController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();

        return view('employee.index',compact('user'));
    }
}
