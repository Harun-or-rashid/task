@extends('admin.layout.master')
@section('title', 'Create-Maneger')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Maneger</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Create-Maneger</h6>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('store.maneger') }}" method="POST">

                @csrf
                <div class="row">
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
                                <div class="invalid-feedback">{{ $message }}</div>
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
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- User Dropdown -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="user_id">Users</label>
                            <select class="form-control @error('user_id') is-invalid @enderror" name="user_id" id="user_id">
                                <option disabled selected>Select User</option>
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Enter Your email" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Fields -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Enter Your password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" placeholder="Enter confirm password" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Permissions -->
                <div class="form-group">
                    <label>Permissions</label><br>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="manage_organization" name="manage_organization" value="1" {{ old('manage_organization') ? 'checked' : '' }}>
                        <label class="form-check-label" for="manage_organization">Manage Organization</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="manage_team" name="manage_team" value="1" {{ old('manage_team') ? 'checked' : '' }}>
                        <label class="form-check-label" for="manage_team">Manage Team</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="manage_employee" name="manage_employee" value="1" {{ old('manage_employee') ? 'checked' : '' }}>
                        <label class="form-check-label" for="manage_employee">Manage Employee</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="manage_report" name="manage_report" value="1" {{ old('manage_report') ? 'checked' : '' }}>
                        <label class="form-check-label" for="manage_report">Manage Report</label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create Manager</button>
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
        $('#team_id').empty().append('<option disabled selected>Select Team</option>');
        $('#user_id').empty().append('<option disabled selected>Select User</option>');

        if (organizationId) {
            // Fetch Teams Based on Organization
            $.ajax({
                url: "{{ url('admin/get-teams') }}/" + organizationId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $.each(data, function(key, value) {
                        $('#team_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        }
    });

    $('#team_id').change(function() {
        var teamId = $(this).val();
        $('#user_id').empty().append('<option disabled selected>Select User</option>');

        if (teamId) {
            // Fetch Users Based on Team
            $.ajax({
                url: "{{ url('admin/get-users') }}/" + teamId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $.each(data, function(key, value) {
                        $('#user_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        }
    });
});

</script>

@endsection
