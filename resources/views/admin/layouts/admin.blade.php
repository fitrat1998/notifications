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
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css">
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
            flex: 1;

        @media (max-width: 768px) {
            font-size:

        12px

        ;
        }

        }


        .stepper-item::before {
            position: absolute;
            content: "";
            border-bottom: 2px solid #ccc;
            width: 100%;
            top: 20px;
            left: -50%;
            z-index: 2;
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

        .custom-modal {
            max-width: 100% !important;
            width: 1000px !important;
        }

    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                   class="nav-link dropdown-toggle"><i class="fas fa-user"></i>
                    @if(auth()->user())
                       <span class="btn btn-success">{{ auth()->user()->firstname }}</span>
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

    @if (request()->is('/') || request()->is('filterdates'))
        <div class="card-header" style="margin-top: 10px;">
            <form method="GET" action="{{ route('filterdates.index') }}" id="date-form">
                <div class="d-flex justify-content-center">
                    <div class="form-group">
                        <input type="text" name="start_date" id="start_date" class="form-control"
                               value="{{ request()->query('start_date')
                       ? \Carbon\Carbon::parse(request()->query('start_date'))->format('d/m/Y')
                       : \Carbon\Carbon::now()->startOfMonth()->format('d/m/Y') }}"
                               style="width: 250px;">
                    </div>
                    <div class="form-group ml-2">
                        <input type="text" name="end_date" id="end_date" class="form-control"
                               value="{{ request()->query('end_date')
                       ? \Carbon\Carbon::parse(request()->query('end_date'))->format('d/m/Y')
                       : \Carbon\Carbon::now()->format('d/m/Y') }}"
                               style="width: 250px;">
                    </div>

                    <div class="form-group ml-2">
                        <button type="submit" class="btn btn-primary" style="width: 250px;">Saralash</button>
                    </div>

                </div>
            </form>

        </div>
    @endif


    <script>
        document.getElementById('date-form').addEventListener('submit', function (event) {
            const startDateInput = document.getElementById('start_date').value;
            const endDateInput = document.getElementById('end_date').value;

            function convertDateFormat(dateStr) {
                const parts = dateStr.split('/');
                return `${parts[2]}-${parts[1]}-${parts[0]}`;
            }

            if (startDateInput) {
                document.getElementById('start_date').value = convertDateFormat(startDateInput);
            }
            if (endDateInput) {
                document.getElementById('end_date').value = convertDateFormat(endDateInput);
            }
        });
    </script>


{{--@if (request()->is('/') || request()->is('filterdates'))--}}
{{--    <div class="card-header" style="margin-top: 10px;">--}}
{{--        <form method="GET" action="{{ route('filterdates.index') }}" id="date-form">--}}
{{--            <div class="d-flex justify-content-center">--}}
{{--                <div class="form-group">--}}
{{--                    <input type="date" name="start_date" id="start_date" class="form-control"--}}
{{--                           value="{{ request()->query('start_date')--}}
{{--                               ? \Carbon\Carbon::parse(request()->query('start_date'))->format('Y-m-d')--}}
{{--                               : \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') }}"--}}
{{--                           style="width: 250px;">--}}
{{--                </div>--}}
{{--                <div class="form-group ml-2">--}}
{{--                    <input type="date" name="end_date" id="end_date" class="form-control"--}}
{{--                           value="{{ request()->query('end_date')--}}
{{--                               ? \Carbon\Carbon::parse(request()->query('end_date'))->format('Y-m-d')--}}
{{--                               : \Carbon\Carbon::now()->format('Y-m-d') }}"--}}
{{--                           style="width: 250px;">--}}
{{--                </div>--}}

{{--                <div class="form-group ml-2">--}}
{{--                    <button type="submit" class="btn btn-primary" style="width: 250px;">Saralash</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--@endif--}}

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
                    <a href="#" class="d-block">Admin</a>
                </div>
            </div>

            <!-- Sidebar -->

            @include('admin.layouts.sidebar')

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
<!-- DataTables Bootstrap 5 Integration -->
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>


<script src="{{ asset('plugins/select2/js/select2.full.min.js')}}"></script>

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
<script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js')}}"></script>

<script src="{{ asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->')}}
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{ asset('plugins/toastr/toastr.min.js')}}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<script src="{{ asset('plugins/my/self.js')}}"></script>


<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<!--<script src="dist/js/demo.js')}}'"></script>-->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('dist/js/pages/dashboard.js')}}"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
<<<<<<< HEAD
=======

>>>>>>> 6bda4a5 (Initial commit)
    table = new DataTable('#dataTable');

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
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $('#datemask').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'})
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'})
        //Money Euro
        $('[data-mask]').inputmask()

        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'L'
        });

        //Date and time picker
        $('#reservationdatetime').datetimepicker({icons: {time: 'far fa-clock'}});

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function (start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            }
        )

        //Timepicker
        $('#timepicker').datetimepicker({
            format: 'LT'
        })


    })

