<x-master-layout>
    <div class="card">
        <div class="card-header">List Hari Libur</div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
    @push('jsModule')
        @vite(['resources/js/pages/hari-libur.js'])
    @endpush
</x-master-layout>