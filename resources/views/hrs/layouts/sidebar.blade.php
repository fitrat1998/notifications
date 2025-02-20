
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    @if(auth()->user()->roles[0]->name == "hr")

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


            </li>

        @endif
    </ul>
</nav>
