<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>INSPINIA | Dashboard</title>

    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <!-- Toastr style -->
    <link href="{{ URL::asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

    <!-- Gritter -->
    <link href="{{ URL::asset('js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/plugins/dropzone/basic.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/plugins/dropzone/dropzone.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/plugins/codemirror/codemirror.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">

</head>

<body>
    <div id="wrapper">
        @include('includes.side_nav')

        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
                @include('includes.top_nav')
            </div>
            @yield('content')
        </div>

        <!-- Mainly scripts -->
        <script src="{{ URL::asset('js/jquery-3.1.1.min.js') }}"></script>
        <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ URL::asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
        <script src="{{ URL::asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

        <!-- Flot -->
        <script src="{{ URL::asset('js/plugins/flot/jquery.flot.js') }}"></script>
        <script src="{{ URL::asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
        <script src="{{ URL::asset('js/plugins/flot/jquery.flot.spline.js') }}"></script>
        <script src="{{ URL::asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
        <script src="{{ URL::asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>

        <!-- Peity -->
        <script src="{{ URL::asset('js/plugins/peity/jquery.peity.min.js') }}"></script>

        <!-- Custom and plugin javascript -->
        <script src="{{ URL::asset('js/inspinia.js') }}"></script>
        <script src="{{ URL::asset('js/plugins/pace/pace.min.js') }}"></script>

        <!-- jQuery UI -->
        <script src="{{ URL::asset('js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

        <!-- GITTER -->
        <script src="{{ URL::asset('js/plugins/gritter/jquery.gritter.min.js') }}"></script>

        <!-- Toastr -->
        <script src="{{ URL::asset('js/plugins/toastr/toastr.min.js') }}"></script>

        @yield('script')


</body>

</html>
