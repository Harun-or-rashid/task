@extends('admin.layout.master')
@section('title', 'Edit Manager')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Edit Manager</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Manager</h6>
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

            <form action="{{ route('update.maneger', $manager->id) }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="organization_id">Organization</label>
                            <select class="form-control @error('organization_id') is-invalid @enderror" name="organization_id" id="organization_id">
                                <option disabled selected>Select Organization</option>
                                @foreach ($organizations as $organization)
                                    <option value="{{ $organization->id }}" {{ old('organization_id', $manager->organization_id) == $organization->id ? 'selected' : '' }}>
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
                                @if ($manager->organization)  <!-- Check if organization exists -->
                                    @foreach ($manager->organization->teams as $team)  <!-- Access teams only if organization exists -->
                                        <option value="{{ $team->id }}" {{ old('team_id', $manager->team_id) == $team->id ? 'selected' : '' }}>
                                            {{ $team->name }}
                                        </option>
                                    @endforeach
                                @endif
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
                                @if ($manager->team)  <!-- Check if team exists -->
                                    @foreach ($manager->team->users as $user)  <!-- Access users only if team exists -->
                                        <option value="{{ $user->id }}" {{ old('user_id', $manager->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>

                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email', $manager->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Fields -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Enter Your password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" placeholder="Enter confirm password">
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
                        <input type="checkbox" class="form-check-input" id="manage_organization" name="manage_organization" value="1" {{ old('manage_organization', $manager->manage_organization) ? 'checked' : '' }}>
                        <label class="form-check-label" for="manage_organization">Manage Organization</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="manage_team" name="manage_team" value="1" {{ old('manage_team', $manager->manage_team) ? 'checked' : '' }}>
                        <label class="form-check-label" for="manage_team">Manage Team</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="manage_employee" name="manage_employee" value="1" {{ old('manage_employee', $manager->manage_employee) ? 'checked' : '' }}>
                        <label class="form-check-label" for="manage_employee">Manage Employee</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="manage_report" name="manage_report" value="1" {{ old('manage_report', $manager->manage_report) ? 'checked' : '' }}>
                        <label class="form-check-label" for="manage_report">Manage Report</label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Manager</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
         // Load team data for the selected organization
         $('#organization_id').change(function() {
             var organizationId = $(this).val();
             $('#team_id').empty().append('<option disabled selected>Select Team</option>');
             $('#user_id').empty().append('<option disabled selected>Select User</option>');

             if (organizationId) {
                 $.ajax({
                     url: "{{ url('admin/get-teams') }}/" + organizationId,
                     type: "GET",
                     dataType: "json",
                     success: function(data) {
                         $.each(data, function(key, value) {
                             $('#team_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                         });

                         // Pre-select the team if it is already set
                         var teamId = "{{ old('team_id', $manager->team_id) }}";
                         if (teamId) {
                             $('#team_id').val(teamId);  // Set the selected team
                             $('#team_id').trigger('change');  // Trigger the change event to load users for the selected team
                         }
                     }
                 });
             }
         });

         // Load users based on the selected team
         $('#team_id').change(function() {
             var teamId = $(this).val();
             $('#user_id').empty().append('<option disabled selected>Select User</option>');

             if (teamId) {
                 $.ajax({
                     url: "{{ url('admin/get-users') }}/" + teamId,
                     type: "GET",
                     dataType: "json",
                     success: function(data) {
                         $.each(data, function(key, value) {
                             $('#user_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                         });

                         // Pre-select the user if it is already set
                         var userId = "{{ old('user_id', $manager->user_id) }}";
                         if (userId) {
                             $('#user_id').val(userId);  // Set the selected user
                         }
                     }
                 });
             }
         });

         // Trigger organization change to load teams and set the correct team/user values
         $('#organization_id').trigger('change');
     });
 </script>

@endsection
