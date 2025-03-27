@extends('admin.layout.master')
@section('title', 'Employee-Edit')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Employee</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Create Employee</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('store.employee') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Organization Dropdown -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="organization_id">Organization</label>
                            <select class="form-control @error('organization_id') is-invalid @enderror" name="organization_id" id="organization_id">
                                <option disabled selected>Select Organization</option>
                                @foreach ($organizations as $organization)
                                    <option value="{{ $organization->id }}" {{ old('organization_id') == $organization->id ? 'selected' : '' }}>
                                        {{ $organization->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('organization_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Team Dropdown -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="team_id">Team</label>
                            <select class="form-control @error('team_id') is-invalid @enderror" name="team_id" id="team_id">
                                <option disabled selected>Select Team</option>
                            </select>
                            @error('team_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Name Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Employee Name">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Enter Employee Email">
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Salary Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="salary">Salary</label>
                            <input type="number" class="form-control @error('salary') is-invalid @enderror" id="salary" name="salary" value="{{ old('salary') }}" placeholder="Enter Salary">
                            @error('salary')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Start Date Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}">
                            @error('start_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>

                    <!-- Description Field -->
                    <div class="form-group col-md-12">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
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
                        $('#team_id').append('<option disabled selected>Select Team</option>');
                        $.each(data, function(key, value) {
                            $('#team_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#team_id').empty();
                $('#team_id').append('<option disabled selected>Select Team</option>');
            }
        });
    });
</script>
@endsection
