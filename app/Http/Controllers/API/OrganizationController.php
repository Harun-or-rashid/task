<?php

namespace App\Http\Controllers\API;

use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use Exception;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $organizations = Organization::all();
            return response()->json(['organizations' => $organizations], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'nullable|email',
                'phone' => 'nullable|string',
                'address' => 'nullable|string',
                'city' => 'nullable|string',
                'state' => 'nullable|string',
                'country' => 'nullable|string',
                'postal_code' => 'nullable|string',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'description' => 'nullable|string',
                'status' => 'nullable|string',
            ]);

            // Handle file upload
            if ($request->hasFile('logo')) {
                $validatedData['logo'] = $request->file('logo')->store('organizationLogo', 'public');
            }

            $organization = Organization::create($validatedData);
            return response()->json(['organization' => $organization], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $organization = Organization::findOrFail($id);
            return response()->json(['organization' => $organization], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $organization = Organization::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'sometimes|string',
                'email' => 'sometimes|email',
                'phone' => 'sometimes|string',
                'address' => 'sometimes|string',
                'city' => 'sometimes|string',
                'state' => 'sometimes|string',
                'country' => 'sometimes|string',
                'postal_code' => 'sometimes|string',
                'logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'description' => 'sometimes|string',
                'status' => 'sometimes|string',
            ]);

            // Handle file upload
            if ($request->hasFile('logo')) {
                if ($organization->logo) {
                    Storage::disk('public')->delete($organization->logo);
                }
                $validatedData['logo'] = $request->file('logo')->store('organizationLogo', 'public');
            }

            $organization->update($validatedData);
            return response()->json(['organization' => $organization], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $organization = Organization::findOrFail($id);

            // Delete logo if exists
            if ($organization->logo) {
                Storage::disk('public')->delete($organization->logo);
            }

            $organization->delete();
            return response()->json(['message' => 'Organization deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
