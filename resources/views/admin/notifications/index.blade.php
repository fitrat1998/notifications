@extends('admin.layouts.admin')

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

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Topshiriq</h3>

        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="dataTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Bildirish nomi</th>
                    <th>Bajargan bo`lim nomi</th>
                    <th>Vaqti</th>
                    <th>Status</th>
                    <th>Fayllar</th>
                    <th>Amallar</th>
                </tr>
                </thead>

                @foreach($send as $s)
                    <tr>
                        <td>{{ $s->task->title }}</td>

                        <td>{{ $s->taskname($s->id,$s->id)->name }}</td>

                        <td>{{ \Carbon\Carbon::parse($s->deadline)->format('d-m-y') }}</td>

                        <td>{{ $s->status }}</td>

                        <td class="text-center w-25">
                            @if($s->files->isNotEmpty())
                                @foreach($s->files as $f)
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


                        <td class="w-25">
                            <form action="{{ route('reciveddocuments.accept', $s->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="accept" value="{{ $s->id }}">
                                <button type="submit" class="btn btn-success"><i
                                        class="fa fa-arrow-down"> </i> Qabul
                                    qilish
                                </button>
                                <button type="button" data-toggle="modal" data-target="#exampleModal"
                                        data-whatever="@mdo" class="btn btn-danger"><i
                                        class="fa fa-ban "> </i> Rad etish
                                </button>
                            </form>


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
                                            <form action="{{ route('reciveddocuments.cancel', $s->id) }}"
                                                  method="POST">
                                                @csrf
                                                <input type="hidden" name="cancel" value="{{ $s->id }}">

                                                <div class="form-group">
                                                    <label for="message-text"
                                                           class="col-form-label">Xabar:</label>
                                                    <textarea name="report" class="form-control"
                                                              id="message-text"></textarea>
                                                </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Bekor qilish
                                            </button>
                                            <button type="submit" class="btn btn-primary">Yuborish</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach

                </tbody>

            </table>
        </div>
        <!-- /.card-body -->
    </div>






@endsection
