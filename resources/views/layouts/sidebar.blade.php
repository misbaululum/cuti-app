<nav class="main-sidebar ps-menu">
    <!-- <div class="sidebar-toggle action-toggle">
        <a href="#">
            <i class="fas fa-bars"></i>
        </a>
    </div> -->
    <!-- <div class="sidebar-opener action-toggle">
        <a href="#">
            <i class="ti-angle-right"></i>
        </a>
    </div> -->
    <div class="sidebar-header">
        <div class="logo">
            <img src="{{ asset('favicon.png') }}" alt="Logo CP" style="max-width: 45%; height: auto;">
        </div>
        <div class="close-sidebar action-toggle">
            <i class="ti-close"></i>
        </div>
    </div>    
    <div class="sidebar-content">
        <ul>
            <li>
                <a href="{{ url('/dashboard') }}" class="link">
                    <i class="ti-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @can('read konfigurasi')
            <li class="menu-category">
                <span class="text-uppercase">Konfigurasi</span>
            </li>
                
            @endcan
            @can('read users')
            <li @class(['active' => Str::startsWith(request()->path(), 'users')])>
                <a href="{{ url('users') }}" class="link">
                    <i class="ti-user"></i>
                    <span>Users</span>
                </a>
            </li>
            @endcan
            @can('read divisi')
            <li @class(['active' => Str::startsWith(request()->path(), 'divisi')])>
                <a href="{{ url('divisi') }}" class="link">
                    <i class="ti-package"></i>
                    <span>Divisi</span>
                </a>
            </li>
            @endcan
            @can('read cuti-tahunan')
            <li @class(['active' => Str::startsWith(request()->path(), 'cuti-tahunan')])>
                <a href="{{ url('cuti-tahunan') }}" class="link">
                    <i class="ti-notepad"></i>
                    <span>Cuti Tahunan</span>
                </a>
            </li>
            @endcan
            @can('read setup-aplikasi')
            <li @class(['active' => Str::startsWith(request()->path(), 'setup-aplikasi')])>
                <a href="{{ url('setup-aplikasi') }}" class="link">
                    <i class="ti-settings"></i>
                    <span>Setup Aplikasi</span>
                </a>
            </li>
                
            @endcan
            @can('read hari-libur')
            <li @class(['active' => Str::startsWith(request()->path(), 'hari-libur')])>
                <a href="{{ url('hari-libur') }}" class="link">
                    <i class="ti-calendar"></i>
                    <span>Hari Libur</span>
                </a>
            </li>
                
            @endcan
            <li class="menu-category">
                <span class="text-uppercase">Transaksi</span>
            </li>
            <li @class(['active open' => Str::startsWith(request()->path(), 'pengajuan')])>
                <a href="#" class="main-menu has-dropdown">
                    <i class="ti-check-box"></i>
                    <span>Pengajuan</span>
                </a>
                <ul @class(['sub-menu', 'expand' => Str::startsWith(request()->path(), 'pengajuan')])>
                    <li @class(['active' => Str::startsWith(request()->path(), 'pengajuan/cuti')])>
                        <a href="{{ url('pengajuan/cuti') }}" class="link"><span>Cuti</span></a>
                    </li>
                    <li @class(['active' => Str::startsWith(request()->path(), 'pengajuan/izin')])>
                        <a href="{{ url('pengajuan/izin') }}" class="link"><span>Izin</span></a>
                    </li>
                </ul>
            </li>
            @can('read laporan')
            <li @class(['active open' => Str::startsWith(request()->path(), 'laporan')])>
                <a href="#" class="main-menu has-dropdown">
                    <i class="ti-printer"></i>
                    <span>Laporan</span>
                </a>
                <ul @class(['sub-menu', 'expand' => Str::startsWith(request()->path(), 'laporan')])>
                    @can('read laporan/cuti')
                    <li @class(['active' => Str::startsWith(request()->path(), 'laporan/cuti')])>
                        <a href="{{ url('laporan/cuti') }}" class="link"><span>Cuti</span></a>
                    </li>
                    @endcan
                    @can('read laporan/izin')
                    <li @class(['active' => Str::startsWith(request()->path(), 'laporan/izin')])>
                        <a href="{{ url('laporan/izin') }}" class="link"><span>Izin</span></a>
                    </li>
                    @endcan
                </ul>
            </li>               
            @endcan
            <li>
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit()" class="link">
                        <i class="ti-power-off"></i>
                        <span>Logout</span>
                    </a>
                </form>
            </li>
            {{-- <li>
                <a href="#" class="main-menu has-dropdown">
                    <i class="ti-desktop"></i>
                    <span>UI Elements</span>
                </a>
                <ul class="sub-menu ">
                    <li><a href="element-ui.html" class="link"><span>Elements</span></a></li>
                    <li><a href="element-accordion.html" class="link"><span>Accordion</span></a></li>
                    <li><a href="element-tabs-collapse.html" class="link"><span>Tabs & Collapse</span></a></li>
                    <li><a href="element-card.html" class="link"><span>Card</span></a></li>
                    <li><a href="element-button.html" class="link"><span>Buttons</span></a></li>
                    <li><a href="element-alert.html" class="link"><span>Alert</span></a></li>
                    <li><a href="element-themify-icons.html" class="link"><span>Themify Icons</span></a></li>
                    <li><a href="element-modal.html" class="link"><span>Modal</span></a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="main-menu has-dropdown">
                    <i class="ti-book"></i>
                    <span>Form</span>
                </a>
                <ul class="sub-menu ">
                    <li><a href="form-element.html" class="link">
                            <span>Form Element</span></a>
                    </li>
                    <li><a href="form-datepicker.html" class="link">
                            <span>Datepicker</span></a>
                    </li>
                    <li><a href="form-select2.html" class="link">
                            <span>Select2</span></a>
                    </li>
                </ul>
            </li>
            <li class="menu-category">
                <span class="text-uppercase">Utilities</span>
            </li>
            <li>
                <a href="#" class="main-menu has-dropdown">
                    <i class="ti-notepad"></i>
                    <span>Utilities</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="error-404.html" target="_blank" class="link"><span>Error 404</span></a></li>
                    <li><a href="error-403.html" target="_blank" class="link"><span>Error 403</span></a></li>
                    <li><a href="error-500.html" target="_blank" class="link"><span>Error 500</span></a></li>
                </ul>
            </li>
            <li class="">
                <a href="#" class="main-menu has-dropdown">
                    <i class="ti-layers-alt"></i>
                    <span>Pages</span>
                </a>
                <ul class="sub-menu">
                    <li class="active"><a href="pages-blank.html" class="link"><span>Blank</span></a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="main-menu has-dropdown">
                    <i class="ti-hummer"></i>
                    <span>Auth</span>
                </a>
                <ul class="sub-menu">
                    <li><a href="auth-login.html" target="_blank" class="link"><span>Login</span></a></li>
                    <li><a href="auth-register.html" target="_blank" class="link"><span>Register</span></a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="main-menu has-dropdown">
                    <i class="ti-write"></i>
                    <span>Tables</span>
                </a>
                <ul class="sub-menu ">
                    <li><a href="table-basic.html" class="link"><span>Table Basic</span></a></li>
                    <li><a href="table-datatables.html" class="link"><span>DataTables</span></a></li>
                </ul>
            </li>
            <li class="menu-category">
                <span class="text-uppercase">Extra</span>
            </li>
            <li>
                <a href="charts.html" class="link">
                    <i class="ti-bar-chart"></i>
                    <span>Charts</span>
                </a>
            </li>
            <li>
                <a href="fullcalendar.html" class="link">
                    <i class="ti-calendar"></i>
                    <span>Calendar</span>
                </a>
            </li> --}}
        </ul>
    </div>
</nav>