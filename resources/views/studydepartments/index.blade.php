@extends('studydepartments.layouts.admin')

@section('content')
    <p class="text-white"> {{ auth()->user()->roles[0]->name  }}</p>

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Men yaratgan hujjatlar</h1>
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
        <section class="content"    >
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{  $created_docs_count }}</h3>

                                <p>Yaratilgan hujjatlar soni</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-star"></i>
                            </div>
                            <a href="{{ route('userdocuments.index') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $accepted }}</h3>

                                <p>Qabul qilingan hujjatlar</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-plus"></i>
                            </div>
                            <a href="{{ route('userdashboard.accepted_docs') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $waiting }}</h3>

                                <p>Tasdiqlanishi kutilyotgan hujjatlar</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-folder-open"></i>
                            </div>
                            <a href="{{ route('userdashboard.waiting_docs') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $cancelled }}</h3>

                                <p>Rad etilgan hujjatlar</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-ban"></i>
                            </div>
                            <a href="{{ route('userdashboard.cancelled_docs') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>

                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

    <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kelib tushgan hujjatlar</h1>
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
                                <h3>{{ $accepted_my_docs + $recived_docs_count + $cancelled_my_docs}}</h3>

                                <p>Kelib tushgan hujjatlar</p>
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
                                <h3>{{ $accepted_my_docs }}</h3>

                                <p>Qabul qilgan hujjatlarim</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-plus"></i>
                            </div>
                            <a href="{{ route('userdashboard.my_accepted_docs') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $recived_docs_count }}</h3>

                                <p>Tasdiqlamagan hujjatlarim</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-folder-open"></i>
                            </div>
                            <a href="{{ route('userdashboard.my_waiting_docs') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $cancelled_my_docs }}</h3>

                                <p>Rad etgan hujjatlarim</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-ban"></i>
                            </div>
                            <a href="{{ route('userdashboard.my_cancelled_docs') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>

                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->


       <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Topshiriqlar</h1>
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
                                <h3>{{ $accepted_my_tasks + $waiting_my_tasks}}</h3>

                                <p>Kelib tushgan topshiriqlar</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-star"></i>
                            </div>
                            <a href="{{ route('taskstables.index') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $accepted_my_tasks }}</h3>

                                <p>Qabul qilgan topshiriqlarim</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-plus"></i>
                            </div>
                            <a href="{{ route('userdashboard.my_accepted_docs') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $waiting_my_tasks }}</h3>

                                <p>Tasdiqlamagan topshiriqlarim</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-folder-open"></i>
                            </div>
                            <a href="{{ route('userdashboard.my_waiting_docs') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                     <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $expired }}</h3>

                                <p>Muddati otgan topshiriqlar</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-ban"></i>
                            </div>
                            <a href="{{ route('userdashboard.my_cancelled_docs') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->

                </div>



                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->


@endsection
