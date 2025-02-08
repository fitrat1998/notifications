@extends('studydepartments.layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kirim hujjatlari</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Kirim hujjatlari</li>
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
                        @can('reciveddocuments.create')
                        @endcan
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table id="dataTable"

                        <table id="dataTabledoc"

                               class="table table-bordered table-striped dataTable dtr-inline table-responsive-lg"
                               user="grid" aria-describedby="dataTable_info">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hujjat nomi</th>
                                <th>Status</th>
                                {{--                                <th>Ilova qo'shish</th>--}}
                                <th>Buyruq chiqarish</th>
                                <th>Amallar</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($user_documents as $userdoc)

                                @php
                                    $status = $userdoc->status($userdoc->id, auth()->user()->department_id);
                                    $previous = $userdoc->pre($userdoc->id, $status->id);
                                @endphp
                                @if($userdoc->show($status->id,$userdoc->id))

                                    <tr>
                                        <td>{{ $userdoc->id }}</td>
                                        <td class="w-25">{{ $userdoc->documenttype->name }}</td>
                                        <td>
                                            @if($status->status == 'accepted')
                                                <span class="btn btn-success">Qabul qilingan</span>
                                            @elseif($status->status == 'waiting')
                                                <span class="btn btn-warning">Kutilmoqda</span>
                                            @else
                                                <span class="btn btn-danger">{{ $status->status }}</span>
                                            @endif
                                        </td>

                                        {{--                                        <td>--}}
                                        {{--                                            @if($userdoc->finish_doc($userdoc->id))--}}
                                        {{--                                                @if($userdoc->final_step_status($userdoc->id))--}}
                                        {{--                                                    <a class="btn btn-primary"--}}
                                        {{--                                                       href="{{ route('final_steps.show',$userdoc->final_step_status($userdoc->id)->id) }}">Ilovani--}}
                                        {{--                                                        ko`rish</a>--}}
                                        {{--                                                @else--}}
                                        {{--                                                    <button type="button" class="btn btn-primary" data-toggle="modal"--}}
                                        {{--                                                            data-target="#modal-lg">--}}
                                        {{--                                                        Buyruq chiqarish--}}
                                        {{--                                                    </button>--}}

                                        {{--                                                    <div class="modal fade" id="modal-lg">--}}
                                        {{--                                                        <div class="modal-dialog modal-lg">--}}
                                        {{--                                                            <div class="modal-content">--}}
                                        {{--                                                                <div class="modal-header">--}}
                                        {{--                                                                    <h4 class="modal-title">Ilova qilish</h4>--}}
                                        {{--                                                                    <button type="button" class="close"--}}
                                        {{--                                                                            data-dismiss="modal"--}}
                                        {{--                                                                            aria-label="Close">--}}
                                        {{--                                                                        <span aria-hidden="true">&times;</span>--}}
                                        {{--                                                                    </button>--}}
                                        {{--                                                                </div>--}}

                                        {{--                                                                <div class="modal-body">--}}
                                        {{--                                                                    <form--}}
                                        {{--                                                                        action="{{ route('final_steps.store') }}"--}}
                                        {{--                                                                        method="POST" enctype="multipart/form-data">--}}
                                        {{--                                                                        @csrf--}}
                                        {{--                                                                        <div class="card-body ">--}}

                                        {{--                                                                            <div class="form-group m-4">--}}
                                        {{--                                                                                <label>Hujjat nomi</label>--}}
                                        {{--                                                                                <input type="hidden"--}}
                                        {{--                                                                                       value="{{ $userdoc->id }}"--}}
                                        {{--                                                                                       name="userdoc_id">--}}

                                        {{--                                                                                <input type="hidden"--}}
                                        {{--                                                                                       value="{{ auth()->user()->department_id }}"--}}
                                        {{--                                                                                       name="department_id">--}}

                                        {{--                                                                                <input type="hidden"--}}
                                        {{--                                                                                       class="form-control"--}}
                                        {{--                                                                                       name="doctype_id"--}}
                                        {{--                                                                                       value=" {{ $userdoc->userdoc($userdoc->documenttype_id)->id }}">--}}

                                        {{--                                                                                <input type="text" class="form-control"--}}
                                        {{--                                                                                       name="doctype_name"--}}
                                        {{--                                                                                       value=" {{ $userdoc->userdoc($userdoc->documenttype_id)->name }}"--}}
                                        {{--                                                                                       disabled>--}}

                                        {{--                                                                                @error('task_id')--}}
                                        {{--                                                                                <div--}}
                                        {{--                                                                                    class="text-danger">{{ $message }}</div>--}}
                                        {{--                                                                                @enderror--}}
                                        {{--                                                                            </div>--}}

                                        {{--                                                                            <div class="form-group m-4 ">--}}
                                        {{--                                                                                <label for="">Izoh</label>--}}
                                        {{--                                                                                <textarea name="comment"--}}
                                        {{--                                                                                          id="editor">{{ old('comment') }}</textarea>--}}
                                        {{--                                                                                @error('comment')--}}
                                        {{--                                                                                <div--}}
                                        {{--                                                                                    class="text-danger">{{ $message }}</div>--}}
                                        {{--                                                                                @enderror--}}
                                        {{--                                                                            </div>--}}

                                        {{--                                                                            <div class="form-group m-4">--}}
                                        {{--                                                                                <label for="file">Fayl</label>--}}
                                        {{--                                                                                <input type="file"--}}
                                        {{--                                                                                       class="form-control m-1"--}}
                                        {{--                                                                                       name="files[]" id="file"--}}
                                        {{--                                                                                       placeholder="fayl" multiple>--}}
                                        {{--                                                                                @if($errors->any())--}}
                                        {{--                                                                                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}--}}
                                        {{--                                                                                @endif--}}
                                        {{--                                                                            </div>--}}


                                        {{--                                                                            <div class="card-footer">--}}
                                        {{--                                                                                <button type="submit"--}}
                                        {{--                                                                                        class="btn btn-primary">--}}
                                        {{--                                                                                    Jo`natish--}}
                                        {{--                                                                                </button>--}}
                                        {{--                                                                            </div>--}}
                                        {{--                                                                    </form>--}}
                                        {{--                                                                </div>--}}


                                        {{--                                                            </div>--}}

                                        {{--                                                        </div>--}}

                                        {{--                                                    </div>--}}
                                        {{--                                                @endif--}}
                                        {{--                                            @else--}}
                                        {{--                                                mavjud emas--}}
                                        {{--                                            @endif--}}
                                        {{--                                        </td>--}}

                                        <td>
                                            @if($userdoc->finish_doc($userdoc->id))
                                                <a href="{{ route('release.show', ['release' => $userdoc->id]) }}"
                                                   class="btn btn-primary">
                                                    Buyruq chiqarish
                                                </a>
                                            @else
                                                Kutilmoqda

                                            @endif

                                        </td>


                                        <td class="text-center w-25">
                                            @can('reciveddocuments')
                                            @endcan

                                            <form action="{{ route('doneuserdocs.destroy', $userdoc->id) }}"
                                                  method="post">
                                                @csrf

                                                <div class="btn-category">
                                                    <a href="{{ route('reciveddocuments.detail', $userdoc->id) }}"
                                                       class="btn btn-primary btn-sm" title="Batafsil"> <i
                                                            class="fa-solid fa-circle-info"></i></a>

                                                    @if($userdoc->checkdone($userdoc->id) == 'done')
                                                        <a href="{{ route('doneuserdocs.view', $userdoc->id) }}"
                                                           class="btn btn-primary btn-sm"
                                                           title="Tasdiqlangan hujjatni ko'rish"><i
                                                                class="fa-solid fa-eye"></i></a>
                                                    @elseif($userdoc->checkdone($userdoc->id) == 'cancel')
                                                        <a href="" class="btn btn-danger btn-sm">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('reciveddocuments.show', $userdoc->id) }}"
                                                           class="btn btn-success btn-sm" title="Hujjatni qabul qilish"><i
                                                                class="fa-solid fa-square-check"></i></a>

                                                        <a href="{{ route('reciveddocuments.reject', $userdoc->id) }}"
                                                           class="btn btn-danger btn-sm">
                                                            <i class="fa-solid fa-ban" title="Hujjatni rad qilish"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </form>
                                        </td>

                                    </tr>
                                @endif
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
