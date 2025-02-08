@extends('hrs.layouts.admin')

@section('content')



    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bildirshnomalar</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Bosh sahifa</a></li>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="col-12 col-sm-12">
        <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="pt-2 px-3"><h3 class="card-title"></h3></li>

                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                           href="#custom-tabs-one-home"
                           role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Yangi topshiriqlar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                           href="#custom-tabs-one-profile"
                           role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Qabul qilingan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill"
                           href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages"
                           aria-selected="false">Rad qilingan</a>
                    </li>

                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                         aria-labelledby="custom-tabs-one-home-tab">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Bildirish nomi</th>
                                <th>Tavsif</th>
                                <th>Muddati</th>
                                <th>Qoldi</th>
                                <th>Status</th>
                                <th>Fayllar</th>
                                <th>Amallar</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($send as $s)
                                <tr>
                                    <td>{{ $s->sendtask($s->task_id) }}</td>
                                    <td>{!! $s->comment !!}  </td>
                                    <td>{{ $s->deadline  }}</td>
                                    <td>{{ date("d",strtotime(now()->format('Y-d-m')) - strtotime($s->deadline))}} -
                                        kun
                                    </td>

                                    <td class="text-warning"> {{ $s->status  }}</td>
                                    <td>
                                        @foreach($s->files as $f)
                                            <a href="{{ asset('storage/doneuploads/'.$f->name) }}"
                                               class="btn btn-primary" type="button"
                                               download="{{ $f->name }}">{{ $f->name }}</a>
                                        @endforeach
                                    </td>
                                    <td class="w-25">
                                        <form action="{{ route('hrs.store') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="accept" value="accept">
                                            <input type="hidden" name="task_id" value="{{$s->id}}">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa fa-arrow-down"> </i>
                                                Qabul qilish
                                            </button>
                                            <button type="button" data-toggle="modal" data-target="#exampleModal"
                                                    data-whatever="@mdo" class="btn btn-danger">
                                                <i class="fa fa-ban "> </i>
                                                Rad etish
                                            </button>
                                        </form>
                                        <form action="{{ route('hrs.store') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="task_id1" value="{{$s->id}}">
                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Izoh</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="message-text"
                                                                       class="col-form-label">Xabar:</label>
                                                                <textarea name="report" class="form-control"
                                                                          id="message-text" required></textarea>
                                                            </div>

                                                            <div class="input-group m-1">
                                                                <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                        <input type="checkbox" name="department" value="1">
                                                                        </span>
                                                                </div>
                                                                <input type="text" class="form-control"  placeholder="o`qub bo`limiga qaytarish" disabled >
                                                            </div>

                                                            <div class="input-group m-1">
                                                                <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                        <input type="checkbox" name="lawyer" value="2">
                                                                        </span>
                                                                </div>
                                                                <input type="text" class="form-control" placeholder="yuristga  qaytarish" disabled >
                                                            </div>

                                                            <div class="input-group m-1">
                                                                <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                        <input type="checkbox" name="vicerector" value="3">
                                                                        </span>
                                                                </div>
                                                                <input type="text" class="form-control" placeholder="prorektorga qaytarish" disabled >
                                                            </div>

                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Bekor qilish
                                                            </button>
                                                            <input type="submit" class="btn btn-primary"
                                                                   value="Yuborish" name="yuborish    ">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                         aria-labelledby="custom-tabs-one-profile-tab">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Bildirish nomi</th>
                                <th>Vaqti</th>
                                <th>Status</th>
                                <th>Fayllar</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($accepted as $a)

                                <tr>
                                    <td>{{ $a->sendtask($a->task_id) }}</td>
                                    <td>{{ $a->updated_at }}</td>
                                    <td class="text-success">{{ $a->status }}</td>

                                    <td>
                                        @foreach($a->files as $f)
                                            <a href="{{ asset('storage/doneuploads/'.$f->name) }}"
                                               class="btn btn-primary" type="button"
                                               download="{{ $f->name }}">{{ $f->name }}</a>
                                        @endforeach
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel"
                         aria-labelledby="custom-tabs-one-messages-tab">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Bildirish nomi</th>
                                <th>Vaqti</th>
                                <th>Status</th>
                                <th>Izoh</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cancelled as $c)
                                <tr>
                                    <td>{{ $c->sendtask($c->task_id) }}</td>
                                    <td>{{ $c->updated_at }}</td>
                                    <td class="text-danger">{{ $c->status }}</td>

                                    <td>{!!  $c->report !!}</td>

                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div







@endsection
