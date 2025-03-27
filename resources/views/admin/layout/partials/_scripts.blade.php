<!-- Bootstrap core JavaScript-->
<link href="{{ asset('assets/css/toaster.css')}}" rel="stylesheet">
<script src="{{ asset('assets')}}/vendor/jquery/jquery.min.js"></script>

<script src="{{ asset('assets/js/toaster.js')}}"></script>
<script src="{{ asset('assets')}}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('assets')}}/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('assets')}}/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="{{ asset('assets')}}/vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('assets')}}/js/demo/chart-area-demo.js"></script>
<script src="{{ asset('assets')}}/js/demo/chart-pie-demo.js"></script>
<script>
    @if(Session::has('success'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true,
                "positionClass": "toast-top-right",
            }
        toastr.success("{{ session('success') }}");
    @endif

    @if(Session::has('error'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true,
            "positionClass": "toast-top-right",
        }
            toastr.error("{{ session('error') }}");
    @endif

    @if(Session::has('info'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true,
            "positionClass": "toast-top-right",
        }
            toastr.info("{{ session('info') }}");
    @endif

    @if(Session::has('warning'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true,
            "positionClass": "toast-top-right",
        }
            toastr.warning("{{ session('warning') }}");
    @endif
</script>
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

</script>
