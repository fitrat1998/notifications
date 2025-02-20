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
         <div class="card-body">
            <div class="card-header">

                <h3 class="card-title"><a href="{{ route('admindashboard.status_tasks') }}" class="btn btn-primary">Barcha topshiriqlar <i
                            class="fa-solid fa-list-check"></i> </a> <span class="m-2 text-primary">|</span></h3>

                <h3 class="card-title "><a href="{{ route('admindashboard.read') }}" class="btn btn-success">Ko'rilgan
                        topshiriqlar <i class="fa-solid fa-eye"></i> </a></h3>

                <h3 class="card-title "><span class="m-2 text-primary">|</span> <a
                        href="{{ route('admindashboard.unread') }}" class="btn btn-danger">Ko'rilmagan topshiriqlar <i
                            class="fa-solid fa-eye-slash"></i> </a></h3>

            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="dataTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Sarlavha</th>
                    <th>Muddati</th>
                    <th>Izoh</th>
                    <th>Barcha bo`limlar</th>
                    <th>Fayllar</th>
                    <th>Amallar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{$task->title}}</td>

                        <td>{{ \Carbon\Carbon::parse($task->deadline)->format('d-m-y') }}</td>
                        <td class="w-25">

                            <div class="summary">
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($task->comment), 100, '...') }}</p>
                                <a href="#" class="read-more" data-content="{{ $task->comment }}"
                                   data-title="{{ $task->title }}">To'liq o'qish</a>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="contentModal" tabindex="-1" role="dialog"
                                 aria-labelledby="contentModalLabel" aria-hidden="true">
                                <div class="modal-dialog custom-modal" role="document">
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

                        @php
                            $departments = $task->all_departments($task->id);
                            $datas = $task->status_read_or_unread($task->id);
                        @endphp

                        <td>
                            @foreach($departments as $dp)
                                @foreach($datas as $d)
                                    @if($dp->id == $d->department_id)
                                        @if($d->status == 'read')
                                            <span class="btn bg-success m-1"> {{ $dp->name }} <br> <i class="fa-regular fa-clock"></i> <span class="">{{ $d->created_at ?? 'mavjud emas' }}</span></span></span>
                                            @elseif($d->status == 'unread')
                                                <span class="btn bg-danger m-1"> {{ $dp->name }} </span>
                                            @endif
                                    @endif
                                @endforeach()
                            @endforeach
                        </td>


                        <td>
                            @foreach($task->files as $f)
                                <a href="{{ asset('storage/senduploads/'.$f->name) }}" class="btn btn-primary"
                                   type="button" download="{{ $f->name }}">{{ $f->name }}</a>
                            @endforeach
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
