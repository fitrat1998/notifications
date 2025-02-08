@extends('studydepartments.layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Yaratilgan hujjatlar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Yaratilgan hujjatlar</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @can('documentypes.create')
                        @endcan
                        <a href="{{ route('userdocuments.create') }}" class="btn btn-success btn-sm float-right">
                            <span class="fas fa-plus-circle"></span> Hujjat yaratish
                        </a>
                    </div>

                    <div class="card-body" style="overflow-x: auto;">
                        <table id="dataTable" class="table table-bordered table-striped ">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hujjat turi</th>
                                <th>Tavsif</th>
                                <th>Fayl</th>
                                <th>Holat</th>
                                <th>Qaytarish sababi</th>
                                <th>Qaytarish vaqti</th>
                                <th>Kim qaytargan</th>
                                <th>Chiqarilgan buyruq</th>
                                <th>Amallar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($documents as $document)
                                <tr id="datas_ids{{ $document->id }}">
                                    <td>{{ $document->id }}</td>
                                    <td>{{ optional($document->documenttype)->name }}</td>
                                    <td>
                                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($document->comment), 100, '...') }}</p>
                                        <a href="#" class="read-more" data-content="{{ $document->comment }}"
                                           data-title="{{ optional($document->documenttype)->name }}">To'liq o'qish</a>
                                    </td>
                                    <td>
                                        @if($document->files->isNotEmpty())
                                            @foreach($document->files as $file)
                                                <a href="{{ route('userdocuments.download', $file->name) }}"
                                                   class="btn btn-primary">
                                                    {{ $file->title }}
                                                </a>
                                            @endforeach
                                        @else
                                            Fayl mavjud emas.
                                        @endif
                                    </td>
                                    <td>
                                        <div class="stepper-wrapper">
                                            @php
                                                $step_docs = $document->step_docs($document->id);
                                                $status = $step_docs[0];
                                                $departments = $step_docs[1];
                                                $user = \App\Models\User::find($document->cancelled_user);
                                            @endphp

                                            @php $iteration = 1; @endphp
                                            @foreach($departments as $department)
                                                @foreach($status as $s)
                                                    @if($department->id == $s->department_id)
                                                        @php
                                                            $class = match ($s->status) {
                                                                'cancelled' => 'cancelled',
                                                                'waiting' => 'active',
                                                                'accepted' => 'completed',
                                                                default => ''
                                                            };
                                                        @endphp
                                                        <div class="stepper-item {{ $class }}">
                                                            <div class="step-counter">{{ $iteration }}</div>
                                                            <div class="step-name">{{ $department->name }}</div>
                                                        </div>
                                                        @php $iteration++; @endphp
                                                    @endif
                                                @endforeach
                                            @endforeach

                                        </div>
                                    </td>
                                    <td>{!! $document->report !!}</td>
                                    <td>{{ $document->updated_at }}</td>
                                    <td>{{ $user->name ?? 'Mavjud emas' }}</td>
                                    <td>
                                        @if($document->get_released_order($document->id))
                                            <a href="{{ route('releasedownload', $document->get_released_order($document->id)) }}"
                                               class="btn btn-primary">
                                                Buyruq <i class="fa-solid fa-arrow-down"></i>
                                            </a>
                                        @else
                                            Hujjat mavjud emas
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if(auth()->user()->id == $document->user_id)
                                            <div class="btn-group">
                                                <a href="{{ route('userdocuments.show', $document->id) }}"
                                                   class="btn btn-primary btn-sm m-1">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-primary btn-sm m-1">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="#" method="post">
                                                    @csrf
                                                    <button type="button" class="btn btn-danger btn-sm m-1">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
