<x-master-layout>
    <div class="card">
        <div class="card-header">Laporan Cuti</div>
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
                                <table id="laporan-izin-cuti" class="table datatable" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Nomor</th>
                                            <th>Nama</th>
                                            <th>Tanggal Awal</th>
                                            <th>Tanggal Akhir</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $items)
                                        @php
                                            // Ambil tanggal dari item pertama (karena semua item memiliki tanggal yang sama)
                                            $tanggalAwal = \Carbon\Carbon::parse($items->first()->tanggal_awal)->format('d-m-Y');
                                            $tanggalAkhir = \Carbon\Carbon::parse($items->first()->tanggal_akhir)->format('d-m-Y');
                                            $nomor = $items->first()->nomor;
                                        @endphp
                                        <tr>
                                            <td>{{ $nomor }}</td>
                                            <td>{{ $key }}</td>
                                            <td>{{ $tanggalAwal }}</td>
                                            <td>{{ $tanggalAkhir }}</td>
                                            <td>{{ $items->sum('total_cuti') }}</td>
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