@extends('admin.layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Hujjatlar</h1>
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
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $userdocs }}</h3>

                            <p>Barcha hujjatlar</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-check-double"></i>
                        </div>
                        <a href="{{ route('filteredpages.filtered_all_userdocs', ['start_date' => request()->query('start_date'),'end_date' => request()->query('end_date')]) }}" class="small-box-footer">
                            <i class="fas fa-arrow-circle-right"></i></a>


                    </div>
                </div>

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $accepted_userdocs }}</h3>

                            <p>Tasdiqlangan hujjatlar</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-folder-open"></i>
                        </div>

                        <a href="{{ route('filteredpages.filtered_accepted_userdocs', ['start_date' => request()->query('start_date'),'end_date' => request()->query('end_date')]) }}" class="small-box-footer"><i
                                class="fas fa-arrow-circle-right"></i></a>

                    </div>
                </div>

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $mix_userdocs }}</h3>

                            <p>Jarayondagi hujjatlar</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-ban"></i>
                        </div>
                        <a href="{{ route('filteredpages.filtered_mix_userdocs', ['start_date' => request()->query('start_date'),'end_date' => request()->query('end_date')]) }}" class="small-box-footer"><i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $waiting_userdocs}}</h3>

                            <p>Yangi yaratilgan hujjatlar</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-ban"></i>
                        </div>
                        <a href="{{ route('filteredpages.filtered_waiting_userdocs', ['start_date' => request()->query('start_date'),'end_date' => request()->query('end_date')]) }}" class="small-box-footer"><i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $cancelled_userdocs }}</h3>

                            <p>Rad etilgan hujjatlar</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-ban"></i>
                        </div>
                        <a href="{{ route('filteredpages.filtered_cancelled_userdocs', ['start_date' => request()->query('start_date'),'end_date' => request()->query('end_date')]) }}" class="small-box-footer"><i
                                class="fas fa-arrow-circle-right"></i></a>
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
                    <h1 class="m-0">Topshiriq</h1>
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
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $unread_count }}</h3>

                            <p>Topshiriqni ko'rmagan bo`limlar soni</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-check-double"></i>
                        </div>
                        <a href="{{ route('filteredpages.filtered_status_tasks', ['start_date' => request()->query('start_date'),'end_date' => request()->query('end_date')]) }}" class="small-box-footer"><i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $deadlinelessleft }}</h3>

                            <p>Muddati yaqinlashgan topshiriqlar</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-ban"></i>
                        </div>
                        <a href="{{ route('filteredpages.filtered_deadlinelessleft', ['start_date' => request()->query('start_date'),'end_date' => request()->query('end_date')]) }}" class="small-box-footer"><i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $accepted }}</h3>

                            <p>Bajarilgan topshiriqlar</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-folder-open"></i>
                        </div>
                        <a href="{{ route('filteredpages.filtered_accepted_departments', ['start_date' => request()->query('start_date'),'end_date' => request()->query('end_date')]) }}" class="small-box-footer"><i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $expired }}</h3>

                            <p>Muddati o`tib ketgan</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-ban"></i>
                        </div>
                        <a href="{{ route('filteredpages.filtered_expired', ['start_date' => request()->query('start_date'),'end_date' => request()->query('end_date')]) }}" class="small-box-footer"><i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $cancelled }}</h3>

                            <p>Rad etilgan topshiriqlar</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-ban"></i>
                        </div>
                        <a href="{{ route('filteredpages.filtered_cancelled_done', ['start_date' => request()->query('start_date'),'end_date' => request()->query('end_date')]) }}" class="small-box-footer"><i
                                class="fas fa-arrow-circle-right"></i></a>
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
                    <h1 class="m-0">Tuzilma</h1>
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
                            <h3>{{ $departments_count }}</h3>

                            <p>Bo'limlar soni</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-star"></i>
                        </div>
                        <a href="{{ route('departments.index') }}" class="small-box-footer"><i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $users_count }}</h3>

                            <p>Foydalanuvchilar soni</p>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <a href="{{ route('users.index') }}" class="small-box-footer"><i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

            </div>

            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection
