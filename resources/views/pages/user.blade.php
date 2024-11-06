<x-master-layout>
    <div class="card">
        <div class="card-header">List User</div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <button class="btn btn-primary" data-action="{{ route('users.create') }}">Tambah</button>
                    </div>
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
    @push('jsModule')
        @vite(['resources/js/pages/user.js'])
    @endpush
    @push('js')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush
</x-master-layout>