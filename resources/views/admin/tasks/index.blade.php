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
            <a href="{{route('sendtask.create')}}" class="btn btn-success float-right">Topshiriq yuborish</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="dataTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Sarlavha</th>
                    <th>Muddati</th>
                    <th>Izoh</th>
                    <th>Status</th>
                    <th>Bo`limlar</th>
                    <th>O'qigan va o'qimagan bo'limlar</th>
                    <th>Fayllar</th>
                    <th>Amallar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{$task->title}}</td>

                        <td>

                            @if($task->deadline)
                                {{$task->deadline}}
                            @else
                                mavjud emas
                            @endif
                        </td>
                        <td class="w-25">

                            <div class="summary">
                                <p>{{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($task->comment)), 100, '...') }}</p>

                                <a href="#" class="read-more" data-content="{{ $task->comment }}"
                                   data-title="{!!  $task->title !!}">To'liq o'qish</a>
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
                        <td class="text-info">{{$task->status}}</td>

                        <td>
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Ko'rish</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-toggle="collapse"
                                                data-target="#collapseOne">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="collapseOne" class="collapse">
                                    <div class="card-body">
                                        @foreach($task->departments as $d)
                                            <div class="btn btn-primary m-1">{{ $d->name }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </td>

                        @php
                            $departments = $task->all_departments($task->id);
                            $datas = $task->status_read_or_unread($task->id);
                        @endphp

                        <td>
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Ko'rish</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-toggle="collapse"
                                                data-target="#collapseTwo">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="collapseTwo" class="collapse">
                                    @foreach($departments as $dp)
                                        @foreach($datas as $d)
                                            @if($dp->id == $d->department_id)
                                                <div class="card-body">
                                                    @if($d->status == 'read')
                                                        <span class="btn bg-success m-1">
                                                            {{ $dp->name }} <br>
                                                    <i class="fa-regular fa-clock"></i>
                                                    <span>{{ $d->created_at ?? 'mavjud emas' }}</span>

                                                    @elseif($d->status == 'unread')
                                                                <span class="btn bg-danger m-1">{{ $dp->name }}</span>
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </td>


                        <td class="text-center w-25">
                            @if($task->files->isNotEmpty())
                                @foreach($task->files as $f)
                                    @auth
                                        <a href="{{ route('sendtask.download', $f->name) }}" class="btn btn-primary"
                                           type="button">
                                            {{ $f->title }}
                                        </a>
                                    @endauth
                                @endforeach
                            @else
                                Bu topshiriqda fayl mavjud emas.
                            @endif

                        </td>

                        <td class="text-center">
                            <form action="{{ route('sendtask.destroy',$task->id) }}" method="post">
                                @csrf
                                <div class="btn-group">
                                    <a href="{{ route('sendtask.edit',$task->id) }}" type="button"
                                       class="btn btn-primary btn-sm "><i class="fa fa-edit"></i></a>
                                    @can('user.edit')
                                    @endcan
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button type="button" class="btn btn-danger btn-sm"
                                            onclick="if (confirm('Вы уверены?')) { this.form.submit() } "><i
                                            class="fa fa-trash"></i></button>
                                </div>
                            </form>
                            @can('user.delete')
                            @endcan
                        </td>
                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

@endsection
