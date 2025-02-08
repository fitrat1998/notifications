@extends('documenttypes.layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Hujjat turlari </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                            <li class="breadcrumb-item active">Hujjat turlari</li>
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
                                Hujjat turi qo'shish
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
                                    <th>Hujjat turi nomi</th>
                                    <th>Bo'lim nomi</th>
                                    <th>Amallar</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($documenttypes as $documenttype)
                                    <tr id="datas_ids{{ $documenttype->id }}">

                                        <td class="">{{ $loop->iteration }}</td>
                                        <td class="w-25">{{ $documenttype->name }}</td>
                                        <td class="w-25">
                                            @foreach($documenttype->departments as $d)
                                                <span class="bg-primary p-1 m-1">{{ $d->name }}</span>
                                            @endforeach
                                        </td>
                                        <td class="text-center w-25" >
                                            @can('documenttypes.destroy')
                                            <form action="{{ route('documenttypes.destroy',$documenttype->id) }}" method="post">
                                                @csrf
                                                <div class="btn-category">
                                                    <a href="{{ route('documenttypes.mapedit',$documenttype->id) }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-map"></i></a>
                                                    @can('documenttypes.edit')
                                                    <a href="{{ route('documenttypes.edit',$documenttype->id) }}"  class="btn btn-primary btn-sm"> <i class="fa fa-pencil"></i></a>
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
