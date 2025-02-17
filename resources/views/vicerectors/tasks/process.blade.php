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
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <!--  <div class="preloader flex-column justify-content-center align-items-center">-->
  <!--    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">-->
  <!--  </div>-->

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Bosh sahifa</a>
      </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <!--      <li class="nav-item">-->
      <!--        <a class="nav-link" data-widget="navbar-search" href="#" role="button">-->
      <!--          <i class="fas fa-search"></i>-->
      <!--        </a>-->
      <!--        <div class="navbar-search-block">-->
      <!--          <form class="form-inline">-->
      <!--            <div class="input-group input-group-sm">-->
      <!--              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">-->
      <!--              <div class="input-group-append">-->
      <!--                <button class="btn btn-navbar" type="submit">-->
      <!--                  <i class="fas fa-search"></i>-->
      <!--                </button>-->
      <!--                <button class="btn btn-navbar" type="button" data-widget="navbar-search">-->
      <!--                  <i class="fas fa-times"></i>-->
      <!--                </button>-->
      <!--              </div>-->
      <!--            </div>-->
      <!--          </form>-->
      <!--        </div>-->
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Bildirishnomalar</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Bosh sahifa
              </p>
            </a>

          </li>

          <li class="nav-item">
            <a href="#" class="nav-link ">
              <i class="fa fa-folder"></i>

              <p>
                Bildirishnoma <span class="badge badge-info right">( 2 )</span>
              </p>
            </a>

          </li>

          <li class="nav-item">
            <a href="category.html" class="nav-link ">
              <i class="fa fa-list"></i>

              <p>
                Kategoriyalari
              </p>
            </a>

          </li>

          <li class="nav-item">
            <a href="users.html" class="nav-link ">
              <i class="fa fa-user"></i>

              <p>
                Foydalanuvchilar
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="faculties.html" class="nav-link ">
              <i class="fa fa-user"></i>
              <p>
                Fakultetlar
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link ">
              <i class="fa fa-thumbtack"></i>
              <p>
                Topshiriq
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="done.blade.php" class="nav-link ">
                  <i class="fa fa-paper-plane"></i>
                  <p>Yuborish</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="table-task.blade.php" class="nav-link ">
                  <i class="fa fa-file-import"></i>
                  <p>Yuborilganlar</p>
                </a>
              </li>

            </ul>
          </li>

          <!--          <li class="nav-item">-->
          <!--            <a href="#" class="nav-link active">-->
          <!--              <i class="nav-icon fas fa-tachometer-alt"></i>-->
          <!--              <p>-->
          <!--                Dashboard-->
          <!--                <i class="right fas fa-angle-left"></i>-->
          <!--              </p>-->
          <!--            </a>-->
          <!--            <ul class="nav nav-treeview">-->
          <!--              <li class="nav-item">-->
          <!--                <a href="./index.html" class="nav-link active">-->
          <!--                  <i class="far fa-circle nav-icon"></i>-->
          <!--                  <p>Dashboard v1</p>-->
          <!--                </a>-->
          <!--              </li>-->
          <!--              <li class="nav-item">-->
          <!--                <a href="./index2.html" class="nav-link ">-->
          <!--                  <i class="far fa-circle nav-icon"></i>-->
          <!--                  <p>Dashboard v2</p>-->
          <!--                </a>-->
          <!--              </li>-->
          <!--              <li class="nav-item">-->
          <!--                <a href="./index3.html" class="nav-link">-->
          <!--                  <i class="far fa-circle nav-icon"></i>-->
          <!--                  <p>Dashboard v3</p>-->
          <!--                </a>-->
          <!--              </li>-->
          <!--            </ul>-->
          <!--          </li>-->

          <!--          <li class="nav-item">-->
          <!--            <a href="#" class="nav-link active">-->
          <!--              <i class="nav-icon fas fa-tachometer-alt"></i>-->
          <!--              <p>-->
          <!--                Dashboard-->
          <!--                <i class="right fas fa-angle-left"></i>-->
          <!--              </p>-->
          <!--            </a>-->
          <!--            <ul class="nav nav-treeview">-->
          <!--              <li class="nav-item">-->
          <!--                <a href="./index.html" class="nav-link active">-->
          <!--                  <i class="far fa-circle nav-icon"></i>-->
          <!--                  <p>Dashboard v1</p>-->
          <!--                </a>-->
          <!--              </li>-->
          <!--              <li class="nav-item">-->
          <!--                <a href="./index2.html" class="nav-link ">-->
          <!--                  <i class="far fa-circle nav-icon"></i>-->
          <!--                  <p>Dashboard v2</p>-->
          <!--                </a>-->
          <!--              </li>-->
          <!--              <li class="nav-item">-->
          <!--                <a href="./index3.html" class="nav-link">-->
          <!--                  <i class="far fa-circle nav-icon"></i>-->
          <!--                  <p>Dashboard v3</p>-->
          <!--                </a>-->
          <!--              </li>-->
          <!--            </ul>-->
          <!--          </li>-->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Bildirshnomalar</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Bosh sahifa</a></li>

            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>


    <div class="">
      <div class="col-12 col-sm-12">
        <div class="card card-primary card-tabs">
          <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
              <li class="pt-2 px-3"><h3 class="card-title"></h3></li>

              <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home"
                   role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Yuborilgan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile"
                   role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Qabul qilingan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill"
                   href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages"
                   aria-selected="false">Rad qilingan</a>
              </li>

            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
              <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                   aria-labelledby="custom-tabs-one-home-tab">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Bildirish nomi</th>
                    <th>Vaqti</th>
                    <th>Status</th>
                    <th>Fakultet</th>
                    <th>Amallar</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>Bildirishnoma-1</td>
                    <td>15.03.2024</td>
                    <td>Status</td>
                    <td>Fakultet</td>
                    <td class="w-25">
                      <a href="" class="btn btn-success"><i class="fa fa-arrow-down"> Qabul qilish</i></a>
                      <button type="button" data-toggle="modal" data-target="#exampleModal"
                              data-whatever="@mdo" class="btn btn-danger"><i
                        class="fa fa-ban "> Rad etish</i></button>

                      </button>

                      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                           aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Izoh</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form>
                                <div class="form-group">
                                  <label for="message-text" class="col-form-label">Xabar:</label>
                                  <textarea class="form-control" id="message-text"></textarea>
                                </div>
                              </form>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Bekor qilish</button>
                              <button type="button" class="btn btn-primary">Yuborish</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                  </tbody>

                </table>
              </div>
              <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                   aria-labelledby="custom-tabs-one-profile-tab">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Bildirish nomi</th>
                    <th>Vaqti</th>
                    <th>Status</th>
                    <th>Fakultet</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>Bildirishnoma-1</td>
                    <td>15.03.2024</td>
                    <td>Status</td>
                    <td>Fakultet</td>

                  </tr>
                  </tbody>

                </table>
              </div>
              <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel"
                   aria-labelledby="custom-tabs-one-messages-tab">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Bildirish nomi</th>
                    <th>Vaqti</th>
                    <th>Status</th>
                    <th>Fakultet</th>
                    <th>Izoh</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>Bildirishnoma-1</td>
                    <td>15.03.2024</td>
                    <td>Status</td>
                    <td>Fakultet</td>
                    <th>Izoh-1</th>
                  </tr>
                  </tbody>

                </table>
              </div>

            </div>
          </div>

        </div>
      </div


    </div>


  </div>
</div>

</div>
</div>
</div>


</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
  <strong>Copyright &copy; 2024 <a href="https://">IT MARKAZ</a>.</strong>
  Barcha Huquqlar Himoyalangan
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 1.0.0
  </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<!--<script src="dist/js/demo.js"></script>-->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>


<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="plugins/sweetalert2/sweetalert2.min.js"></script>

<script src="plugins/toastr/toastr.min.js"></script>

<script src="dist/js/adminlte.min.js?v=3.2.0"></script>


</body>
</html>
