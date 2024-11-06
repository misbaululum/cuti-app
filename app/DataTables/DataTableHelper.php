<?php

namespace App\DataTables;
use Yajra\DataTables\Html\Column;

trait DataTableHelper
{
    public function setHtml($tableName)
    {
        return $this->builder()
            ->parameters([
                'searchDelay' => 1000,
                'responsive' => [
                    'details' => [
                        'display' => 'jQuery.fn.dataTable.Responsive.display.childRowImmediate'
                    ]
                ]
            ])
            ->setTableId($tableName)
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1);
    }
}

