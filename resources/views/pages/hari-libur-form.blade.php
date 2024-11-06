<x-modal title="Form Hari Libur" action="{{ $action }}">
    @if ($data->id)
        @method('put')
    @endif
    <div class="row">
        <div class="col-md-12">
            <x-forms.input label="Nama" name="nama" value="{{ $data->nama }}" />
    </div>
    <div class="col-md-12">
        <x-forms.datepicker-range label="Tanggal Libur" date_name1="tanggal_awal" date_name2="tanggal_akhir" 
        date_value1="{{ convertDate($data->tanggal_awal, 'd-m-Y') }}" date_value2="{{ convertDate($data->tanggal_akhir, 'd-m-Y') }}" 
        />
    </div>
    <div class="col-md-12">
        <x-forms.switch label="Delete?" name="delete" />
    </div>
    </div>
</x-modal>