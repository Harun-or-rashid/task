@extends('admin.layout.master')
@section('title', 'Employee-List')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Employee Tables</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables</h6>
        </div>
        <div class="card-body">
            <!-- Dropdown Filters -->
            <form method="GET" action="{{ route('list.employee') }}" class="mb-4">
                <div class="form-row">
                    <div class="col-md-4">
                        <select name="organization_id" id="organization_id" class="form-control">
                            <option value="" disabled selected>Select Organization</option>
                            @foreach($organizations as $organization)
                                <option value="{{ $organization->id }}" {{ request('organization_id') == $organization->id ? 'selected' : '' }}>{{ $organization->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="team_id" id="team_id" class="form-control">
                            <option value="" disabled selected>Select Team</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ request('team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Organization Name</th>
                            <th>Team Name</th>
                            <th>Employee Name</th>
                            <th>Salary</th>
                            <th>Start Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($employees as $employee)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $employee->organization->name }}</td>
                            <td>{{ $employee->team->name }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->salary }}</td>
                            <td>{{ $employee->start_date }}</td>
                            <td>{{ $employee->status }}</td>
                            <td>
                                <a href="{{ route('edit.employee', $employee->id) }}">Edit</a>
                                |
                                <form action="{{ route('delete.employee', $employee->id) }}" method="POST"  style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="border: none; background: none; color: red; cursor: pointer;">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
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
                        $('#team_id').empty();  // Clear previous options
                        $('#team_id').append('<option disabled selected>Select Team</option>'); // Default option
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
