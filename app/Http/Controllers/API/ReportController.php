<?php

namespace App\Http\Controllers\API;

use App\Models\Team;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function teamSalaryReport()
    {
        $teams = Team::withAvg('employees', 'salary')->get();
        return response()->json($teams);
    }

    public function organizationEmployeeCount()
    {
        $organizations = Organization::withCount('employees')->get();
        return response()->json($organizations);
    }
}
