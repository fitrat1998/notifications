@extends('studydepartments.layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kirim hujjatlari</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item active">Kirim hujjatlari</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- ./row -->
        <div class="row">
            <div class="col-12 col-sm-12">
                <div class="card  card-tabs">
                    <div class="card-header p-0 ">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link m-2 p-2 active" id="custom-tabs-one-home-tab" data-toggle="pill"
                                   href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                                   aria-selected="true" style="background-color: #007bff; color: white;">Barcha kirim hujjatlari</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link m-2 p-2" id="custom-tabs-one-profile-tab" data-toggle="pill"
                                   href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                                   aria-selected="false" style="background-color: #28a745; color: white;">Qabul qilingan hujjatlar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link m-2 p-2" id="custom-tabs-one-messages-tab" data-toggle="pill"
                                   href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages"
                                   aria-selected="false" style="background-color: #ffc107; color: black;">Yangi kelib tushgan hujjatlar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link m-2 p-2" id="custom-tabs-one-settings-tab" data-toggle="pill"
                                   href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings"
                                   aria-selected="false" style="background-color: #dc3545; color: white;">Rad etilgan hujjatlar</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                                 aria-labelledby="custom-tabs-one-home-tab">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin malesuada lacus
                                ullamcorper dui molestie, sit amet congue quam finibus. Etiam ultricies nunc non magna
                                feugiat commodo. Etiam odio magna, mollis auctor felis vitae, ullamcorper ornare ligula.
                                Proin pellentesque tincidunt nisi, vitae ullamcorper felis aliquam id. Pellentesque
                                habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin
                                id orci eu lectus blandit suscipit. Phasellus porta, ante et varius ornare, sem enim
                                sollicitudin eros, at commodo leo est vitae lacus. Etiam ut porta sem. Proin porttitor
                                porta nisl, id tempor risus rhoncus quis. In in quam a nibh cursus pulvinar non
                                consequat neque. Mauris lacus elit, condimentum ac condimentum at, semper vitae lectus.
                                Cras lacinia erat eget sapien porta consectetur.
                            </div>

                            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive"> <!-- Bu div jadvalni to‘liq moslashuvchan qiladi -->
                <table id="dataTable"
                       class="table table-bordered table-striped dataTable dtr-inline"
                       user="grid" aria-describedby="dataTable_info">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hujjat nomi</th>
                        <th>Status</th>
                        <th>Buyruq chiqarish</th>
                        <th>Amallar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($user_documents as $userdoc)
                        @php
                            $status = $userdoc->status($userdoc->id, auth()->user()->department_id);
                            $previous = $userdoc->pre($userdoc->id, $status->id);
                        @endphp
                        @if($userdoc->show($status->id,$userdoc->id))
                            <tr>
                                <td>{{ $userdoc->id }}</td>
                                <td>{{ $userdoc->documenttype->name }}</td>
                                <td>
                                    @if($status->status == 'accepted')
                                        <span class="btn btn-success">Qabul qilingan</span>
                                    @elseif($status->status == 'waiting')
                                        <span class="btn btn-warning">Kutilmoqda</span>
                                    @else
                                        <span class="btn btn-danger">{{ $status->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($userdoc->finish_doc($userdoc->id))
                                        <a href="{{ route('release.show', ['release' => $userdoc->id]) }}"
                                           class="btn btn-primary">
                                            Buyruq chiqarish
                                        </a>
                                    @else
                                        Kutilmoqda
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('doneuserdocs.destroy', $userdoc->id) }}" method="post">
                                        @csrf
                                        <div class="btn-category">
                                            <a href="{{ route('reciveddocuments.detail', $userdoc->id) }}"
                                               class="btn btn-primary btn-sm" title="Batafsil">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </a>
                                            @if($userdoc->checkdone($userdoc->id) == 'done')
                                                <a href="{{ route('doneuserdocs.view', $userdoc->id) }}"
                                                   class="btn btn-primary btn-sm"
                                                   title="Tasdiqlangan hujjatni ko'rish">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            @elseif($userdoc->checkdone($userdoc->id) == 'cancel')
                                                <a href="" class="btn btn-danger btn-sm">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('reciveddocuments.show', $userdoc->id) }}"
                                                   class="btn btn-success btn-sm" title="Hujjatni qabul qilish">
                                                    <i class="fa-solid fa-square-check"></i>
                                                </a>
                                                <a href="{{ route('reciveddocuments.reject', $userdoc->id) }}"
                                                   class="btn btn-danger btn-sm">
                                                    <i class="fa-solid fa-ban" title="Hujjatni rad qilish"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div> <!-- /.table-responsive -->
        </div> <!-- /.card-body -->
    </div> <!-- /.card -->
</div>


                            <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel"
                                 aria-labelledby="custom-tabs-one-messages-tab">
                                Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus
                                volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce
                                nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue
                                ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur
                                eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur,
                                ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex
                                vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus.
                                Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
                            </div>

                            <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel"
                                 aria-labelledby="custom-tabs-one-settings-tab">
                                Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus
                                turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis
                                vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum
                                pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget
                                aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac
                                habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis.
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>





        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
