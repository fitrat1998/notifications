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
                    <th>Sana</th>
                    <th>Izoh</th>
                    <th>Status</th>
                    <th>Bo`limlar</th>
                    <th>Fayllar</th>
                </tr>
                </thead>
                <tbody>

                @foreach($cancelled as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>
                            @if(isset($task->task) && $task->task)
                                {{ $task->task->title }}
                            @else
                                Mavjud emas
                            @endif
                        </td>


                        <td>{{ \Carbon\Carbon::parse($task->updated_at)->format('d-m-Y') }}</td>


                        <td class="w-25">

                            <div class="summary">
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($task->report), 100, '...') }}</p>
                                <a href="#" class="read-more" data-content="{{ $task->report }}"
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
                        <td><span class="btn btn-danger">Rad etilgan</span></td>


                        <td>
                            <span class="btn btn-warning text-white">{{ $task->single_department($task->id) }}</span>
                        </td>

                        <td class="text-center w-25">
                            @if($task->files->isNotEmpty())
                                @foreach($task->files as $f)
                                    @auth
                                        <a href="{{ route('donetask.download', $f->name) }}" class="btn btn-primary"
                                           type="button">
                                            {{ $f->title }}
                                        </a>
                                    @endauth
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

@endsection
