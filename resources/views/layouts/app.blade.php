<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon.png')}}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Custom CSS -->
    <link href="{{asset('dist/css/style.min.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('assets/css/mystyle.css')}}" rel="stylesheet">
    <!-- Calendar CSS -->
    <link href="{{asset('assets/node_modules/calendar/dist/fullcalendar.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/node_modules/dropify/dist/css/dropify.min.css')}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="skin-default fixed-layout">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    @include('includes.loading_cover')
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        @include('layouts.parcials.header')
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        @include('layouts.parcials.sidebar')
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        @include('layouts.parcials.footer')
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{asset('assets/node_modules/jquery/jquery-3.2.1.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('assets/node_modules/popper/popper.min.js')}}"></script>
    <script src="{{asset('assets/node_modules/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('dist/js/perfect-scrollbar.jquery.min.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{asset('dist/js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{asset('dist/js/sidebarmenu.js')}}"></script>
    <!--stickey kit -->
    <script src="{{asset('assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
    <script src="{{asset('assets/node_modules/sparkline/jquery.sparkline.min.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('dist/js/custom.min.js')}}"></script>
    <script src="{{asset('dist/js/pages/validation.js')}}"></script>
    <!-- Calendar JavaScript -->
    <script src="{{asset('assets/node_modules/calendar/jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/node_modules/moment/moment.js')}}"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
    {{Session::get('lang_code')}}
    @if(in_array(Session::get('lang_code'),['fr','']))
        <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.9.0/lang/fr.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/fr.min.js'></script>
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.1.2/tinymce.min.js"></script>
    <script src="{{asset('assets/node_modules/dropify/dist/js/dropify.min.js')}}"></script>

    <script>
        tinymce.init({
            selector: '.note-editor',
            height: 500,
            // toolbar: false,
            // menubar: false,
            // statusbar: false,
        });
        @if(in_array(Session::get('lang_code'),['fr','']))
            $(".dropify").dropify({
                messages: {
                    'default': 'Faites glisser et déposez un fichier ici ou cliquez sur',
                    'replace': 'Glisser-déposer ou cliquer pour remplacer',
                    'remove':  'Retirer',
                    'error':   'Oups, quelque chose s\'est mal passé.'
                }
            })
        @endif
        $('html, body').animate({
                scrollTop: $(location.hash).offset().top - 85
        }, 500);
        $(document).on('click', 'a[href^="#"]', function (event) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: $($.attr(this, 'href')).offset().top - 85
            }, 500);
        });
    </script>
    @include('javascript.validation')
    @yield('javascript')
</body>

</html>