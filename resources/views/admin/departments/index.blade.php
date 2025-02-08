@extends('admin.layouts.admin')

@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Bo'limlar</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                            <li class="breadcrumb-item active">Bo'limlar</li>
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
                            @can('departments.create')
                            <a href="{{ route('departments.create') }}" class="btn btn-success btn-sm float-right">
                            <span class="fas fa-plus-circle"></span>
                                Bo'lim qo'shish
                            </a>
{{--                             <a href="" class="btn btn-danger" id="deleteAllSellected"> O'chirish</a>--}}
                            @endcan
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- Data table -->
                            <table id="dataTable" class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg" user="grid" aria-describedby="dataTable_info">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Bo'lim nomi</th>
                                    <th>Amallar</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($departments as $department)
                                    <tr id="datas_ids{{ $department->id }}">

                                        <td class="w-25">{{ $loop->iteration}}</td>
                                        <td class="w-25">{{ $department->name }}</td>
                                        <td class="text-center w-25" >
                                            @can('departments.destroy')
                                            <form action="{{ route('departments.destroy',$department->id) }}" method="post">
                                                @csrf
                                                <div class="btn-category">
                                                    @can('departments.edit')
                                                    <a href="{{ route('departments.edit',$department->id) }}" type="button" class="btn btn-primary btn-sm"> <i class="fa fa-pencil"></i></a>
                                                    @endcan
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="if (confirm('Вы уверены?')) { this.form.submit() } "><i class="fa fa-trash"></i></button>
                                                </div>
                                            </form>
                                            @endcan
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
