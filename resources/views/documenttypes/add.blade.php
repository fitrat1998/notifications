@extends('admin.layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Hujjat turi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('documenttypes.index') }}">Bo'lim</a></li>
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
                        <h3 class="card-title">Yangi hujjat turi qo'shish</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('documenttypes.store') }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label>Hujjat turi nomi</label>
                                <input type="text" name="name"
                                       class="form-control {{ $errors->has('name') ? "is-invalid":"" }}"
                                       value="{{ old('name') }}" required>
                                @if($errors->has('name'))
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group ">
                                <label>Bo'limlar</label>
                                <select class="select2" multiple="multiple" name="department_id[]"
                                        data-placeholder="bo`lim tanlash" style="width: 100%;">
                                    @foreach($departments as $department)
                                        <option
                                            value="{{ $department->id }}" {{ in_array($department->id, old('department_id', [])) ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('department_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">Saqlash</button>
                                <a href="{{ route('documenttypes.index') }}" class="btn btn-danger float-left">Bekor
                                    qilish</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
