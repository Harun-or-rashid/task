<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Team;
use App\Models\User;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Events\EmployeeImportStarted;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Admin\EmployeeStoreAndUpdateRequest;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        try {
        $organizations = Organization::all();
        $teams = Team::all();

        $employeesQuery = User::with(['organization', 'team']);

        if ($request->filled('organization_id')) {
            $employeesQuery->where('organization.organization_id', $request->organization_id);
        }

        if ($request->filled('team_id')) {
            $employeesQuery->where('team.team_id', $request->team_id);
        }

        if ($request->filled('start_date')) {
            $employeesQuery->filterByStartDate($request->start_date);
        }

        $employees = $employeesQuery->paginate(10);

        return response()->json([
            'data' => $employees->items(),
            'pagination' => [
                'total' => $employees->total(),
                'per_page' => $employees->perPage(),
                'current_page' => $employees->currentPage(),
                'last_page' => $employees->lastPage(),
                'from' => $employees->firstItem(),
                'to' => $employees->lastItem(),
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'An error occurred while fetching the employee list.',
            'message' => $e->getMessage()
        ], 500);
    }
    }

    public function store(EmployeeStoreAndUpdateRequest $request)
    {
        try {
            $employee = User::create([
                'organization_id' => $request->organization_id,
                'team_id' => $request->team_id,
                'name' => $request->name,
                'email' => $request->email,
                'salary' => $request->salary,
                'start_date' => $request->start_date,
                'role'      => 'User',
                'description' => $request->description,
                'password' => Hash::make($request->password),
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
            $employee = User::find($id);

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
            $employee = User::find($id);

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
            $employee = User::find($id);

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
            $employees = User::where('organization_id', $organization_id)->get();
            return response()->json(['success' => true, 'employees' => $employees], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function getEmployeesByTeam($team_id)
    {
        try {
            $employees = User::where('team_id', $team_id)->get();
            return response()->json(['success' => true, 'employees' => $employees], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function managerCreate()
    {
        try {
            $organizations = Organization::all();
            return response()->json(['organizations' => $organizations], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve organizations', 'message' => $e->getMessage()], 500);
        }
    }
    public function managerStore(Request $request)
    {
        try {
            $validated = $request->validate([
                'organization_id' => 'nullable|exists:organizations,id',
                'team_id' => 'nullable',
                'user_id' => 'required|exists:users,id',
                'password' => 'required|confirmed|min:8',
                'manage_organization' => 'nullable|boolean',
                'manage_team' => 'nullable|boolean',
                'manage_employee' => 'nullable|boolean',
                'manage_report' => 'nullable|boolean',
            ]);
            $employee = new Admin();
            $user = User::find($request->user_id);
            $employee->employee_id = $request->user_id;
            $employee->name = $user->name;
            $employee->email = $request->email;
            $employee->role = 'Manager';
            $employee->password = Hash::make($request->password);
            $employee->manage_organization = $request->has('manage_organization') ? 1 : 0;
            $employee->manage_team = $request->has('manage_team') ? 1 : 0;
            $employee->manage_employee = $request->has('manage_employee') ? 1 : 0;
            $employee->manage_report = $request->has('manage_report') ? 1 : 0;
            $employee->save();

            return response()->json(['message' => 'Manager created successfully!'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create manager', 'message' => $e->getMessage()], 500);
        }
    }
    public function manegerList()
    {
        try {
            $managers = Admin::where('role', 'Manager')->get();
            return response()->json(['success' => true, 'data' => $managers], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching managers: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error fetching managers'], 500);
        }
    }

    public function manegerEdit($id)
    {
        try {
            $organizations = Organization::all();
            $manager = Admin::where('role', 'Manager')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => compact('manager', 'organizations')
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching manager details: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Manager not found'], 404);
        }
    }

    public function manegerUpdate(Request $request, $id)
    {
        try {
            $request->validate([
                'organization_id' => 'nullable',
                'team_id' => 'nullable',
                'user_id' => 'required',
                'password' => 'nullable|confirmed|min:8',
                'manage_organization' => 'nullable|boolean',
                'manage_team' => 'nullable|boolean',
                'manage_employee' => 'nullable|boolean',
                'manage_report' => 'nullable|boolean',
            ]);

            $manager = Admin::findOrFail($id);
            $user = User::findOrFail($request->user_id);

            $manager->employee_id = $request->user_id;
            $manager->name = $user->name;
            $manager->email = $request->email ?? $manager->email;

            if ($request->filled('password')) {
                $manager->password = Hash::make($request->password);
            }

            $manager->manage_organization = $request->boolean('manage_organization');
            $manager->manage_team = $request->boolean('manage_team');
            $manager->manage_employee = $request->boolean('manage_employee');
            $manager->manage_report = $request->boolean('manage_report');

            $manager->save();

            return response()->json([
                'success' => true,
                'message' => 'Manager updated successfully',
                'data' => $manager
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating manager: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error updating manager'], 500);
        }
    }

    public function manegerDelete($id)
    {
        try {
            $manager = Admin::findOrFail($id);
            $manager->delete();

            return response()->json(['success' => true, 'message' => 'Manager deleted successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting manager: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error deleting manager'], 500);
        }
    }
    public function importEmployees(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:json|max:10240',
            ]);

            $file = $request->file('file')->storeAs('employee_imports', 'employees.json');

            event(new EmployeeImportStarted($file));

            return response()->json([
                'message' => 'Employee import started!',
                'file_path' => Storage::url($file)
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $e->getMessage(),
                'details' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Something went wrong!',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
