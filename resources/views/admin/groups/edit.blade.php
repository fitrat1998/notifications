@extends('admin.layouts.admin')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Guruhni tahrirlash</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('faculty.index') }}">Guruhlar</a></li>
                        <li class="breadcrumb-item active">Tahrirlash</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Guruhni tahrirlash</h3>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('groups.update', $group->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Fakultetlar</label>
                                <select class="form-control rounded-1 select2" name="faculty"
                                        data-placeholder="Iltimos tanlang" style="width: 100%;" id="faculty_id">
                                    <option value="">Fakultetni tanlang</option>
                                    @foreach($faculties as $faculty)
                                        <option value="{{ $faculty->id }}"
                                            {{ $faculty_old->id == $faculty->id ? 'selected' : '' }}>
                                            {{ $faculty->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Yo‘nalishlar</label>
                                <select class="form-control rounded-1 select2" id="direction_id"
                                        name="direction_id" data-placeholder="Iltimos tanlang" style="width: 100%;">
                                    @foreach($directions as $direction)
                                        <option value="{{ $direction->id }}"
                                            {{ $direction_old->old == $direction->id ? 'selected' : '' }}>
                                            {{ $direction->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Guruh nomi</label>
                                <input type="text" name="name"
                                       class="form-control {{ $errors->has('name') ? "is-invalid":"" }}"
                                       value="{{ old('name', $group->name) }}" required>
                                @if($errors->has('name'))
                                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">Yangilash</button>
                                <a href="{{ route('faculty.index') }}" class="btn btn-danger float-left">Bekor qilish</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
