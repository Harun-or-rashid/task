<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Team;
use App\Models\Employee;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeStoreAndUpdateRequest;

class EmployeeController extends Controller
{
    public function index()
    {
        try {
            $employees = Employee::all();
            return response()->json(['success' => true, 'employees' => $employees], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function store(EmployeeStoreAndUpdateRequest $request)
    {
        try {
            $employee = Employee::create([
                'organization_id' => $request->organization_id,
                'team_id' => $request->team_id,
                'name' => $request->name,
                'email' => $request->email,
                'salary' => $request->salary,
                'start_date' => $request->start_date,
                'description' => $request->description,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Employee created successfully',
                'employee' => $employee
            ], 201);
        } catch (Exception $e) {
            Log::error('Employee Store Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create employee'], 500);
        }
    }

    public function show($id)
    {
        try {
            $employee = Employee::find($id);

            if (!$employee) {
                return response()->json(['message' => 'Employee not found'], 404);
            }

            return response()->json([
                'success' => true,
                'employee' => $employee
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function update(EmployeeStoreAndUpdateRequest $request, $id)
    {
        try {
            $employee = Employee::find($id);

            if (!$employee) {
                return response()->json(['message' => 'Employee not found'], 404);
            }

            $employee->update([
                'organization_id' => $request->organization_id,
                'team_id' => $request->team_id,
                'name' => $request->name,
                'email' => $request->email,
                'salary' => $request->salary,
                'start_date' => $request->start_date,
                'description' => $request->description,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Employee updated successfully',
                'employee' => $employee
            ], 200);
        } catch (Exception $e) {
            Log::error('Employee Update Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update employee'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $employee = Employee::find($id);

            if (!$employee) {
                return response()->json(['message' => 'Employee not found'], 404);
            }

            $employee->delete();

            return response()->json([
                'success' => true,
                'message' => 'Employee deleted successfully'
            ], 200);
        } catch (Exception $e) {
            Log::error('Employee Delete Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete employee'], 500);
        }
    }

    public function getEmployeesByOrganization($organization_id)
    {
        try {
            $employees = Employee::where('organization_id', $organization_id)->get();
            return response()->json(['success' => true, 'employees' => $employees], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function getEmployeesByTeam($team_id)
    {
        try {
            $employees = Employee::where('team_id', $team_id)->get();
            return response()->json(['success' => true, 'employees' => $employees], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
