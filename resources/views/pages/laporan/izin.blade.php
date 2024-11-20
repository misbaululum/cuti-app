<x-master-layout>
    <div class="card">
        <div class="card-header">Laporan Izin</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form method="get" action="">
                            <x-forms.datepicker-range label="Periode" date_name1="tanggal_awal" date_name2="tanggal_akhir" 
                                date_value1="{{ request('tanggal_awal') }}" 
                                date_value2="{{ request('tanggal_akhir') }}"
                            />
                            <div class="mb-3">
                                <button class="btn btn-primary">Proses</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-12">
                        @if (request('tanggal_awal') && request('tanggal_akhir'))
                            @if (count($data))
                                <table class="table datatable" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                        <tr>
                                            <td>{{ $key }}</td>
                                            <td>{{ $item->sum('total_izin') }}</td>
                                        </tr>
                                            
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                            <div class="alert alert-danger">Data tidak ditemukan</div>
                        @endif
                    @endif
                    </div>
                </div>
            </div>
    </div>
    @push('jsModule')
        @vite(['resources/js/pages/laporan/laporan-cuti-izin.js'])
    @endpush
</x-master-layout>