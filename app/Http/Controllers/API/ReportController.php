<?php

namespace App\Http\Controllers\API;

use App\Models\Team;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ringku\PdfGenerator\Facades\PdfGenerator;

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
    public function teamSalaryReportpdf($id)
    {
        try {
            $team = Team::findOrFail($id);
            $employees = User::where('team_id', $team->id)->get();

            $data = collect([
                [
                    'name' => 'Name',
                    'email' => 'Email',
                    'salary' => 'Salary',
                    'role' => 'Role',
                    'team' => 'Team',
                ]
            ])->merge(
                $employees->map(function ($employee) use ($team) {
                    return [
                        'name' => $employee->name,
                        'email' => $employee->email,
                        'salary' => $employee->salary,
                        'role' => $employee->role,
                        'team' => $team->name,
                    ];
                })
            );

            return PdfGenerator::setData($data)
                ->setTemplate('pdf-generator::default')
                ->setOptions(['title' => 'Employee List'])
                ->generate();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate PDF report',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function generatePDF($id)
{
    try {
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

        return  PdfGenerator::setData($data)
            ->setTemplate('pdf-generator::default')
            ->setOptions(['title' => 'Employee List'])
            ->generate();

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to generate PDF report',
            'error' => $e->getMessage(),
        ], 500);
    }
}



}
