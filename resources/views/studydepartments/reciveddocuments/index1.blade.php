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
                                <th>Kim tomonidan yaratilgan</th>
                                <th>Status</th>
                                <th>Yaratilgan sanasi</th>
                                <th>Buyruq chiqarish</th>
                                <th>Amallar</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--                            {{ dd($user_documents) }}--}}
                            @foreach($user_documents as $userdoc)




                                @php
                                    $status = $userdoc->status($userdoc->id, auth()->user()->department_id);
                                    $previous = $userdoc->pre($userdoc->id, $status->id);
                                @endphp
                                @if($userdoc->show($status->id,$userdoc->id))

                                    <tr>
                                        <td>{{ $userdoc->id }}</td>
                                        <td class="w-25">{{ $userdoc->documenttype->name }}</td>
                                      <td class="w-25">{{ $userdoc->author->position ?? 'mavjud emas'}} - {{ $userdoc->author->lastname ?? 'mavjud emas' }} {{ $userdoc->author->firstname ?? 'mavjud emas'}}</td>




                                        <td>
                                            @if($status->status == 'accepted')
                                                <span class="btn btn-success">Qabul qilingan</span>
                                            @elseif($status->status == 'waiting')
                                                <span class="btn btn-warning">Kutilmoqda</span>
                                            @else
                                                <span class="btn btn-danger">{{ $status->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $userdoc->created_at->format('d.m.Y') }}
                                        </td>
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
