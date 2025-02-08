@extends('studydepartments.layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Topshiriqlar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Topshiriqlar</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @can('documentypes.create')
                            <a href="{{ route('documenttypes.create') }}" class="btn btn-success btn-sm float-right">
                                <span class="fas fa-plus-circle"></span>
                                Bo'lim qo'shish
                            </a>
                            {{--                             <a href="" class="btn btn-danger" id="deleteAllSellected"> O'chirish</a>--}}
                        @endcan
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table id="dataTable"
                               class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg"
                               user="grid" aria-describedby="dataTable_info">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Topshiriq nomi</th>
                                <th>Tavsif</th>

                                <th>Amallar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sends as $send)
                                <tr id="datas_ids{{ $send->id }}">

                                    <td class="w-25">{{ $send->id }}</td>
                                    <td class="w-25">{{ $send->title }}</td>
                                    <td class="w-25">{!! $send->title   !!}</td>

                                    <td class="text-center w-25">
                                        @can('users')
                                        @endcan
                                        <form action="{{ route('users.destroy',$send->id) }}" method="post">
                                            @csrf
                                            <div class="btn-category">
                                                <a href="{{ route('users.edit',$send->id) }}"
                                                   class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></a>
                                            </div>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->

@endsection
