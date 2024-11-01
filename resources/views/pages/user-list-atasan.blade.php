<x-modal title="List Atasan">
    <div class="row">
        <div class="col-12">
            {{ $dataTable->table() }}
        </div>
    </div>
    {{ $dataTable->scripts() }}
</x-modal>