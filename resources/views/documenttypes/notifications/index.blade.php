@extends('faculty.layouts.admin')

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
                                <th>Fakultet</th>
                                <th>Status</th>
                                <th>Fayllar</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($send as $s)
                                <tr>
                                    <td>{{ $s->title  }}</td>
                                    <td>{!! $s->comment !!}  </td>
                                    <td>{{ $s->deadline  }}</td>
                                    <td>{{ date("d",strtotime(now()->format('Y-d-m')) - strtotime($s->deadline))}} -
                                        kun
                                    </td>
                                    <td>{{ $s->faculty($s->id)->name  }}</td>
                                    <td class="text-warning"> {{ $s->status  }}</td>
                                    <td>
                                        @foreach($s->files as $f)
                                            <a href="{{ asset('storage/senduploads/'.$f->name) }}" class="btn btn-primary" type="button" download="{{ $f->name }}">{{ $f->name }}</a>
                                        @endforeach
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
                                <th>Fakultet</th>
                                <th>Fayllar</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($accepted as $a)

                                <tr>
                                    <td>{{ $a->sendtask($a->task_id) }}</td>
                                    <td>{{ $a->updated_at }}</td>
                                    <td class="text-success">{{ $a->status }}</td>
                                    <td>{{ $a->faculty($a->task_id)->name }}</td>
                                    <td>
                                        @foreach($a->files as $f)
                                            <a href="{{ asset('storage/doneuploads/'.$f->name) }}" class="btn btn-primary" type="button" download="{{ $f->name }}">{{ $f->name }}</a>
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
                                <th>Fakultet</th>
                                <th>Izoh</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cancelled as $c)
                                <tr>
                                    <td>{{ $c->title }}</td>
                                    <td>{{ $c->updated_at }}</td>
                                    <td class="text-danger">{{ $c->status }}</td>
                                    <td>{{ $c->faculty($c->id)->name }}</td>
                                    <td>{{ $c->comment }}</td>

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
