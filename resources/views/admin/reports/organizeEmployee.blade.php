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
                            <th>Action</th>
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
                           <td>
                            <a href="{{ route('employee.report.pdf.download', $org->id) }}"><i class="fa fa-download"></i></a>
                           </td>
                       </tr>
                   @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $organizations->links() }}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

