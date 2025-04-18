@extends('documenttypes.layouts.admin')

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
                        <li class="breadcrumb-item"><a href="{{ route('documenttypes.index') }}">Hujjat turi</a></li>
                        <li class="breadcrumb-item active">Tahrirlash</li>
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
                        <h3 class="card-title">Tahrirlash</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('documenttypes.mapupdate',$documenttype->id)  }}" method="post">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="permission">Tartib</label>
                                    <input type="hidden" id="checkbox" value="{{ $check }}">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" name="order" class="custom-control-input" id="customSwitch3">
                                    <label class="custom-control-label" for="customSwitch3"><h4 id="customSwitch3Label">
                                            Ixtiyoriy</h4></label>
                                </div>
                                @error('title')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Bo'limlar <span class="text-danger">(Agar hujjat tartib bilan bajarilishi kerak bo'lsa pastdagi tartib tugmasini yoqing va bo`limlarni ham tartib bilan ketma ket tanlang)</span></label>
                                <select  multiple="multiple" name="department_id[]"
                                        data-placeholder="bo`lim tanlash" style="width: 100%;" id="mylist">
                                    @foreach($departments as $department)
                                        <option
                                            value="{{ $department->id }}" {{ in_array($department->id, $depart_id) ? 'selected' : '' }}>
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
