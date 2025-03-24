@extends('admin.layout.master')
@section('title', 'Team-List')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Team Tables</h1>

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
                            <th>Team Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($teams as $team)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $team->organization->name }}</td>
                            <td>{{ $team->name }}</td>
                            <td>{{ $team->description }}</td>
                            <td>{{ $team->status }}</td>
                            <td>
                                <a href="{{ route('edit.team', $team->id) }}">Edit</a>
                                |
                                <form action="{{ route('delete.team', $team->id) }}" method="POST"  style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this organization?');">
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

@endsection
