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
            <form action="{{route('store.team')}}" method="POST"  enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Organization</label>
                            <select class="form-control" name="organization_id" id="organization_id">
                                <option disabled selected>select Organization</option>
                                @foreach ($organizations as $organization)
                                    <option value="{{$organization->id}}">{{$organization->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Team Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Team Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Status Field -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Description Field -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Description"></textarea>
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

