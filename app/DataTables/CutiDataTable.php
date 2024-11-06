<?php

namespace App\DataTables;

use App\Models\Cuti;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

use App\DataTables\DataTableHelper;

class CutiDataTable extends DataTable
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
                
            })
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Cuti $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->setHtml('cuti-table');
    }
    /**
     * Get the dataTable columns definition.
     */

     public function getColumns(): array
     {
         return [
             Column::make('tanggal_awal'),
             Column::make('tanggal_akhir'),
             Column::make('total_cuti'),
         ];
     }
     

     

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Cuti_' . date('YmdHis');
    }
}
