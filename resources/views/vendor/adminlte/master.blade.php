<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 2'))
    @yield('title_postfix', config('adminlte.title_postfix', ''))</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css') }}">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('css/sys/components/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sys/components/buttons.dataTables.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sys/app-sys.css') }}">

    <link rel="stylesheet" href="{{ asset('css/sys/components/jasny-bootstrap-3.1.3.css') }}">
    @yield('adminlte_css')

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body class="hold-transition @yield('body_class')">
    @yield('body')
    <script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/lfm.js') }}"></script>
    <script src="{{ asset('js/sys/app-sys.js') }}"></script>
    <script src="{{ asset('js/sys/components/mask.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('js/sys/components/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/sys/components/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/sys/components/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/sys/components/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/sys/components/jszip.min.js') }}"></script>
    <script src="{{ asset('js/sys/components/vfs_fonts.js') }}"></script>

    <script src="{{ asset('js/sys/components/jquery.download.js') }}"></script>
    <script src="{{ asset('js/sys/components/jquery.validate-1.15.0.js') }}"></script>
    <script src="{{ asset('js/sys/components/jasny-bootstrap-3.1.3.js') }}"></script>

    @if(config('adminlte.plugins.chartjs'))
    <!-- ChartJS     <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>-->
    @endif

    @yield('adminlte_js')

</body>
</html>
