@extends('studydepartments.layouts.admin')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Topshiriq</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Bosh sahifa</a></li>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Topshiriq</h3>
            <a href="{{ route('donetask.create') }}" class="btn btn-success float-right">Topshiriq yuborish</a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nomi</th>
                    <th>Izoh</th>
                    <th>Status</th>
                    <th>Bajarilgan vaqti</th>
                    <th>Tahrirlangan vaqti</th>
                    <th>Fayllar</th>
                    <th>Jarayon</th>
                    <th>Ammalar</th>
                </tr>
                </thead>
                <tbody>
                @php

                    $previousAccepted = false;
                    $i = 0;
                    $s = 0;
                @endphp

                @foreach($donetasks as $task)

                    <tr>
                        <td>{{$task->id}}</td>
                        <td>{{$task->task->title}}</td>
                        <td>{!! $task->comment !!}</td>
                        <td>{{$task->status}}</td>
                        <td>{{$task->deadline}}</td>
                        <td>{{$task->updated_at}}</td>
                        <td>
                            @foreach($task->files as $f)
                                <a href="{{ asset('storage/doneuploads/'.$f->name) }}" class="btn btn-primary"
                                   type="button" download="{{ $f->name }}">{{ $f->name }}</a>
                            @endforeach
                        </td>
                        <td>
                            <div class="stepper-wrapper">

                                @foreach($task->departments($task->task_id) as $d)
                                    @php $i = $loop->iteration @endphp

                                    @if( $d->id == $department_id)
                                        @php $s = $loop->iteration; @endphp
                                    @endif
                                @endforeach

                                @foreach($task->departments($task->task_id) as $d)

                                    @php

                                        if ($s >  $loop->iteration) {
                                            $class = 'completed';

                                        } elseif ($s < $loop->iteration) {
                                            $class = '';

                                        } elseif($task->status == "waiting") {
                                            $class = 'active';
                                        }
                                        else {
                                            $class = 'completed';
                                        }
                                    @endphp

                                    <div class="stepper-item {{$class}}">
                                        <div class="step-counter">{{  $loop->iteration }}</div>
                                        <div class="step-name">{{ $d->name }}</div>
                                    </div>

                            @endforeach

                        </td>
                        <td class="text-center">
                            <form action="{{ route('donetask.destroy',$task->id) }}" method="post">
                                @csrf
                                <div class="btn-group">
                                    <a href="{{ route('donetask.edit',$task->id) }}" type="button"
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
