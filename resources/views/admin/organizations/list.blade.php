@extends('admin.layout.master')
@section('title', 'Organizations-List')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Organizations Tables</h1>

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
                            <th>Email</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($organizations as $organization)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $organization->name }}</td>
                            <td>{{ $organization->email }}</td>
                            <td>{{ $organization->description }}</td>
                            <td>{{ $organization->status }}</td>
                            <td>
                                <a href="{{ route('edit.organization', $organization->id) }}">Edit</a>
                                |
                                <form action="{{ route('delete.organization', $organization->id) }}" method="POST"  style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this organization?');">
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
    $(document).ready(function () {
        const token = localStorage.getItem('admin_token');
        if (!token) {
            window.location.href = "/admin/login";
        }

        $('#organization-form').submit(function (event) {
            event.preventDefault();

            const formData = new FormData(this);
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/api/admin/v1/organizations',
                type: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'X-CSRF-TOKEN': csrfToken
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    alert("Organization created successfully!");
                    window.location.href = '/organizations';
                },
                error: function (xhr, status, error) {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        alert("Error: " + xhr.responseJSON.message);
                    } else {
                        alert("An error occurred.");
                    }
                }
            });
        });
    });
</script>
@endsection
