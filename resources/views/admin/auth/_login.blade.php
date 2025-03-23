<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-5">
                        <h4 class="text-center">Welcome Admin!</h4>
                        <form id="login-form">
                            <div class="form-group">
                                <input type="email" id="email" class="form-control" placeholder="Enter Email">
                            </div>
                            <div class="form-group">
                                <input type="password" id="password" class="form-control" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            const token = localStorage.getItem('admin_token');
            if (token) {
                window.location.href = "/dashboard";
            }
            $('#login-form').submit(function(event) {
                event.preventDefault();

                let email = $('#email').val();
                let password = $('#password').val();
                $.ajax({
                    url: "/api/admin/login",
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({ email: email, password: password }),
                    success: function(response) {
                        localStorage.setItem('admin_token', response.token);
                        window.location.href = response.redirect_url;
                    },
                    error: function(xhr) {
                        alert("Login failed: " + xhr.responseJSON.error);
                    }
                });
            });
        });
    </script>
</body>
</html>
