@extends('admin.layout.master')
@section('title', 'Organization-Employee-Count')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Organization-Employee Tables</h1>

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
                            <th>Organization Name</th>
                            <th>Total Employees</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                       @foreach($organizations as $org)
                       <tr>
                           <td>{{ $i++ }}</td>
                           <td>{{ $org->name }}</td>
                           <td>{{ $org->employees_count }}</td>
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

@endsection
