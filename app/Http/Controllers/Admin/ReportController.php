<?php

namespace App\Http\Controllers\Admin;

use App\Models\Team;
use App\Models\User;
use App\Models\Organization;
use App\Http\Controllers\Controller;
use ringku\PdfGenerator\Facades\PdfGenerator;

class ReportController extends Controller
{
    public function teamSalaryReport()
    {
        $teams = Team::withAvg('employees', 'salary')
            ->paginate(20);
        return view('admin.reports.teamSalary', compact('teams'));
    }
    public function teamSalaryReportpdf($id)
    {
        $teams = Team::find($id);
        $employees = User::where('team_id', $teams->id)->get();
        $data = collect([
            [
                'name' => 'Name',
                'email' => 'Email',
                'salary' => 'Salary',
                'role' => 'Role',
                'team' => 'Team',
            ]
        ])->merge(
            $employees->map(function ($employee) use ($teams) {
                return [
                    'name' => $employee->name,
                    'email' => $employee->email,
                    'salary' => $employee->salary,
                    'role' => $employee->role,
                    'team' => $teams->name,
                ];
            })
        );
        return PdfGenerator::setData($data)
            ->setTemplate('pdf-generator::default')
            ->setOptions(['title' => 'Employee List'])
            ->generate();
    }

    public function organizationEmployeeCount(){
        $organizations = Organization::withCount('employees')->paginate(20);
        return view('admin.reports.organizeEmployee', compact('organizations'));
    }

    public function generatePDF($id)
    {
        $organization = Organization::findOrFail($id);
        $users = User::where('organization_id', $organization->id)->get();
        $data = collect([
            [
                'name' => 'Name',
                'email' => 'Email',
                'salary' => 'Salary',
                'role' => 'Role',
                'organization' => 'Organization',
            ]
        ])->merge(
            $users->map(function ($user) use ($organization) {
                return [
                    'name' => $user->name,
                    'email' => $user->email,
                    'salary' => $user->salary,
                    'role' => $user->role,
                    'organization' => $organization->name,
                ];
            })
        );
        return PdfGenerator::setData($data)
            ->setTemplate('pdf-generator::default')
            ->setOptions(['title' => 'Employee List'])
            ->generate();
        return PdfGenerator::setData($data)
            ->setTemplate('pdf-generator::default')
            ->download();
    }
}
