@extends('studydepartments.layouts.admin')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kirim hujjatlari</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reciveddocuments.index') }}">Kirim hujjatlari</a>
                        </li>
                        <li class="breadc   rumb-item active">Yaratish</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content ">
        <div class="container-fluid">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Kirim hujjatni rad etish</h3>
                </div>

                <form action="{{ route('reciveddocuments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body ">

                        <div class="form-group m-4">
                            <label>Hujjat nomi</label>
                            <input type="hidden" value="{{ $userdocs->id }}" name="reject_id">
                            <input type="hidden" value="{{ auth()->user()->department_id }}" name="department_id">
                            <input type="text" class="form-control" name="reject_name"
                                   value=" {{ $userdocs->userdoc($userdocs->documenttype_id)->name }}" disabled>

                            @error('task_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group m-4 ">
                            <label for="">Sababni izohlash</label>
                            <textarea name="comment" id="editor">{{ old('comment') }}</textarea>
                            @error('comment')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Jo`natish</button>
                        </div>
                </form>

    </section>
@endsection

