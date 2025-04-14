@extends('admin.layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Guruh</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('faculty.index') }}">Guruhlar</a></li>
                        <li class="breadcrumb-item active">Qo'shish</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    <section class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Yangi fakultet qo'shish</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('subjects.store') }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label>Fakultetlar</label>
                                <select class="form-control rounded-1 select2" name="faculty_id"
                                        data-placeholder="Iltimos tanlang" style="width: 100%;" id="faculty_id">
                                    <option value="">fakultetni tanlang</option>
                                    @foreach($faculties as $faculty)
                                        <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Yo‘nalishlar</label>
                                <select class="form-control rounded-1 select2 direction" id="direction_id"
                                        name="direction_id" data-placeholder="Iltimos tanlang" style="width: 100%;">
                                    <option value="">Avval fakultetni tanlang</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Guruhlar</label>
                                <select class="form-control rounded-1 select2" id="group_id"
                                        name="group_id" data-placeholder="Iltimos tanlang" style="width: 100%;">
                                    <option value="">Avval yo`nalishni tanlang</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Semestrlar</label>
                                <select class="form-control rounded-1 select2" name="semester_id"
                                        data-placeholder="Iltimos tanlang" style="width: 100%;" id="semester_id">
                                    <option value="">semestrni tanlang</option>
                                    @foreach($semesters as $semester)
                                        <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Fan nomi</label>
                                <input type="text" name="name"
                                       class="form-control {{ $errors->has('subject') ? "is-invalid":"" }}"
                                       value="{{ old('subject') }}" required>
                                @if($errors->has('subject'))
                                    <span class="error invalid-feedback">{{ $errors->first('subject') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">Saqlash</button>
                                <a href="{{ route('faculty.index') }}" class="btn btn-danger float-left">Bekor
                                    qilish</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
