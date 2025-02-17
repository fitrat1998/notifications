@extends('studydepartments.layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Qabul qilingan hujjatlar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Yaratigan hujjatlar</li>
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
                        <!-- Bu yerga tegishli kod qo'shing yoki blokni olib tashlang -->
                        @endcan

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table id="dataTable"
                               class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg"
                               aria-describedby="dataTable_info">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hujjat turi nomi</th>
                                <th>Tavsif</th>
                                <th>Fayl</th>
                                <th>Bajargan bo`limlar</th>

                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $s = 0;
                            @endphp


                            @foreach($accepted_docs as $accepted_doc)
                                <tr id="">
                                    <td class="w-25">{{ $accepted_doc->id }}</td>
                                    <td class="w-25">{{ $accepted_doc->documenttype->name }}</td>
                                    <td class="w-25">

                                        <div class="summary">
                                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($accepted_doc->comment), 100, '...') }}</p>
                                            <a href="#" class="read-more" data-content="{{ $accepted_doc->comment }}"
                                               data-title="{{ $accepted_doc->comment }}">To'liq o'qish</a>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="contentModal" tabindex="-1" role="dialog"
                                             aria-labelledby="contentModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="accepted_docs">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="contentModalLabel">To'liq matn</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Yopish">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- To'liq matn shu yerda ko'rsatiladi -->
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Yopish
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </td>


                                    <td class="text-center w-25">
                                        @if($accepted_doc->files->isNotEmpty())
                                            @foreach($accepted_doc->files as $f)
                                                @auth
                                                    <a href="{{ route('userdocuments.download', $f->name) }}"
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

                                    <td>
                                        <a href="{{ route('userdashboard.doc_done_list', $accepted_doc->id) }}"
                                           class="btn btn-success"
                                           type="button">
                                            Ko`rish
                                        </a>
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
