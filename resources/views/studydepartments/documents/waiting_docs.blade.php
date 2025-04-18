@extends('studydepartments.layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tasdiqlanishi qilinishi kutilayotgan hujjatlar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Tasdiqlanishi qilinishi kutilayotgan hujjatlar</li>
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
                                <th>Holati</th>
                                <th>Fayl</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $s = 0;
                            @endphp


                            @foreach($waiting_docs as $waiting_doc)
                                <tr id="">
                                    <td class="w-25">{{ $waiting_doc->id }}</td>
                                    <td class="w-25">{{ $waiting_doc->documenttype->name }}</td>
                                    <td class="w-25">

                                            <div class="summary">
                                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($waiting_doc->comment), 100, '...') }}</p>
                                                <a href="#" class="read-more" data-content="{{ $waiting_doc->comment }}"
                                                   data-title="{{ ($waiting_doc->documenttype->name)  }}">To'liq o'qish</a>
                                            </div>

                                    <!-- Modal -->
                                        <div class="modal fade" id="contentModal" tabindex="-1" role="dialog"
                                             aria-labelledby="contentModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="waiting_docs">
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

                                    <td>
                                        <div class="stepper-wrapper">
                                            @php
                                                $result = $waiting_doc->departments($waiting_doc->documenttype_id);

                                            @endphp


                                            @if(!empty($result))

                                                @foreach($result['departmen_names'] as $r)
                                                    @foreach($result['ids'] as $d)
                                                        @php
                                                            if($r->id == $d->department_id){
                                                                $previousDocument = collect($result['ids'])->where('id', $d->id - 1)->first();

                                                                if ($d->status == "accepted") {
                                                                    $class = 'completed';
                                                                } elseif ($d->status == "waiting" && (!is_null($previousDocument) && $previousDocument->status == 'accepted')) {
                                                                    $class = 'active';
                                                                } else {
                                                                    $class = '';
                                                                }
                                                            }
                                                        @endphp
                                                    @endforeach

                                                    <div class="stepper-item {{$class}}">
                                                        <div class="step-counter">{{ $loop->iteration }}</div>
                                                        <div class="step-name">{{ $r->name }}</div>
                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>
                                    </td>

                                    <td>
                                        @if($waiting_doc->files->isNotEmpty())
                                            @foreach($waiting_doc->files as $f)
                                                <a href="{{ asset('storage/usersenddocs/'.$f->name) }}"
                                                   class="btn btn-primary"
                                                   type="button" download="{{ $f->name }}">{{ $f->name }}</a>
                                            @endforeach
                                        @else
                                            Bu topshiriqda fayl mavjud emas.
                                        @endif
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
