@extends('faculty.layouts.admin')

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
                    <th>Fakultet</th>
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
                @foreach($donetasks as $task)
                    <tr>
                        <td>{{$task->id}}</td>
                        <td>{{$task->category_id}}</td>
                        <td>
                            @foreach($task->faculties()->get() as $g)
                                <span class="btn  btn-info text-white p-1">{{ $g->name }}dsf</span>
                            @endforeach
                        </td>
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
                                @if($task->step == 0)
                                    <div class="stepper-item active">
                                        <div class="step-counter">1</div>
                                        <div class="step-name">O'quv bo'limi</div>
                                    </div>
                                    <div class="stepper-item ">
                                        <div class="step-counter">2</div>
                                        <div class="step-name">Yurist</div>
                                    </div>
                                    <div class="stepper-item ">
                                        <div class="step-counter">3</div>
                                        <div class="step-name">Prorektor</div>
                                    </div>
                                    <div class="stepper-item">
                                        <div class="step-counter">4</div>
                                        <div class="step-name">Devonxona</div>
                                    </div>
                                @elseif($task->step == 1)
                                    <div class="stepper-item completed">
                                        <div class="step-counter">1</div>
                                        <div class="step-name">O'quv bo'limi</div>
                                    </div>
                                    <div class="stepper-item active">
                                        <div class="step-counter">2</div>
                                        <div class="step-name">Yurist</div>
                                    </div>
                                    <div class="stepper-item ">
                                        <div class="step-counter">3</div>
                                        <div class="step-name">Prorektor</div>
                                    </div>
                                    <div class="stepper-item">
                                        <div class="step-counter">4</div>
                                        <div class="step-name">Devonxona</div>
                                    </div>
                                @elseif($task->step == 2)
                                    <div class="stepper-item completed">
                                        <div class="step-counter">1</div>
                                        <div class="step-name">O'quv bo'limi</div>
                                    </div>
                                    <div class="stepper-item completed ">
                                        <div class="step-counter">2</div>
                                        <div class="step-name">Yurist</div>
                                    </div>
                                    <div class="stepper-item active">
                                        <div class="step-counter">3</div>
                                        <div class="step-name">Prorektor</div>
                                    </div>
                                    <div class="stepper-item">
                                        <div class="step-counter">4</div>
                                        <div class="step-name">Devonxona</div>
                                    </div>
                                @elseif($task->step == 3)
                                    <div class="stepper-item completed">
                                        <div class="step-counter">1</div>
                                        <div class="step-name">O'quv bo'limi</div>
                                    </div>
                                    <div class="stepper-item completed ">
                                        <div class="step-counter">2</div>
                                        <div class="step-name">Yurist</div>
                                    </div>
                                    <div class="stepper-item completed">
                                        <div class="step-counter">3</div>
                                        <div class="step-name">Prorektor</div>
                                    </div>
                                    <div class="stepper-item active">
                                        <div class="step-counter">4</div>
                                        <div class="step-name">Devonxona</div>
                                    </div>
                                @else
                                    <div class="stepper-item completed">
                                        <div class="step-counter">1</div>
                                        <div class="step-name">O'quv bo'limi</div>
                                    </div>
                                    <div class="stepper-item completed ">
                                        <div class="step-counter">2</div>
                                        <div class="step-name">Yurist</div>
                                    </div>
                                    <div class="stepper-item completed">
                                        <div class="step-counter">3</div>
                                        <div class="step-name">Prorektor</div>
                                    </div>
                                    <div class="stepper-item completed">
                                        <div class="step-counter">4</div>
                                        <div class="step-name">Devonxona</div>
                                    </div>
                                @endif

                            </div>
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
