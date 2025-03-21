@extends('studydepartments.layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Qabul qilingan kirim hujjatlari</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Qabul qilingan kirim hujjatlari</li>
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
                                <th>Hujjat nomi</th>
                                <th>Izoh</th>
                                <th>Bajarilgan vaqti</th>
                                <th>Hujjat fayli</th>
                                <th>Amallar</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr id="datas_ids{{ $done->id }}">
                                @php
                                    $result = $done->userdocs($done->userdocs_id);
                                @endphp

                                <td class="w-25">{{ $done->id }}</td>
                                <td class="w-25">{{ $result['document']->name }}</td>
                                <td class="w-25">{!! $done->comment !!}</td>
                                <td class="w-25">{{ $done->created_at }}</td>
                                <td class="text-center w-25">
                                    @if($done->files->isNotEmpty())
                                        @foreach($done->files as $f)
                                            @auth
                                                <a href="{{ route('doneuserdocs.download', $f->name) }}"
                                                   class="btn btn-primary"
                                                   type="button">
                                                    {{ $f->title }}
                                                </a>
                                            @endauth
                                        @endforeach
                                    @else
                                        Bu topshiriqda fayl mavjud emas.
                                    @endif

                                </td>

                                <td class="text-center w-25">
                                    @php
                                        $status = $done->userdoc_status($done->id)->status;
                                    @endphp

                                    @if($status == 'waiting')
                                        <form action="{{ route('doneuserdocs.destroy', $done->id) }}" method="post">
                                            @csrf
                                            <div class="btn-category">
                                                {{-- <a href="{{ route('doneuserdocs.edit', $done->id) }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-pencil"></i></a> --}}
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="if (confirm('Вы уверены?')) { this.form.submit() }">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </form>
                                    @endif


                                </td>
                            </tr>
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
