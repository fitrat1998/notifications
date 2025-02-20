@extends('admin.layouts.admin')

@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Fakultetlar</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                            <li class="breadcrumb-item active">Fakultetlar</li>
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
                            @can('faculty.create')
                            <a href="{{ route('faculty.create') }}" class="btn btn-success btn-sm float-right">
                            <span class="fas fa-plus-circle"></span>
                                Fakultet qo'shish
                            </a>

                            @endcan
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- Data table -->
                            <table id="dataTable" class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg" user="grid" aria-describedby="dataTable_info">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fakultet</th>
                                    <th>Amallar</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($faculties as $faculty)
                                    <tr id="datas_ids{{ $faculty->id }}">
                                        <td class="w-25">{{ $faculty->id }}</td>
                                        <td class="w-50">{{ $faculty->name }}</td>
                                        <td class="text-center w-25">
                                            @can('faculty.destroy')
                                            <form action="{{ route('faculty.destroy',$faculty->id) }}" method="post">
                                                @csrf
                                                <div class="btn-faculty">
                                                    @can('faculty.edit')
                                                    <a href="{{ route('faculty.edit',$faculty->id) }}" type="button" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
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
