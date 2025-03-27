@extends('employee.layout.master')
@section('title', 'User Profile')

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
                        <tr>
                            <th>Name:</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Role:</th>
                            <td>{{ $user->role }}</td>
                        </tr>
                        <tr>
                            <th>Salary:</th>
                            <td>{{ number_format($user->salary, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Start Date:</th>
                            <td>{{ \Carbon\Carbon::parse($user->start_date)->format('Y-m-d') }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if ($user->status == 'Active')
                                    <span class="label label-success">Active</span>
                                @else
                                    <span class="label label-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td>{{ $user->description }}</td>
                        </tr>
                </table>

            </div>
        </div>
    </div>

</div>
@endsection
