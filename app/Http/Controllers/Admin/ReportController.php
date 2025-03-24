<?php

namespace App\Http\Controllers\Admin;

use App\Models\Team;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function teamSalaryReport(){
        $teams = Team::withAvg('employees', 'salary')->paginate(20);
        return view('admin.reports.teamSalary', compact('teams'));
    }

    public function organizationEmployeeCount(){
        $organizations = Organization::withCount('employees')->paginate(20);
        return view('admin.reports.organizeEmployee', compact('organizations'));
    }
}
