<?php

namespace App\Http\Controllers\Admin;

use App\Models\Team;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeamStoreAndUpdateRequest;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::cursorPaginate(10);
        return view('admin.team.index', compact('teams'));
    }

    public function create()
    {
        $organizations = Organization::all();
        return view ('admin.team.create', compact('organizations'));
    }
    public function store(TeamStoreAndUpdateRequest $request)
{
    try {
        $team = Team::create([
            'organization_id' => $request->organization_id,
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('list.team')->with('success', 'Team created successfully');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Something went wrong');
    }
}


    public function edit($id)
    {
        $team = Team::find($id);
        $organizations = Organization::all();
        return view('admin.team.edit', compact('team', 'organizations'));
    }
    public function update(TeamStoreAndUpdateRequest $request,$id)
    {
        $team = Team::find($id);
        $team->organization_id = $request->organization_id;
        $team->name = $request->name;
        $team->description = $request->description;
        $team->status = $request->status;
        $team->update();
        return redirect()->route('list.team')->with('success', 'Team updated successfully');
    }
    public function delete($id)
    {
        $team = Team::find($id);
        $team->delete();
        return redirect()->route('list.team')->with('success', 'Team delete successfully');
    }

    public function getTeams($organization_id)
    {
        $teams = Team::where('organization_id', $organization_id)->get();
        return response()->json($teams);
    }
    public function getUsers($team_id)
    {
        $users = User::where('team_id', $team_id)->get();
        return response()->json($users);
    }

}
