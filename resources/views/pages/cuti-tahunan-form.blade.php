<x-modal title="Form Divisi" action="{{ $action }}">
    @if ($data->id)
        @method('put')
    @endif

    <div class="row">
        <div class="col-md-6">
            <x-forms.input label="Total" name="total" value="{{ $data->total }}" />
        </div>
        <div class="col-md-6">
            <x-forms.datepicker label="Tahun" name="tahun" value="{{ $data->tahun }}" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <input hidden name="user_id" value="{{ $data->user_id }}" />
            <x-forms.input readonly label="User name" value="{{ $data->user?->nama }}" id="user_name" data-action="{{ route('users.list-atasan') }}" name="user_name" />
        </div>
    </div>
</x-modal>
