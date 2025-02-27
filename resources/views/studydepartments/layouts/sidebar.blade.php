<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        @if(auth()->user()->roles[0]->name == "user")
            <li class="nav-item">
                <a href="{{ route('index') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-home"></i>
                    <p>
                        Bosh sahifa
                    </p>
                </a>
            </li>

            @php
                $id = 0;
            @endphp
            <li class="nav-item">
                <a href="{{ route('taskstables.index') }}"
                   class="nav-link {{ Request::is('taskstables*') || Request::is('donetask*') ? 'active' : '' }}">
                    <i class="fa fa-folder"></i>
                    <p>
                        Topshiriqlar
                        <span class="badge badge-info right">
                            @if(isset($count))
                                {{ $count }}
                            @endif
                        </span>
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('userdocuments.index') }}"
                   class="nav-link {{ Request::is('userdocuments*') ? 'active' : '' }}">
                    <i class="fa-solid fa-file"></i>
                    <p>
                        Hujjatlar <span class="badge badge-info right"></span>
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('reciveddocuments.index') }}"
                   class="nav-link {{ Request::is('reciveddocuments*') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-arrow-down"></i>
                    <p>
                        Kirim hujjatlari
                        <span class="badge badge-info right">
                             @php
                             if(isset($user_documents)){
                             $count = 0;
                                 foreach ($user_documents as $document) {
                                     $status = $document->counts($document->id);

                                     if ($status) {
                                        $count++;
                                     }
                                 }

                                 echo $count;
                                 }
                                 else {
                                     echo 0;
                                 }

                             @endphp

                        </span>
                    </p>
                </a>
            </li>
        @endif
    </ul>
</nav>
