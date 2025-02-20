@extends('admin.layouts.admin')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Topshiriq</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Topshiriq</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Topshiriq</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="dataTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Sarlavha</th>
                    <th>Muddati</th>
                    <th>Izoh</th>
                    <th>Bo`limlar</th>
                    <th>Fayllar</th>

                </tr>
                </thead>
                <tbody>

                @foreach($accepted as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>
                            @if(isset($task->task) && $task->task)
                                {{ $task->task->title }}
                            @else
                                Mavjud emas
                            @endif
                        </td>


                        <td>{{$task->deadline}}</td>
                        <td class="w-25">

                            <div class="summary">
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($task->comment), 100, '...') }}</p>
                                <a href="#" class="read-more" data-content="{{ $task->comment }}"
                                   data-title="{{ $task->title }}">To'liq o'qish</a>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="contentModal" tabindex="-1" role="dialog"
                                 aria-labelledby="contentModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
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
                            @foreach($task->accepted_department($task->id) as $ad)
                                <span
                                    class="btn btn-success text-white">{{ $ad->name }}</span>
                            @endforeach
                        </td>

                        <td>
                            @foreach($task->files as $f)
                                <a href="{{ asset('storage/senduploads/'.$f->name) }}" class="btn btn-primary"
                                   type="button" download="{{ $f->name }}">{{ $f->title }}</a>
                            @endforeach
                        </td>
                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

@endsection
