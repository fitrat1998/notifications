@extends('admin.layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Rollar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Rollar</li>
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
                        <h3 class="card-title">Rollar</h3>
                        {{--                        @can('permission.create')--}}
                        {{--                        @endcan--}}
                        <a href="{{ route('roles.create') }}" class="btn btn-success btn-sm float-right">
                            <span class="fas fa-plus-circle"></span>
                            Qo'shish
                        </a>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table id="dataTable"
                               class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg"
                               role="grid" aria-describedby="dataTable_info">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nomi</th>
                                <th>Sarlavha</th>
                                <th>Ruxsatlar</th>
                                <th class="w-25">Ammalar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->title }}</td>
                                    <td>
                                        @foreach($role->permissions as $permission)
                                            <span class="badge badge-primary">{{ $permission->name }} </span>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('roles.destroy',$role->id) }}" method="post">
                                            @csrf
                                            <div class="btn-group">
                                                <a href="{{ route('roles.edit',$role->id) }}" type="button"
                                                   class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="if (confirm('Вы уверены?')) { this.form.submit() } "><i
                                                        class="fa fa-trash"></i></button>
                                            </div>
                                        </form>
                                        @can('roles.edit')
                                        @endcan
                                        @can('roles.destroy')
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
