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

                <form action="{{ route('sendtask.update',$task->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body ">

                        <div class="form-group m-4">
                            <label>Bo`lim</label>
                            <select class="select2" multiple="multiple" name="department_id[]" id="departmentSelect"
                                    data-placeholder="bo`limni tanlash" style="width: 100%;">
                                <option value="all_departments">Barcha bo`limlarni tanlash</option>
                                @foreach($departments as $department)
                                    <option
                                        value="{{ $department->id }}"
                                        {{ in_array($department->id, old('department_id', $department_ids)) ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('department_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group m-4">
                            <label for="permission">Sarlavha</label>
                            <input type="text" class="form-control" name="title" id="title"
                                   placeholder="title" value="{{$task->title}}">
                            @error('title')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group m-4 ">
                            <label for="">Matnni ko'rish <span toggle="#mycki"
                                                               class="fa fa-fw fa-eye toggle-editor field-icon"></span></label>
                            <div id="myeditor" style="display: none;">
                                <textarea name="comment" id="editor">{{$task->comment}}</textarea>
                            </div>
                            @error('comment')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-group m-4">
                            <label for="file">Fayl</label>
                            <input type="file" class="form-control m-1" name="files[]" id="file"
                                   placeholder="fayl" multiple>
                            @if($errors->any())
                                {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                            @endif
                        </div>

                        <div class="form-group m-4">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="deadline_switch"
                                       onchange="toggleDeadline()" {{ $task->set_status == 'on' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="deadline_switch">Toggle this custom switch
                                    element with custom colors danger/success</label>
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
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                </form>

    </section>
@endsection
