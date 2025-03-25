<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Team;
use App\Models\User;
use App\Models\Employee;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\EmployeeStoreAndUpdateRequest;
use App\Models\Admin;

class EmployeeController extends Controller
{

    // public function index(Request $request)
    // {
    //     $organizations = Organization::all();
    //     $teams = Team::all();
    //     $employees = Employee::query();
    //     if ($request->has('organization_id') && $request->organization_id != '') {
    //         $employees->where('organization_id', $request->organization_id);
    //     }
    //     if ($request->has('team_id') && $request->team_id != '') {
    //         $employees->where('team_id', $request->team_id);
    //     }
    //     $employees = $employees->get();
    //     return view('admin.employee.list', compact('employees', 'organizations', 'teams'));
    // }
    public function index(Request $request)
{
    $organizations = Organization::all();
    $teams = Team::all();

    $employeesQuery = User::query();

    if ($request->has('organization_id') && $request->organization_id != '') {
        $employeesQuery->where('organization_id', $request->organization_id);
    }

    if ($request->has('team_id') && $request->team_id != '') {
        $employeesQuery->where('team_id', $request->team_id);
    }

    $employees = collect();
    $employeesQuery->chunk(50, function ($chunk) use (&$employees) {
        $employees = $employees->merge($chunk);
    });

    return view('admin.employee.list', compact('employees', 'organizations', 'teams'));
}

    public function create()
    {
        $organizations = Organization::all();
        return view('admin.employee.create', compact('organizations'));
    }
    public function store(EmployeeStoreAndUpdateRequest $request)
    {
        try {
            User::create([
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

            return redirect()->back()->with('success', 'Employee created successfully.');
        } catch (Exception $e) {
            // Log Error
            Log::error('Employee Store Error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }
    public function edit($id)
    {
        $employee = User::findOrFail($id);
        $organizations = Organization::all();
        $teams = Team::where('organization_id', $employee->organization_id)->get();

        return view('admin.employee.edit', compact('employee', 'organizations', 'teams'));
    }

    public function update(EmployeeStoreAndUpdateRequest $request, $id)
    {
        try {
            $employee = User::find($id);

            $data = [
                'organization_id' => $request->organization_id,
                'team_id' => $request->team_id,
                'name' => $request->name,
                'email' => $request->email,
                'salary' => $request->salary,
                'start_date' => $request->start_date,
                'description' => $request->description,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $employee->update($data);

            return redirect()->route('list.employee')->with('success', 'Employee updated successfully.');
        } catch (Exception $e) {
            Log::error('Employee Update Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }


    public function delete($id)
    {
        try {
            $employee = User::find($id);
            $employee->delete();

            return redirect()->back()->with('success', 'Employee deleted successfully.');
        } catch (Exception $e) {
            Log::error('Employee Delete Error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function manegerCreate()
    {
        $organizations = Organization::all();
        return view('admin.maneger.create', compact('organizations'));
    }
    public function manegerStore(Request $request)
{
    try {
        $request->validate([
            'organization_id' => 'nullable',
            'team_id' => 'nullable',
            'user_id' => 'required',
            'password' => 'required|confirmed|min:8',
            'manage_organization' => 'nullable|boolean',
            'manage_team' => 'nullable|boolean',
            'manage_employee' => 'nullable|boolean',
            'manage_report' => 'nullable|boolean',
        ]);

        $employee = new Admin();
        $employee->employee_id = $request->user_id;
        $employee->name = User::find($request->user_id)->name;
        $employee->email = $request->email;
        $employee->role = 'Manager';
        $employee->password = Hash::make($request->password);
        $employee->manage_organization = $request->has('manage_organization') ? 1 : 0;
        $employee->manage_team = $request->has('manage_team') ? 1 : 0;
        $employee->manage_employee = $request->has('manage_employee') ? 1 : 0;
        $employee->manage_report = $request->has('manage_report') ? 1 : 0;
        $employee->save();

        return redirect()->route('create.maneger')->with('success', 'Manager created successfully!');
    } catch (\Exception $e) {
        \Log::error('Error creating manager: ' . $e->getMessage());

        return redirect()->route('create.maneger')->with('error', 'An error occurred while creating the manager. Please try again.');
    }
}

    public function manegerList(){
        $managers = Admin::where('role', 'Manager')->get();
        return view('admin.maneger.list', compact('managers'));
    }
    public function manegerEdit($id)
    {
        $organizations = Organization::all();
        $manager = Admin::where('role', 'Manager')->find($id);
        return view('admin.maneger.edit', compact('manager', 'organizations'));
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

            $employee = Admin::findOrFail($id);
            $employee->employee_id = $request->user_id;
            $employee->name = User::find($request->user_id)->name;
            $employee->email = $request->email;

            if ($request->filled('password')) {
                $employee->password = Hash::make($request->password);
            }

            $employee->manage_organization = $request->has('manage_organization') ? 1 : 0;
            $employee->manage_team = $request->has('manage_team') ? 1 : 0;
            $employee->manage_employee = $request->has('manage_employee') ? 1 : 0;
            $employee->manage_report = $request->has('manage_report') ? 1 : 0;

            $employee->update();

            return redirect()->route('list.maneger')->with('success', 'Manager updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Error updating manager: ' . $e->getMessage());

            return redirect()->route('create.manager')->with('error', 'An error occurred while updating the manager. Please try again.');
        }
    }
    public function manegerDelete($id)
    {
        try {
            $manager = Admin::findOrFail($id);
            $manager->delete();

            return redirect()->back()->with('success', 'Manager deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Error deleting manager: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while deleting the manager. Please try again.');
        }


    }


}
