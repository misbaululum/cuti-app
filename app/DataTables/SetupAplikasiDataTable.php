<?php

namespace App\DataTables;

use App\Models\HariLibur;
use App\Models\SetupAplikasi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SetupAplikasiDataTable extends DataTable
{
    use DataTableHelper;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function($row) {
            $actions['Edit'] = ['action' => route('setup-aplikasi.edit', $row->id)]; 
            return view('action', compact('actions'));
        })
        ->editColumn('hari_kerja', function ($row) {
            $item = '';
            foreach ($row->hari_kerja as $hariLibur) {
                $item .= '<span class="badge bg-primary me-1">'. $hariLibur .'</span>';
            }
            return $item;
        })
        ->editColumn('created_at', function ($row) {
            return $row->created_at->format('d-m-Y H:i');
        })
        ->editColumn('updated_at', function ($row) {
            return $row->updated_at->format('d-m-Y H:i');
        })
        ->rawColumns(['action', 'hari_kerja'])
        ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SetupAplikasi $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->setHtml('setupaplikasi-table');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false),
            Column::make('id')->hidden(),
            Column::make('hmin_cuti'),
            Column::make('hari_kerja'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SetupAplikasi_' . date('YmdHis');
    }
}
