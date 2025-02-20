@extends('admin.layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ruxsatlar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Ruxsatlar</li>
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
                        <h3 class="card-title">Ruxsatlar</h3>
                        <a href="{{ route('permissions.create') }}" class="btn btn-success btn-sm float-right">
                            <span class="fas fa-plus-circle"></span>
                            Qo'shish
                        </a>
{{--                        @can('permission.create')--}}
{{--                        @endcan--}}
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table id="dataTable" class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg" role="grid" aria-describedby="dataTable_info">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nomi</th>
                                <th>Sarlavha</th>
                                <th>Rol</th>
                                <th class="w-25">Amallar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->id }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->title }}</td>
                                    <td>
                                        @foreach($permission->roles as $role)
                                            <span class="badge badge-success">{{ $role->name }} </span>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('permissions.destroy',$permission->id) }}" method="post">
                                            @csrf
                                            <div class="btn-group">
                                                <a href="{{ route('permissions.edit',$permission->id) }}" type="button" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
{{--                                                @can('permission.edit')--}}
{{--                                                @endcan--}}
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="button" class="btn btn-danger btn-sm" onclick="if (confirm('Вы уверены?')) {this.form.submit()}"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </form>
{{--                                        @can('permission.destroy')--}}
{{--                                        @endcan--}}
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
