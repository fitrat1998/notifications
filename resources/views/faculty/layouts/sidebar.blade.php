
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @if(auth()->user()->roles[0]->name == "faculty")


            <li class="nav-item">
                <a href="{{ route('index') }}" class="nav-link ">
                    <i class="nav-icon fas fa-home"></i>
                    <p>
                        Bosh sahifa
                    </p>
                </a>

            </li>

            <li class="nav-item">
                <a href="{{ route('taskstables.index') }}" class="nav-link ">
                    <i class="fa fa-folder"></i>

                    <p>
                        Topshiriq <span class="badge badge-info right">( 2 )</span>
                    </p>
                </a>

            </li>


            <li class="nav-item">
                <a href="#" class="nav-link ">
                    <i class="fa fa-thumbtack"></i>
                    <p>
                        Bildirish
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('donetask.create') }}" class="nav-link ">
                            <i class="fa fa-paper-plane"></i>
                            <p>Yuborish</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('donetask.index') }}" class="nav-link ">
                            <i class="fa fa-file-import"></i>
                            <p>Yuborilganlar</p>
                        </a>
                    </li>

                </ul>
            </li>

        @endif
    </ul>
</nav>
