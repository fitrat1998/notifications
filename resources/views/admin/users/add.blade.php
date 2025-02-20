@extends('admin.layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Foydalanuvchi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Foydalanuvchilar</a></li>
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
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title ">Qo'shish</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('users.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Ism</label>
                                <input type="text" name="firstname"
                                       class="form-control {{ $errors->has('firstname') ? "is-invalid":"" }}"
                                       value="{{ old('firstname') }}" required>
                                @if($errors->has('firstname'))
                                    <span class="error invalid-feedback">{{ $errors->first('firstname') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Familiya</label>
                                <input type="text" name="lastname"
                                       class="form-control {{ $errors->has('lastname') ? "is-invalid":"" }}"
                                       value="{{ old('lastname') }}" required>
                                @if($errors->has('lastname'))
                                    <span class="error invalid-feedback">{{ $errors->first('lastname') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Otasining ismi</label>
                                <input type="text" name="middlename"
                                       class="form-control {{ $errors->has('middlename') ? "is-invalid":"" }}"
                                       value="{{ old('middlename') }}" required>
                                @if($errors->has('middlename'))
                                    <span class="error invalid-feedback">{{ $errors->first('middlename') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Lavozim</label>
                                <input type="text" name="position"
                                       class="form-control {{ $errors->has('position') ? "is-invalid":"" }}"
                                       value="{{ old('position') }}" required>
                                @if($errors->has('position'))
                                    <span class="error invalid-feedback">{{ $errors->first('position') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Login</label>
                                <input type="text" name="login"
                                       class="form-control {{ $errors->has('login') ? "is-invalid":"" }}"
                                       value="{{ old('login') }}" required>
                                @if($errors->has('login'))
                                    <span class="error invalid-feedback">{{ $errors->first('login') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email"
                                       class="form-control {{ $errors->has('email') ? "is-invalid":"" }}"
                                       value="{{ old('email') }}" required>
                                @if($errors->has('email'))
                                    <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Bo'limlar</label>
                                <select class="form-control rounded-1" name="department_id"
                                        data-placeholder="Iltimos tanlang" style="width: 100%;">
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group">
                                <label>Parol</label>
                                <input type="password" name="password" id="password-field"
                                       class="form-control {{ $errors->has('password') ? "is-invalid":"" }}" required>
                                <span toggle="#password-field"
                                      class="fa fa-fw fa-eye toggle-password field-icon"></span>
                                @if($errors->has('password'))
                                    <span class="error invalid-feedback">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Parolni tasdiqlash</label>
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" required autocomplete="new-password">
                                <span toggle="#password-confirm"
                                      class="fa fa-fw fa-eye toggle-password field-icon"></span>
                                @if($errors->has('password_confirmation'))
                                    <span
                                        class="error invalid-feedback">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                                <div id="message"></div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">Saqlash</button>
                                <a href="{{ route('users.index') }}" class="btn btn-danger float-left">Bekor qilish</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
