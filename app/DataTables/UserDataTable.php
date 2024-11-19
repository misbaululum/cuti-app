<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    use DataTableHelper;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        //video ke 27
        return (new EloquentDataTable($query))
            ->addColumn('action', function($row) {
                $actions['Edit'] = ['action' => route('users.edit', $row->id)]; 
                $actions['Delete'] = ['action' => route('users.destroy', $row->id), 'method' => 'delete']; 
                return view('action', compact('actions'));
            })
            ->editColumn('roles', function ($row) {
                return $row->roles->pluck('name')->implode(',');
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y H:i');
            })
            ->editColumn('updated_at', function ($row) {
                return $row->updated_at->format('d-m-Y H:i');
            })
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->with('karyawan')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->setHtml('user-table');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->orderable(false)->searchable(false),
            Column::make('id')->hidden(),
            Column::make('nama'),
            Column::make('roles'),
            Column::make('email'),
            Column::make('karyawan.nama_divisi')->name('karyawan.nama_divisi')->title('Divisi'),
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
        return 'User_' . date('YmdHis');
    }
}
