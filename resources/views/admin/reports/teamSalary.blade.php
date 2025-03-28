@extends('admin.layout.master')
@section('title', 'Team-Salary')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Team-Salary Tables</h1>

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
                            <th>Team Name</th>
                            <th>Average Salary</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($teams as $team)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $team->name }}</td>
                            <td>${{ number_format($team->employees_avg_salary, 2) }}</td>
                            <td>
                                <a href="{{ route('teams.average.salary.pdf.download',$team->id) }}"><i class="fa fa-download"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $teams->links() }}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('scripts')

@endsection
