<x-modal title="Form User" action="{{ $action }}">
    @if ($data->id)
        @method('put')
    @endif
    <div class="row">
        <div class="col-md-6">
            <x-forms.input label="Nama" name="nama" value="{{ $data->nama }}" />
        </div>
        <div class="col-md-6">
            <x-forms.input label="Email" name="email" value="{{ $data->email }}" />
        </div>
        <div class="col-md-6">
            <x-forms.input type="password" label="Password" name="password" />
        </div>
        <div class="col-md-6">
            <x-forms.input type="password" label="Confirm Password" name="password_confirmation" />
        </div>
        <div class="col-md-12">
            <x-forms.radio value="{{ $data->karyawan?->jenis_kelamin }}" :options="$jenisKelamin" label="Jenis Kelamin :" name="jenis_kelamin" />
        </div>
        <div class="col-md-6">
            <x-forms.select name="divisi" label="Divisi :">
            @foreach ($divisi as $item)
            <option value="{{ $item->id }}">{{ $item->nama }}</option> 

            @endforeach
            </x-forms>
        </div>
        <div class="col-md-6">
            <x-forms.select name="status_karyawan" label="Status Karyawan :">
            @foreach (['Tetap' => 'tetap', 'Kontrak' => 'kontrak', 'Training' => 'training', ] as $key => $value)
            <option value="{{ $value }}">{{ $key }}</option> 

            @endforeach
            </x-forms>
        </div>
        <div class="col-md-6">
            <x-forms.datepicker label="Tanggal Masuk" name="tanggal_masuk" value="{{ $data->karyawan?->tanggal_masuk }}" />
        </div>

        <hr class="mt-3 mb-3" />
        
        <div class="col-12">
            <button type="button" class="btn btn-info add-atasan" data-action="{{ route('users.list-atasan') }}">
                Tambah Atasan 
            </button>

            <table class="table">
                <thead>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Level</th>
                </thead>
                <tbody id="listAtasan">

                </tbody>
            </table>
        </div>
    </div>
</x-modal>