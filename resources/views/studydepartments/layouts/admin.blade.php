<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bildirishnomalar | Admin</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')}}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
          href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}'">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css')}}">

    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

    <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">

    <link rel="stylesheet" href="{{ asset('plugins/bs-stepper/css/bs-stepper.min.css')}}">

    <link rel="stylesheet" href="{{ asset('plugins/dropzone/min/dropzone.min.css')}}">

    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css?v=3.2.0')}}">

    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{   asset('plugins/toastr/toastr.min.css')}}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- DataTables Bootstrap 5 Integration CSS -->


    <style>
        .stepper-wrapper {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            margin-bottom: 0px;
        }

        .stepper-item {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100px;
            flex: 1;
        }

        .dt-scroll-head {
            display: none;
        }


        @media (max-width: 768px) {
            .stepper-item::before {
                position: absolute;
                content: "";
                border-bottom: 2px solid #ccc;
                width: 100%;
                top: 20px;
                left: -50%;
                z-index: 2;
            }
        }

        .stepper-item::after {
            position: absolute;
            content: "";
            border-bottom: 2px solid #ccc;
            width: 100%;
            top: 20px;
            left: 50%;
            z-index: 2;
        }

        .stepper-item .step-counter {
            position: relative;
            z-index: 5;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ccc;
            margin-bottom: 6px;
        }

        .stepper-item.active {
            font-weight: bold;
        }

        .stepper-item.completed .step-counter {
            background-color: #4bb543;
        }

        .stepper-item.cancelled .step-counter {
            background-color: indianred;
        }

        .stepper-item.completed::after {
            position: absolute;
            content: "";
            border-bottom: 2px solid #4bb543;
            width: 100%;
            top: 20px;
            left: 50%;
            z-index: 3;
        }

        .stepper-item:first-child::before {
            content: none;
        }

        .stepper-item:last-child::after {
            content: none;
        }

        .modal-fullscreen {
            max-width: none;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .modal-content {
            height: 100%;
            border-radius: 0;
        }

        .modal-body {
            overflow-y: auto;
        }


        .nav-tabs .nav-link {
            color: white !important;
        }

        /* Aktiv tugmaning soyasi tugmaning rangiga mos tushishi uchun */
        .nav-tabs .nav-link.active {
            box-shadow: 0 0 10px rgb(0, 123, 255); /* Default */
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .table {
            width: 100% !important;
            max-width: 100%;
            height: 0 !important;
            overflow: hidden !important;
        }


    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper" style="display: block">

    <nav class="main-header navbar navbar-expand">

        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                   class="nav-link dropdown-toggle">
                    @if(auth()->user())
                        <span class="btn btn-success"><i
                                class="fas fa-user"></i> {{ auth()->user()->firstname }} {{ auth()->user()->lastname }} - ({{ auth()->user()->position }})</span>
                    @endif
                </a>
                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow"
                    style="left: 0px; right: inherit;">
                    <li>
                        @if(auth()->user())
                            <a href="{{ route('profile.edit',auth()->user()->id) }}" class="dropdown-item">
                                <i class="fas fa-cogs"></i> Sozlamalar
                            </a>
                        @endif
                    </li>
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="#" class="nav-link" role="button" onclick="
                                    event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Chiqish
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

    </nav>


    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('index') }}" class="brand-link">
            <img src=" {{ asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
                 class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Bildirishnomalar</span>
        </a>
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex ">
                <div class="image">
                    <img src="{{ asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</a>
                </div>
            </div>

            <!-- Sidebar -->
            @include('studydepartments.layouts.sidebar')

        </div>
        <!-- /.sidebar -->
    </aside>

    <div class="content-wrapper">
        <!-- Main content -->
    @yield('content')
    <!-- /.content -->
    </div>
    <footer class="main-footer">
        <strong>Copyright &copy; 2024 <a href="https://it-markaz.samdu.uz/" target="_blank">IT MARKAZ</a>.</strong>
        Barcha Huquqlar Himoyalangan
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.2.0
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" integrity=""
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity=""
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
{{--<script src="{{ asset('plugins/datatables/jquery.dataTables.js')}}"></script>--}}
{{--<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.js')}}"></script>--}}
{{--<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->--}}

<!-- Twitter Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<!-- DataTables Core JavaScript -->
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
{{--<!-- DataTables Bootstrap 5 Integration -->--}}
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>


<script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->')}}
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{ asset('plugins/toastr/toastr.min.js')}}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js')}}"></script>

<script>
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>

{{--<script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/inline/ckeditor.js"></script>--}}

<!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://cdn.tiny.cloud/1/avkzrwv1l5m1g5pfb7ad80qz4f5mko1jjukd5k4az4imw66a/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="{{ asset('plugins/my/self.js')}}"></script>


<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<!--<script src="dist/js/demo.js')}}'"></script>-->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js')}}"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button);

    $(document).ready(function () {
        if ($.fn.DataTable.isDataTable("#dataTable")) {
            $('#dataTable').DataTable().clear().destroy();
        }
        $('#dataTable').DataTable({
            "scrollX": true,
            "scrollY": "50vh",
            "responsive": false,
            "destroy": true,
        });
    });


    table = new DataTable('#dataTabledoc');


    duallist = $('.duallistbox').bootstrapDualListbox();
</script>

@if(session('success'))
    <script>
        $(function () {
            toastr.success("{{ session('success') }}");
        });
    </script>
@elseif(session('danger'))
    <script>
        $(function () {
            toastr.error("{{ session('danger') }}");
        });
    </script>
@endif

<script>
    $(document).ready(function () {
        $('table').dataTable();
    });
</script>

{{--<script>--}}
{{--    document.addEventListener("DOMContentLoaded", function (event) {--}}
{{--        ClassicEditor--}}
{{--            .create(document.querySelector('#editor'))--}}
{{--            .then(editor => {--}}
{{--                console.log(editor);--}}
{{--            })--}}
{{--            .catch(error => {--}}
{{--                console.error(error);--}}
{{--            });--}}
{{--    });--}}
{{--</script>--}}


<script>
    $(document).ready(function () {
        $('.read-more').click(function (e) {
            e.preventDefault();
            var content = $(this).data('content'); // To'liq matnni olish
            var title = $(this).data('title'); // Sarlavhani olish
            $('#contentModalLabel').text(title); // Modal sarlavhasini o'rnatish
            $('#contentModal .modal-body').html(content); // Modalda to'liq matnni ko'rsatish
            $('#contentModal').modal('show'); // Modalni ko'rsatish
        });
    });


    $(document).ready(function () {
        $('.nav-link').on('shown.bs.tab', function () {
            var bgColor = $(this).css('background-color');
            $('.nav-link').css('box-shadow', ''); // Barcha tugmalardan box-shadow olib tashlash
            $(this).css('box-shadow', '0 0 15px ' + bgColor); // Aktiv tugmaga shadow berish
        });
    });


</script>

<script>
    tinymce.init({
        selector: 'textarea#editor',
        height: 500,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:12px }',
        menubar: 'table',
        setup: function (editor) {
            editor.on('PostProcess', function (e) {
                if (e.content.includes('<table')) {
                    e.content = e.content.replace(/<table/g, '<div class="table-responsive"><table');
                    e.content = e.content.replace(/<\/table>/g, '</table></div>');
                }
            });
        }
    });


</script>

<script>
    document.getElementById('releaseForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Formani avtomatik jo‘natishni to‘xtatamiz

        let numberValue = document.getElementById('commandNumber').value; // Buyruq raqamini olish

        if (!numberValue) {
            Swal.fire("Xatolik", "Iltimos, buyruq raqamini kiriting!", "error");
            return;
        }

        Swal.fire({
            title: "Tasdiqlaysizmi?",
            text: `Buyruq raqami aniq ${numberValue} mi?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ha, buyruqni chiqar!",
            cancelButtonText: "Bekor qilish"
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit(); // Agar foydalanuvchi tasdiqlasa, formani jo‘natamiz
            }
        });
    });
</script>
</body>
</html>
