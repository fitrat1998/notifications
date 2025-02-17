@extends('studydepartments.layouts.admin')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Qabul qilingan kirim hujjatini tahrirlash</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('doneuserdocs.index') }}">Bajarilgan kirim hujjatlari</a></li>

                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content ">
        <div class="container-fluid">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Hujjat</h3>
                </div>

                <form action="{{ route('doneuserdocs.update',$done->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body ">

                        <div class="form-group m-4">
                            <label>Sarlavha</label>


                            @php
                                $result = $done->userdocs($done->userdocs_id);
                            @endphp


                            <input type="text" class="form-control"
                                   value="{{ $result['document']->name }} "
                                   {{ $result['document']->id == $result['old']->documenttype_id ? 'selected' : '' }}
                                   disabled>

                            <input type="hidden" value="{{ $done->userdocs_id }}" name="userdocs_id">

                            @error('userdocs_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group m-4 ">
                            <label for="">Matn</label>
                            <textarea name="comment" id="editor">{!!  $done->comment  !!}</textarea>
                            @error('comment')
                            <div class="text-danger">{ $message }}</div>
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

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                </form>

    </section>
@endsection

