@extends('admin.layout.master')
@section('title', 'Import-Employee')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Import Employees</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Import Employees</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('employee.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="name">Import Employees</label>
                                <input type="file" class="form-control" id="file" name="file"  required>
                            </div>
                        </div>
                    </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

