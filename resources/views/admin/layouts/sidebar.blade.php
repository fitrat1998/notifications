<!-- Sidebar Menu -->
<nav class="mt-2">
    @canany(['permission.show', 'roles.show', 'user.show'])
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false"
            style="display: {{ Request::is('permission*') || Request::is('role*') || Request::is('user*') ? '' : 'block' }};">

            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-home"></i>
                    <p>Bosh sahifa</p>
                </a>
            </li>

            <li class="nav-item {{ Request::is('sendtask*') || Request::is('reciveddocuments/create') || Request::is('reciveddocuments/accepted/done') || Request::is('reciveddocuments/cancelled/done') ? 'menu-open' : '' }}">
                <a href="#"
                   class="nav-link {{ Request::is('sendtask*') || Request::is('reciveddocuments/create') || Request::is('reciveddocuments/accepted/done') || Request::is('reciveddocuments/cancelled/done') ? 'active' : '' }}">
                    <i class="fa fa-thumbtack"></i>
                    <p>
                        Topshiriq
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('sendtask.create') }}"
                           class="nav-link {{ Request::is('sendtask/create') ? 'active' : '' }}">
                            <i class="fa fa-paper-plane"></i>
                            <p>Yuborish</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sendtask.index') }}"
                           class="nav-link {{ Request::is('sendtask') ? 'active' : '' }}">
                            <i class="fa fa-file-import"></i>
                            <p>Yuborilganlar</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reciveddocuments.create') }}"
                           class="nav-link {{ Request::is('reciveddocuments/create') ? 'active' : '' }}">
                            <i class="fa-brands fa-hacker-news"></i>
                            <p>Yangi kelib tushgan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reciveddocuments.accepted_done') }}"
                           class="nav-link {{ Request::is('reciveddocuments/accepted/done') ? 'active' : '' }}">
                            <i class="fa-solid fa-check-to-slot"></i>
                            <p>Qabul qilingan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reciveddocuments.cancelled_done') }}"
                           class="nav-link {{ Request::is('reciveddocuments/cancelled/done') ? 'active' : '' }}">
                            <i class="fa-solid fa-ban"></i>
                            <p>Rad qilingan</p>
                        </a>
                    </li>
                </ul>
            </li>


            <li class="nav-item {{ Request::is('permission*') || Request::is('role*') || Request::is('user*') || Request::is('departments*') ? 'menu-open' : '' }}">
                <a href="#"
                   class="nav-link {{ Request::is('permission*') || Request::is('role*') || Request::is('user*') || Request::is('departments*') ? 'active' : '' }}">
                    <i class="fa-solid fa-gears"></i>
                    <p>
                        Tuzilma
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('permissions.index') }}"
                           class="nav-link {{ Request::is('permissions*') ? 'active' : '' }}">
                            <i class="fa-solid fa-key"></i>
                            <p>Ruxsatlar</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('roles.index') }}"
                           class="nav-link {{ Request::is('roles*') ? 'active' : '' }}">
                            <i class="fa-solid fa-users-gear"></i>
                            <p>Rollar</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('users.index') }}"
                           class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
                            <i class="fa fa-user"></i>
                            <p>Foydalanuvchilar</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('departments.index') }}"
                           class="nav-link {{ Request::is('departments*') ? 'active' : '' }}">
                            <i class="fa fa-list"></i>
                            <p>Bo'limlar</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('faculty.index') }}"
                           class="nav-link {{ Request::is('faculty*') ? 'active' : '' }}">
                            <i class="fa-solid fa-building"></i>
                            <p>Fakultetlar</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('directions.index') }}"
                           class="nav-link {{ Request::is('directions*') ? 'active' : '' }}">
                            <i class="fa-regular fa-folder-open"></i>
                            <p>Yo'nalishlar</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('branches.index') }}"
                           class="nav-link {{ Request::is('branches*') ? 'active' : '' }}">
                            <i class="fa-solid fa-code-branch"></i>
                            <p>Kafedralar</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('groups.index') }}"
                           class="nav-link {{ Request::is('groups*') ? 'active' : '' }}">
                            <i class="fa-solid fa-users-line"></i>
                            <p>Guruhlar</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('semesters.index') }}"
                           class="nav-link {{ Request::is('semesters*') ? 'active' : '' }}">
                            <i class="fa-solid fa-arrow-up-1-9"></i>
                            <p>Semesterlar</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('subjects.index') }}"
                           class="nav-link {{ Request::is('subjects*') ? 'active' : '' }}">
                            <i class="fa-solid fa-file-lines"></i>
                            <p>Fanlar</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('documenttypes.index') }}"
                           class="nav-link {{ Request::is('documenttypes*') ? 'active' : '' }}">
                            <i class="fa-solid fa-folder-tree"></i>
                            <p>Hujjat turi</p>
                        </a>
                    </li>
                </ul>
            </li>

    @endcanany
</nav>
<!-- /.sidebar-menu -->
