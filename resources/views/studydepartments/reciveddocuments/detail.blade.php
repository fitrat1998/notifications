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

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Qabul qilingan kirim hujjati</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                                    title="Collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="inputName">Hujjat nomi</label>
                                            <input type="text" id="inputName" class="form-control"
                                                   value="{{ $userdoc->documenttype->name }}" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDescription">Project Description</label>
                                            <div class="border rounded p-3">
                                                {!! $userdoc->comment !!}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputDescription">Tasdiqlagan bo'limlar</label>
                                            <div class="border rounded p-3">
                                                <div class="form-group">
                                                    <div class="border rounded p-3 d-flex flex-wrap gap-2">
                                                        <!-- Tugmalarni bir qatorda chiqarish -->
                                                        @foreach($userdoc->pre_done_users($userdoc->id) as $index => $preDoneUser)
                                                            <button type="button"
                                                                    class="btn btn-success btn-sm rounded-circle d-flex align-items-center justify-content-center"
                                                                    style="width: 40px; height: 40px;"
                                                                    data-toggle="modal"
                                                                    data-target="#modal{{ $index }}">
                                                                {{ $index + 1 }}
                                                            </button>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="modal{{ $index }}" tabindex="-1"
                                                                 role="dialog" aria-labelledby="modalLabel{{ $index }}"
                                                                 aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="modalLabel{{ $index }}">
                                                                                Ma'lumotlar</h5>
                                                                            <button type="button" class="close"
                                                                                    data-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>

                                                                        <div class="modal-body">
                                                                            @php
                                                                                $doneUserDoc = optional($preDoneUser->doneuserdocs->first());
                                                                            @endphp

                                                                            @if($doneUserDoc->userdocs_id == $userdoc->id)
                                                                                <p>
                                                                                    <strong>Bo'lim:</strong> {{ $preDoneUser->department->name }}
                                                                                </p>
                                                                                <p>
                                                                                    <strong>Status:</strong>
                                                                                    @if($doneUserDoc->status == 'accepted')
                                                                                        <b class="text-success">Qabul
                                                                                            qilingan</b>
                                                                                    @elseif($doneUserDoc->status == 'cancelled')
                                                                                        <b class="text-danger">Rad
                                                                                            etilgan</b>
                                                                                    @endif
                                                                                </p>
                                                                                <p>
                                                                                    <strong>Izoh:</strong> {!! $doneUserDoc->comment ?? 'Mavjud emas' !!}
                                                                                </p>
                                                                                <p><strong>Qaytarilganligi
                                                                                        sababi:</strong>
                                                                                    @if($doneUserDoc->report != 'empty')
                                                                                        {{ $doneUserDoc->report ?? 'Mavjud emas' }}
                                                                                    @endif
                                                                                </p>
                                                                                <p>
                                                                                    <strong>Tasdiqladi:</strong> {{ $preDoneUser->firstname }} {{ $preDoneUser->lastname }}
                                                                                </p>
                                                                                <p>
                                                                                    <strong>Ilova qilingan fayl:</strong>
                                                                                    @if($preDoneUser->done_user_docs_files($doneUserDoc->id)->isNotEmpty())
                                                                                        @foreach($preDoneUser->files as $file)
                                                                                            @auth
                                                                                                <a href="{{ route('userdocuments.download', $file->name) }}"
                                                                                                   class="btn btn-primary"
                                                                                                   type="button">
                                                                                                    {{ $file->title }}
                                                                                                </a>
                                                                                            @endauth
                                                                                        @endforeach
                                                                                    @else
                                                                                        Bu hujjat fayl mavjud emas.
                                                                                    @endif
                                                                                </p>

                                                                            @endif

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">Yopish
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="inputStatus">Fayllar</label>
                                            <br>
                                            @if($userdoc->files->isNotEmpty())
                                                @foreach($userdoc->files as $f)
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


                                        </div>

                                        <div class="form-group">
                                            <label for="inputStatus">Kim tominida yaratilgan</label>
                                            <br>
                                            {{--                                             {{ $userdoc->user->roles->first()->name ?? 'No role' }}--}}
                                            <span
                                                class="btn btn-success">{{ $userdoc->user->lastname }}  {{ $userdoc->user->firstname }} - {{ $userdoc->user->position }}</span>

                                        </div>


                                    </div>

                                </div>
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
