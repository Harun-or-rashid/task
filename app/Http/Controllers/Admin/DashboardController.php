<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(){

        return view('admin.index');
    }
    public function organizations(){
        return view('admin.organizations.index');
    }
    public function organizationList(){
        return view('admin.organizations.list');
    }
}
