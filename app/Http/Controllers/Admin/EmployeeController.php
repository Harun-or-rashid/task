<?php

namespace App\Http\Controllers\Admin;

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
    public function index(Request $request)
    {
        $organizations = Organization::all();
        $teams = Team::all();
        $employees = Employee::query();
        if ($request->has('organization_id') && $request->organization_id != '') {
            $employees->where('organization_id', $request->organization_id);
        }
        if ($request->has('team_id') && $request->team_id != '') {
            $employees->where('team_id', $request->team_id);
        }
        $employees = $employees->get();
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
            Employee::create([
                'organization_id' => $request->organization_id,
                'team_id' => $request->team_id,
                'name' => $request->name,
                'email' => $request->email,
                'salary' => $request->salary,
                'start_date' => $request->start_date,
                'description' => $request->description,
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
        $employee = Employee::findOrFail($id);
        $organizations = Organization::all();
        $teams = Team::where('organization_id', $employee->organization_id)->get();

        return view('admin.employee.edit', compact('employee', 'organizations', 'teams'));
    }

    public function update(EmployeeStoreAndUpdateRequest $request, $id)
    {
        try {
            $employee = Employee::find($id);
            $employee->update([
                'organization_id' => $request->organization_id,
                'team_id' => $request->team_id,
                'name' => $request->name,
                'email' => $request->email,
                'salary' => $request->salary,
                'start_date' => $request->start_date,
                'description' => $request->description,
            ]);

            return redirect()->route('list.employee')->with('success', 'Employee updated successfully.');
        } catch (Exception $e) {
            // Log Error
            Log::error('Employee Update Error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function delete($id)
    {
        try {
            $employee = Employee::find($id);
            $employee->delete();

            return redirect()->back()->with('success', 'Employee deleted successfully.');
        } catch (Exception $e) {
            Log::error('Employee Delete Error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }

}
