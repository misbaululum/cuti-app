<?php

namespace App\DataTables;

use App\Models\Izin;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class IzinDataTable extends DataTable
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
                $actions['Detail'] = ['action' => route('pengajuan.cuti.show', $row->uuid)];
                if ($row->status_approve == null && $row->user_id == user('id')) {
                    $actions['Edit'] = ['action' => route('pengajuan.cuti.edit', $row->uuid)];
                }
                if ($row->latestHistory->next_approve_id == user('id')) {
                    $actions['Approve'] = ['action' => route('pengajuan.cuti.approve.show', $row->uuid)];
                }
                return view('action', compact('actions'));
            })
            ->editColumn('tanggal_awal', fn ($row) => $row->tanggal_awal->format('d-m-Y'))
            ->editColumn('tanggal_akhir', fn ($row) => $row->tanggal_akhir->format('d-m-Y'))
            ->editColumn('approval', function ($row) {
                if ($row->status_approve === 0) {
                    return "<span class='badge bg-danger'>Ditolak oleh {$row->user_approve}</span>";  
                } else {
                    if (is_null($row->latestHistory->next_approve)) {
                        return "<span class='badge bg-success'>Disetujui oleh {$row->latestHistory->user_approve}</span>";
                    }
                    if ($row->latestHistory) {
                        return "<p class='mb-0 badge bg-info'>Menunggu approve {$row->latestHistory->next_approve}</p>";
                    }
                    // if ($row->step != $row->step_approve) {
                    //     $atasan = $row->user->atasan->filter(fn ($item) => $item->pivot->level == $row->step)->first()?->name ?? 'hrd';
                    //     return "<span class='badge bg-info'>Menunggu approve {$atasan}</span>";
                    // }
                    // return "<span class='badge bg-success'>Disetujui oleh {$row->user_approve}</span>";
                }
            })
            ->rawColumns(['action', 'approval'])
            ->addIndexColumn();
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Izin $model): QueryBuilder
    {
        $model = $model->when(!user()->hasRole('hrd'), function ($query) {
            $query->with(['user.atasan', 'latestHistory'])->where('user_id', user('id'))
                 ->orWhereHas('user.atasan', function ($query) {
                     $query->where('atasan_id', user('id'));
                 }); 
         });
 
         return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->setHtml('izin-table');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('#')->searchable(false)->orderable(false),
            Column::make('id')->hidden(),
            Column::make('nomor'),
            Column::make('user_input')->title('Karyawan'),
            Column::make('tanggal_awal'),
            Column::make('tanggal_akhir'),
            Column::make('total_izin'),
            Column::make('approval'),
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
        return 'Izin_' . date('YmdHis');
    }
}
