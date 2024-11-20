<x-modal title="Form Izin" action="{{ $action }}">
    @if ($data->id)
        @method('put')
    @endif
    <div class="row">
        <div class="col-md-12" data-hmin="{{ convertDate($hmin) }}">
            <x-forms.datepicker-range label="Tanggal libur" date_name1="tanggal_awal" date_name2="tanggal_akhir" 
            date_value1="{{ convertDate($data->tanggal_awal, 'd-m-Y') }}" date_value2="{{ convertDate($data->tanggal_akhir, 'd-m-Y') }}" 
            />
        </div>
        <div class="col-md-6">
            <x-forms.input id="total_izin" label="Total pengajuan izin" value="{{ $data->total_izin }}" disabled />
        </div>
        <div class="col-md-6">
            <x-forms.radio name="jenis" label="Jenis" value="{{ $data->jenis }}" :options="['Sakit' => 'sakit', 'Izin' => 'izin']" />
        </div>
        <div class="col-md-12">
            <x-forms.input type="file" name="foto[]" label="Foto" multiple />
        </div>
        <div class="col-md-12">
            <x-forms.textarea name="keterangan" label="Keterangan" value="{{ $data->keterangan }}" />
        </div>
    </div>
</x-modal>