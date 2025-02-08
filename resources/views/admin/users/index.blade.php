@extends('admin.layouts.admin')

@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Foydalanuvchilar</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                            <li class="breadcrumb-item active">Foydalanuvchilar</li>
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
                            <h3 class="card-title">Foydalanuvchilar</h3>
                            <a href="{{ route('users.create') }}" class="btn btn-success btn-sm float-right">
                            <span class="fas fa-plus-circle"></span>
                                Qo'shish
                            </a>
                            @can('user.add')
                            @endcan
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- Data table -->
                            <table id="dataTable" class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg" user="grid" aria-describedby="dataTable_info">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ism</th>
                                    <th>Familiya</th>
                                    <th>Otasining ismi</th>
                                    <th>Lavozim</th>
                                    <th>Login</th>
                                    <th>Email</th>
                                    <th>Bo`lim</th>
                                    <th>Rol</th>
                                    <th class="w-25">Amallar</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration}}</td>
                                        <td>{{ $user->firstname }}</td>
                                        <td>{{ $user->lastname }}</td>
                                        <td>{{ $user->middlename }}</td>
                                        <td>{{ $user->position }}</td>
                                        <td>{{ $user->login }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->department->name }}</td>
                                        <td>
                                            @foreach($user->roles()->pluck('name') as $role)
                                                <span class="badge badge-primary">{{ $role }} </span>
                                            @endforeach
                                        </td>

                                        <td class="text-center w-25">
                                            <form action="{{ route('users.destroy',$user->id) }}" method="post">
                                                @csrf
                                                <div class="btn-group">
                                                    <a href="{{ route('users.edit',$user->id) }}" type="button" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                    @can('user.edit')
                                                    @endcan
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="if (confirm('Вы уверены?')) { this.form.submit() } "><i class="fa fa-trash"></i></button>
                                                </div>
                                            </form>
                                            @can('user.delete')
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
