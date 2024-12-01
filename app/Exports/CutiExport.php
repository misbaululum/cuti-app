<?php

namespace App\Exports;

use App\Models\Cuti;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CutiExport implements FromCollection, WithHeadings
{
    protected $tanggal_awal;
    protected $tanggal_akhir;

    public function __construct($tanggal_awal, $tanggal_akhir)
    {
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
    }

    public function collection()
    {
        // Ambil data berdasarkan rentang tanggal
        $data = Cuti::whereBetween('tanggal_awal', [
            date('Y-m-d', strtotime($this->tanggal_awal)),
            date('Y-m-d', strtotime($this->tanggal_akhir))
        ])->get()->map(function ($item) {
            return [
                $item->nomor,
                $item->key,
                \Carbon\Carbon::parse($item->tanggal_awal)->format('d-m-Y'),
                \Carbon\Carbon::parse($item->tanggal_akhir)->format('d-m-Y'),
                $item->total_cuti,
            ];
        });

        return $data;
    }

    public function headings(): array
    {
        // Menambahkan header kolom setelah judul tabel
        return [
            'Nomor', 'Nama', 'Tanggal Awal', 'Tanggal Akhir', 'Total Cuti'
        ];
    }
}
