<x-modal action="{{ $action }}">
        @method('put')
    <div class="row">
        <div class="col-md-6">
            <table class="table table-borderless">
                <tr>
                    <td>Karyawan</td>
                    <td>: {{$data->user_input}}</td>
                </tr>
                <tr>
                    <td>Tanggal awal</td>
                    <td>: {{$data->tanggal_awal->format('d-m-Y')}}</td>
                </tr>
                <tr>
                    <td>Tanggal akhir</td>
                    <td>: {{$data->tanggal_akhir->format('d-m-Y')}}</td>
                </tr>
                <tr>
                    <td>Sisa cuti awal</td>
                    <td>: {{$data->sisa_cuti_awal}}</td>
                </tr>
                <tr>
                    <td>Pengajuan cuti</td>
                    <td>: {{$data->total_cuti}}</td>
                </tr>
                <tr>
                    <td>Sisa cuti</td>
                    <td>: {{$data->sisa_cuti}}</td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>: {{$data->keterangan}}</td>
                </tr>
            </table>
        </div>
        @if ($data->history->count())
        <div class="mb-3 col-12">
            <fieldset class="p-3 border rounded">
                <legend class="fs-6">Riwayat Approval</legend>
                <ul class="timeline-xs">
                    @foreach ($data->history->reverse() as $item)
                    <li class="timeline-item {{ $item->status_approve === 0 ? 'danger' : 'success' }}">
                        <div class="margin-left-15">
                            <div class="text-muted text-small">
                                {{ $item->tanggal->format('d-m-Y H:i') }}
                            </div>
                            @if (!is_null($item->status_approve))
                            <p>
                                {{ $item->status_approve === 1 ? 'Disetujui oleh: ' : 'Ditolak oleh:' }}
                                <span class="fw-bold">
                                    {{ ucwords($item->user_approve) }}
                                </span>
                            </p>
                            @endif
                            @if ($item->keterangan)
                                <p>Keterangan: {{ $item->keterangan }}</p>
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ul>
            </fieldset>
        </div>
        @endif
        @if (request()->routeIs('pengajuan.cuti.approve.show'))
            <div class="col-12">
                <x-forms.radio name="status_approve" value="" :options="['Setuju' => '1', 'Tolak' => '0']" label="Approval" />
                <x-forms.textarea name="keterangan" label="Keterangan" />
            </div>
        @endif
    </div>
</x-modal>