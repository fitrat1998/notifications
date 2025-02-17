@extends('vicerectors.layouts.admin')

@section('content')

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashbord</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Bosh sahifa</a></li>

                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>58</h3>

                                <p>Yuborilganlar</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-star"></i>
                            </div>
                            <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>24</h3>

                                <p>Qabul qilinganlar</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-plus"></i>
                            </div>
                            <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>21</h3>

                                <p>Topshiriqlar</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-folder-open"></i>
                            </div>
                            <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>30</h3>

                                <p>Rad etilgan bildirishnomnalar</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-ban"></i>
                            </div>
                            <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>

                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection
