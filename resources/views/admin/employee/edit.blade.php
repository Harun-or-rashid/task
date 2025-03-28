@extends('admin.layout.master')
@section('title', 'Edit Employee')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Employee</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Employee</h6>
        </div>
        <div class="card-body">
            <form action="{{route('update.employee',$employee->id)}}" method="POST">
                @csrf

                <div class="row">
                    <!-- Organization Dropdown -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="organization_id">Organization</label>
                            <select class="form-control" name="organization_id" id="organization_id">
                                <option disabled>Select Organization</option>
                                @foreach ($organizations as $organization)
                                    <option value="{{ $organization->id }}" {{ $organization->id == $employee->organization_id ? 'selected' : '' }}>
                                        {{ $organization->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Team Dropdown -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="team_id">Team</label>
                            <select class="form-control" name="team_id" id="team_id">
                                <option disabled>Select Team</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}" {{ $team->id == $employee->team_id ? 'selected' : '' }}>
                                        {{ $team->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Employee Details -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $employee->name }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $employee->email }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="salary">Salary</label>
                            <input type="number" class="form-control" id="salary" name="salary" value="{{ $employee->salary }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $employee->start_date }}" required>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ $employee->description }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#organization_id').change(function() {
            var organizationId = $(this).val();
            if (organizationId) {
                $.ajax({
                    url: "{{ url('admin/get-teams') }}/" + organizationId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#team_id').empty();
                        $('#team_id').append('<option disabled>Select Team</option>');
                        $.each(data, function(key, value) {
                            $('#team_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#team_id').empty();
                $('#team_id').append('<option disabled>Select Team</option>');
            }
        });
    });
</script>
@endsection
