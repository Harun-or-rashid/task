@extends('admin.layout.master')
@section('title', 'Team-Create')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Teams </h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Create</h6>
        </div>
        <div class="card-body">
            <form action="{{route('update.team', $team->id)}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Organization</label>
                            <select class="form-control" name="organization_id" id="organization_id">
                                <option disabled selected>select Organization</option>
                                @foreach ($organizations as $organization)
                                    <option value="{{ $organization->id }}" {{ isset($team) && $team->organization_id == $organization->id ? 'selected' : '' }}>
                                        {{ $organization->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Team Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $team->name }}" placeholder="Enter Team Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Status Field -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="active" {{ $team->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $team->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Description Field -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Description">{{ $team->description }}</textarea>
                </div>
                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection

