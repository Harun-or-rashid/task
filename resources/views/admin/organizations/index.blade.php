@extends('admin.layout.master')
@section('title', 'Organizations-Create')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Organizations </h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Create</h6>
        </div>
        <div class="card-body">
            <form id="organization-form">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Phone Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number">
                        </div>
                    </div>

                    <!-- Address Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- City Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="Enter City">
                        </div>
                    </div>

                    <!-- State Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" class="form-control" id="state" name="state" placeholder="Enter State">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Country Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" id="country" name="country" placeholder="Enter Country">
                        </div>
                    </div>

                    <!-- Postal Code Field -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="postal_code">Postal Code</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Enter Postal Code">
                        </div>
                    </div>
                </div>

                <!-- Logo Field -->
                <div class="form-group">
                    <label for="logo">Logo URL</label>
                    <input type="file" class="form-control" id="logo" name="logo" placeholder="Enter Logo URL">
                </div>

                <!-- Description Field -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Description"></textarea>
                </div>

                <!-- Status Field -->
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

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
