@extends('admin.layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Yo'nalishlar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Yo'nalishlar</li>
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
                        @can('directions.create')
                            <a href="{{ route('directions.create') }}" class="btn btn-success btn-sm float-right">
                                <span class="fas fa-plus-circle"></span>
                                Yo'nalish qo'shish
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
                                <th>Yo'nalish nomi</th>
                                <th>Fakultet nomi</th>
                                <th>Kim tomonidan yaratilgan</th>
                                <th>Amallar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($directions as $direction)
                                <tr id="datas_ids{{ $direction->id }}">

                                    <td class="w-25">{{ $loop->iteration }}</td>
                                    <td class="w-25">{{ $direction->name }}</td>
                                    <td class="w-25">{{ $direction->user->firstname }} {{ $direction->user->lastname }}</td>
                                    <td class="w-25">{{ $direction->faculty->name }}</td>
                                    <td class="text-center w-25">
                                        @can('directions.destroy')
                                            <form action="{{ route('directions.destroy',$direction->id) }}" method="post">
                                                @csrf
                                                <div class="btn-category">
                                                    @can('directions.edit')
                                                        <a href="{{ route('directions.edit',$direction->id) }}" type="button"
                                                           class="btn btn-primary btn-sm"> <i class="fa fa-pencil"></i></a>
                                                    @endcan
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="if (confirm('Вы уверены?')) { this.form.submit() } ">
                                                        <i class="fa fa-trash"></i></button>
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
