@extends('admin.layout.master')
@section('title', 'Maneger-List')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Maneger Tables</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Organization</th>
                            <th>Team</th>
                            <th>Employee</th>
                            <th>Report</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($managers as $manager)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $manager->name }}</td>
                            <td>{{ $manager->role }}</td>
                            <td>{{ $manager->manage_organization }}</td>
                            <td>{{ $manager->manage_team }}</td>
                            <td>{{ $manager->manage_employee }}</td>
                            <td>{{ $manager->manage_report }}</td>
                            <td>
                                <a href="{{ route('edit.maneger', $manager->id) }}">Edit</a>
                                |
                                <form action="{{ route('delete.maneger', $manager->id) }}" method="POST"  style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="border: none; background: none; color: red; cursor: pointer;">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $managers->links() }}
                </div>
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
