<?php

namespace App\Http\Controllers\API;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeamStoreAndUpdateRequest;
use Exception;

class TeamController extends Controller
{
    public function index()
    {
        try {
            $teams = Team::all();
            return response()->json($teams, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function store(TeamStoreAndUpdateRequest $request)
    {
        try {
            $team = Team::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Team created successfully',
                'team' => $team
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to create team'], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $team = Team::find($id);

            if (!$team) {
                return response()->json(['message' => 'Team not found'], 404);
            }

            return response()->json([
                'success' => true,
                'team' => $team
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function update(TeamStoreAndUpdateRequest $request, string $id)
    {
        try {
            $team = Team::find($id);

            if (!$team) {
                return response()->json(['message' => 'Team not found'], 404);
            }

            $team->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Team updated successfully',
                'team' => $team
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to update team'], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $team = Team::find($id);
            if (!$team) {
                return response()->json(['message' => 'Team not found'], 404);
            }

            $team->delete();

            return response()->json([
                'success' => true,
                'message' => 'Team deleted successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete team'], 500);
        }
    }

    public function getTeamsByOrganization($organization_id)
    {
        try {
            $teams = Team::where('organization_id', $organization_id)->get();
            return response()->json($teams, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
