@extends('admin.layouts.admin')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Topshiriq yuborish</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sendtask.index') }}">Topshiriq</a></li>
                        <li class="breadcrumb-item active">Yaratish</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content ">
        <div class="container-fluid">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Topshiriq</h3>
                </div>

                <form action="{{ route('sendtask.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body ">

                        <div class="form-group m-4">
                            <label>Bo`lim</label>
                            <select class="select2" multiple="multiple" name="department_id[]"
                                    data-placeholder="bo`limni tanlash" style="width: 100%;">
                                <option value="all_departments">Barcha bolimlarni tanlash</option>
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


                        <div class="form-group m-4 ">
                            <label for="permission">Sarlavha</label>
                            <input type="text" class="form-control" name="title" id="none"
                                   placeholder="sarlavha" value="{{ old('title') }}">
                            @error('title')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-group m-4 ">
                            <label for="">Matn</label>
                            <textarea name="comment" id="editor">{{ old('comment') }}</textarea>
                            @error('comment')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group m-4">
                            <label for="file">Fayl</label>
                            <input type="file" class="form-control m-1" name="files[]" id="file"
                                   placeholder="fayl" multiple>
                            @error('files')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-group m-4">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="deadline_switch"
                                       onchange="toggleDeadline()">
                                <label class="custom-control-label" for="deadline_switch">Muddatni belgilash</label>
                            </div>
                        </div>

                        <div class="form-group m-4" id="deadlineGroup" style="display: none;">
                            <label for="deadline">Muddat</label>
                            <input type="date" class="form-control" name="deadline" id="deadline" placeholder="muddat">

                            @error('deadline')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Jo`natish</button>
                        </div>

                </form>

    </section>
@endsection
