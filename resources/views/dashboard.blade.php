@props(['title' => 'Dashboard', 'titlePage' => 'Dashboard'])

<x-master-layout :title="$title" :titlePage="$titlePage">
    <div class="row">
        <div class="row">
            @can('read users')
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="ti-user text-primary me-2" style="font-size: 1.5rem;"></i>
                        <h5 class="mb-0">Users</h5>
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ url('users') }}" 
                           class="btn btn-primary w-100 @class(['active' => Str::startsWith(request()->path(), 'users')])">
                            <i class="ti-arrow-right"></i> Akses Users
                        </a>
                    </div>
                </div>
            </div>
            @endcan
            @can('read divisi')
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="ti-package text-primary me-2" style="font-size: 1.5rem;"></i>
                        <h5 class="mb-0">Divisi</h5>
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ url('divisi') }}" 
                           class="btn btn-primary w-100 @class(['active' => Str::startsWith(request()->path(), 'divisi')])">
                            <i class="ti-arrow-right"></i> Akses Divisi
                        </a>
                    </div>
                </div>
            </div>
            @endcan
           
            @can('read cuti-tahunan')
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="ti-notepad text-primary me-2" style="font-size: 1.5rem;"></i>
                        <h5 class="mb-0">Cuti Tahunan</h5>
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ url('cuti-tahunan') }}" 
                           class="btn btn-primary w-100 @class(['active' => Str::startsWith(request()->path(), 'cuti-tahunan')])">
                            <i class="ti-arrow-right"></i> Akses Cuti Tahunan
                        </a>
                    </div>
                </div>
            </div>
            @endcan
            @can('read setup-aplikasi')
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="ti-settings text-primary me-2" style="font-size: 1.5rem;"></i>
                        <h5 class="mb-0">Setup Aplikasi</h5>
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ url('setup-aplikasi') }}" 
                           class="btn btn-primary w-100 @class(['active' => Str::startsWith(request()->path(), 'setup-aplikasi')])">
                            <i class="ti-arrow-right"></i> Akses Setup Aplikasi
                        </a>
                    </div>
                </div>
            </div>
            @endcan
            @can('read hari-libur')
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="ti-calendar text-primary me-2" style="font-size: 1.5rem;"></i>
                        <h5 class="mb-0">Hari Libur</h5>
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ url('hari-libur') }}" 
                           class="btn btn-primary w-100 @class(['active' => Str::startsWith(request()->path(), 'hari-libur')])">
                            <i class="ti-arrow-right"></i> Akses Hari Libur
                        </a>
                    </div>
                </div>
            </div>
            @endcan
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="ti-check-box text-primary me-2" style="font-size: 1.5rem;"></i>
                        <h5 class="mb-0">Pengajuan Cuti</h5>
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ url('pengajuan/cuti') }}" 
                           class="btn btn-primary w-100 @class(['active' => Str::startsWith(request()->path(), 'pengajuan/cuti')])">
                            <i class="ti-arrow-right"></i> Akses Pengajuan Cuti
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="ti-check-box text-success me-2" style="font-size: 1.5rem;"></i>
                        <h5 class="mb-0">Pengajuan Izin</h5>
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ url('pengajuan/izin') }}" 
                           class="btn btn-success w-100 @class(['active' => Str::startsWith(request()->path(), 'pengajuan/izin')])">
                            <i class="ti-arrow-right"></i> Akses Pengajuan Izin
                        </a>
                    </div>
                </div>
            </div>
            @can('read laporan/cuti')
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="ti-printer text-success me-2" style="font-size: 1.5rem;"></i>
                        <h5 class="mb-0">Laporan Cuti</h5>
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ url('laporan/cuti') }}" 
                           class="btn btn-success w-100 @class(['active' => Str::startsWith(request()->path(), 'laporan/cuti')])">
                            <i class="ti-arrow-right"></i> Akses Laporan Cuti
                        </a>
                    </div>
                </div>
            </div>
            @endcan
            @can('read laporan/izin')
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="ti-printer text-success me-2" style="font-size: 1.5rem;"></i>
                        <h5 class="mb-0">Laporan Izin</h5>
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ url('laporan/izin') }}" 
                           class="btn btn-success w-100 @class(['active' => Str::startsWith(request()->path(), 'laporan/izin')])">
                            <i class="ti-arrow-right"></i> Akses Laporan Izin
                        </a>
                    </div>
                </div>
            </div>
            @endcan
        </div>
    </div>
</x-master-layout>
