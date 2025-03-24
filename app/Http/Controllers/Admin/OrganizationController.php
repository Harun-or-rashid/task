<?php

namespace App\Http\Controllers\Admin;

use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrganizationStoreRequest;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::paginate(10);
        return view('admin.organizations.list', compact('organizations'));
    }

    public function create()
    {
        return view('admin.organizations.index');
    }
    public function store(OrganizationStoreRequest $request)
    {
        try {
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move(public_path('organizationLogo'), $filename);
                $logoPath = 'organizationLogo/' . $filename;
            }
            Organization::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'postal_code' => $request->postal_code,
                'logo' => $logoPath,
                'description' => $request->description,
                'status' => $request->status ?? 'active',
            ]);
            return redirect()->back()->with('success', 'Organization created successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }

    }
    public function edit($id)
    {
        $organization = Organization::find($id);
        return view('admin.organizations.edit', compact('organization'));
    }
    public function update(OrganizationStoreRequest $request,$id)
    {
        try {
            $organization = Organization::find($id);
            $logoPath = $organization->logo;
            if ($request->hasFile('logo')) {
                if ($organization->logo && file_exists('organizationLogo/' . $organization->logo)) {
                    unlink('organizationLogo/' . $organization->logo);
                }
                $file = $request->file('logo');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move(public_path('organizationLogo'), $filename);
                $logoPath = 'organizationLogo/' . $filename;
            }
            $organization->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'postal_code' => $request->postal_code,
                'logo' => $logoPath,
                'description' => $request->description,
                'status' => $request->status ?? 'active',
            ]);
            return redirect()->back()->with('success', 'Organization updated successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function delete($id)
    {
        $organization = Organization::find($id);
        if ($organization->logo && file_exists('organizationLogo/'.$organization->logo)) {
            unlink('organizationLogo/'.$organization->logo);
        }
        $organization->delete();
        return redirect()->back()->with('success', 'Organization deleted successfully');
    }


}
