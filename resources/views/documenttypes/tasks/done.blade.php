@extends('faculty.layouts.admin')

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

                <form action="{{ route('donetask.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body ">

                        <div class="form-group m-4">
                            <label>Sarlavha</label>
                            <select class="select2" multiple="multiple" name="task_id"
                                    data-placeholder="sarlavha tanlash" style="width: 100%;">
                                @foreach($tasks as $task)
                                    <option
                                        value="{{ $task->id }}" {{ old('category_id') == $task->id ? 'selected' : '' }}>
                                        {{ $task->title }}
                                    </option>
                                @endforeach

                            </select>

                            @error('task_id')
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
                        @if($errors->any())
                            {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                        @endif
                    </div>


                    <div class="form-group m-4 ">
                        <label for="permission">Bajarilgan vaqti</label>
                        <input type="date" class="form-control" name="deadline" id="deadline"
                               placeholder="deadline" value="{{ old('deadline') }}">
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

