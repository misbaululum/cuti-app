<x-modal title="Form Cuti" action="{{ $action }}">
    @if ($data->id)
        @method('put')
    @endif
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning" data-hmin="{{ convertDate($hmin) }}">
                Sisa Cuti : <strong data-sisa_cuti_awal="{{ $sisaCuti }}">{{ $sisaCuti }}</strong>
            </div>
        </div>
        <div class="col-md-12">
            <x-forms.datepicker-range label="Tanggal libur" date_name1="tanggal_awal" date_name2="tanggal_akhir" 
            date_value1="{{ convertDate($data->tanggal_awal, 'd-m-Y') }}" date_value2="{{ convertDate($data->tanggal_akhir, 'd-m-Y') }}" 
            />
        </div>
        <div class="col-md-6">
            <x-forms.input id="total_cuti" label="Total pengajuan cuti" value="{{ $data->total_cuti }}" disabled />
        </div>
        <div class="col-md-6">
            <x-forms.input id="sisa_cuti" label="Sisa cuti" value="{{ $sisaCuti - ($data->total_cuti ??= 0) }}" disabled />
        </div>
        <div class="col-md-12">
            <x-forms.textarea name="keterangan" label="Keterangan" value="{{ $data->keterangan }}" />
        </div>
    </div>
</x-modal>