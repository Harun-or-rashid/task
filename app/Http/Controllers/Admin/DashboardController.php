<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use ringku\PdfGenerator\Facades\PdfGenerator;

class DashboardController extends Controller
{
    public function dashboard(){

        return view('admin.index');
    }
}
