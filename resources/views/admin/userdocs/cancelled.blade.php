@extends('admin.layouts.admin')

@section('content')



    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Hujjatlar</h1>
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
            <h3 class="card-title">Barcha hujjatlar</h3>

        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="dataTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Hujjat nomi</th>
                    <th>Vaqti</th>
                    <th>Status</th>
                    <th>Izoh</th>
                    <th>kim rad qilgan</th>
                    <th>Fayllar</th>
                    <th>Bo'limlar</th>
                </tr>
                </thead>
                <tbody>
                @if($cancelled_userdocs)
                    @foreach($cancelled_userdocs as $userdoc)
                        <tr>
                            <td>{{ $userdoc->documenttype->name }}</td>
                            <td>  @php
                                    $dateString = $userdoc->deadline;

                                    $date = new DateTime($dateString);

                                    $formattedDate = $date->format('d-m-Y');

                                    echo $formattedDate;
                                @endphp</td>
                            <td>
                                @if($userdoc->status == 'cancelled')
                                    <span class="btn btn-danger">Rad qilingan</span>
                                @else
                                    <span class="btn btn-success">Aktiv</span>

                                @endif
                            </td>
                            <td>{!! $userdoc->report  !!} </td>
                            <td>
                                @foreach($users as $user)
                                    @if($userdoc->cancelled_user == $user->id)
                                        {{ $user->name }}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @if($userdoc->files->isNotEmpty())
                                    @foreach($userdoc->files as $f)
                                        <a href="{{ asset('storage/doneuserdocs/'.$f->name) }}"
                                           class="btn btn-primary"
                                           type="button" download="{{ $f->name }}">{{ $f->name }}</a>
                                    @endforeach
                                @else
                                    Bu topshiriqda fayl mavjud emas.
                                @endif
                            </td>
                            <td>
                                @php
                                    $all = $userdoc->datas_for_admin($userdoc->id);

                                    $datas = $all['datas'];
                                    $departments = $all['departments'];
                                @endphp

                                @if($datas->isEmpty())
                                    <span class="btn btn-warning">Mavjud emas</span>
                                @else
                                    @foreach($datas as $data)
                                        @foreach($departments as $d)
                                            @if($data->department_id == $d->id)
                                                @php
                                                    $found = true;
                                                @endphp

                                                @if($data->status == 'accepted')
                                                    <span class="btn btn-success">{{ $d->name }}</span>
                                                @elseif($data->status == 'waiting')
                                                    <span class="btn btn-danger">{{ $d->name }}</span>
                                                @endif

                                            @endif
                                        @endforeach

                                    @endforeach
                                @endif

                            </td>


                        </tr>
                    @endforeach
                @endif

                </tbody>

            </table>
        </div>
        <!-- /.card-body -->
    </div>






@endsection
