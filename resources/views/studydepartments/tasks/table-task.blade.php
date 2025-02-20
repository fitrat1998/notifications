@extends('studydepartments.layouts.admin')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Topshiriqlar</h1>
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
        <div class="card-body">
            <div class="card-header">


                <h3 class="card-title"><a href="{{ route('tasktables.index') }}" class="btn btn-primary">Barcha
                        topshiriqlar <i
                            class="fa-solid fa-list-check"></i> </a> <span class="m-2 text-primary">|</span></h3>

                <h3 class="card-title "><a href="{{ route('tasktables.done_list') }}" class="btn btn-success">Bajarilgan
                        topshiriqlar <i class="fa-solid fa-eye"></i> </a></h3>

                <h3 class="card-title "><span class="m-2 text-primary">|</span> <a
                        href="{{ route('tasktables.expired') }}" class="btn btn-danger">Muddati o`tgan topshiriqlar <i
                            class="fa-solid fa-eye-slash"></i> </a></h3>

                <h3 class="card-title "><span class="m-2 text-primary">|</span> <a
                        href="{{ route('tasktables.waiting') }}" class="btn btn-warning">Muddat qo`yilmagan topshiriqlar
                        <i
                            class="fa-solid fa-eye-slash"></i> </a></h3>

            </div>
        </div>

        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nomi</th>
                    <th>Tavsif</th>
                    <th>Muddat</th>
                    <th>Fayllar</th>
                    <th>O'qilgan sifatida belgilash</th>
                    <th>Amallar</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $previousAccepted = false;
                    $i = 0;
                    $s = 0;
                @endphp

                @foreach($sends as $send)
                    <tr id="datas_ids{{ $send->id }}">

                        <td>{{ $send->id }}</td>
                        <td>{{ $send->title }}</td>

                        <td class="w-25">

                            <div class="summary">
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($send->comment)), 100, '...') }}</p>

                                <a href="#" class="read-more" data-content="{{ $send->comment }}"
                                   data-title="{{ $send->title }}">To'liq o'qish</a>
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

                        <td class="w-25">
                            @if($send->check_done($send->id))
                                Topshiriq bajarilgan
                            @else
                                @if($send->deadline == 0)
                                    <span class="btn btn-primary">Muddat qo'yilmagan</span>
                                @else
                                    @if($send->checkdeadline($send->id) >= 3)
                                        <span class="btn btn-danger">{{ $send->deadline }} <br> {{ $send->checkdeadline($send->id) }} kun o'tdi</span>
                                    @elseif($send->checkdeadline($send->id) < 3)
                                        <span class="btn btn-warning">{{ $send->deadline }} <br> {{ abs($send->checkdeadline($send->id)) }} kun o'tdi</span>
                                    @else
                                        <span class="btn btn-success">{{ $send->deadline }} <br> {{ $send->checkdeadline($send->id) }} kun qoldi</span>
                                    @endif
                                @endif
                            @endif


                        </td>
                        <td class="text-center w-25">
                            @if($send->files->isNotEmpty())
                                @foreach($send->files as $f)
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
                            @if($send->unread($send->id))
                                @if( $send->unread($send->id)->status == 'read')
                                    <i class="fa-solid fa-check-double"></i>
                                @else
                                    <a href="{{ route('sendtask.read',$send->id) }}"><span
                                            class="btn btn-primary">Yangi</span></a>
                                @endif
                            @endif


                        </td>


                        <td class="text-center w-25">
                            @can('users')
                            @endcan
                            <form action="{{ route('users.destroy',$send->id) }}" method="post">
                                @csrf
                                <div class="btn-category">
                                    @if($send->checkdone($send->id))
                                        @php
                                            $currentPath = Request::path();
                                        @endphp



                                        <a href="{{ route('donetask.view', $send->id) }}"
                                           class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></a>
                                    @else
                                        <a href="{{ route('donetask.show', $send->id) }}"
                                           class="btn btn-primary btn-sm"><i class="fa-solid fa-square-check"></i></a>
                                    @endif
                                </div>
                            </form>

                        </td>
                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

@endsection