</script>

<script>
    document.addEventListener("DOMContentLoaded", function (event) {
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    });

</script>
<script>
    $(document).ready(function () {

        var checkedStatus = $('#checkbox').attr('value');

        if (checkedStatus === "on") {
            $('#customSwitch3').prop('checked', true);
            $('#customSwitch3Label').text('Tartib bilan');
        } else if (checkedStatus === "off") {
            $('#customSwitch3').prop('checked', false);
            $('#customSwitch3Label').text('Ixtiyoriy');
        } else {
            $('#customSwitch3Label').text($('#customSwitch3').prop('checked') ? 'Tartib bilan' : 'Ixtiyoriy');
        }

        $('#customSwitch3').change(function () {
            let isChecked = $('#customSwitch3').prop('checked');
            if (isChecked) {
                $('#customSwitch3Label').text('Tartib bilan');
            } else {
                $('#customSwitch3Label').text('Ixtiyoriy');
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.read-more').click(function (e) {
            e.preventDefault();
            var content = $(this).data('content');
            var title = $(this).data('title');
            $('#contentModalLabel').text(title);
            $('#contentModal .modal-body').html(content);
            $('#contentModal').modal('show');
        });
    });
</script>

<script>
    flatpickr("#deadline", {
        dateFormat: "d-m-Y"
    });
</script>

<script>
    function toggleDeadline() {
        var deadlineSwitch = document.getElementById('deadline_switch');
        var deadlineGroup = document.getElementById('deadlineGroup');
        if (deadlineSwitch.checked) {
            deadlineGroup.style.display = 'block';
        } else {
            deadlineGroup.style.display = 'none';
        }
    }

    // Ensure the correct initial state
    document.addEventListener('DOMContentLoaded', function () {
        toggleDeadline();
    });
</script>

<script>
    $(document).ready(function() {
        $('#departmentSelect').select2();

        $('#departmentSelect').on('change', function() {
            var selectedValues = $(this).val();
            var allDepartmentsSelected = selectedValues.includes('all_departments');

            if (allDepartmentsSelected) {
                $('#departmentSelect').val(['all_departments']).trigger('change');
                $('#departmentSelect option').each(function() {
                    if ($(this).val() !== 'all_departments') {
                        $(this).prop('disabled', true).hide();
                    }
                });
            } else {
                $('#departmentSelect option').each(function() {
                    $(this).prop('disabled', false).show();
                });
            }
        });
    });
</script>

{{--<script>--}}
{{--    $(document).ready(function () {--}}
{{--        $('#departmentSelect').select2();--}}

{{--        $('#departmentSelect').on('change', function () {--}}
{{--            var selectedValues = $(this).val();--}}
{{--            var allDepartmentsSelected = selectedValues.includes('all_departments');--}}

{{--            if (allDepartmentsSelected) {--}}
{{--                $('#departmentSelect').val(['all_departments']).trigger('change');--}}
{{--                $('#departmentSelect option').each(function () {--}}
{{--                    if ($(this).val() !== 'all_departments') {--}}
{{--                        $(this).prop('disabled', true);--}}
{{--                    }--}}
{{--                });--}}
{{--            } else {--}}
{{--                $('#departmentSelect option').each(function () {--}}
{{--                    $(this).prop('disabled', false);--}}
{{--                });--}}
{{--            }--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}

</body>
</html>
