<?php

namespace App\Services;

use App\Models\HariLibur;
use Illuminate\Http\Request;

class CutiService
{
    /**
     * Create a new class instance.
     */
    public function hmin($min = 7, $format = 'Y-m-d')
    {
        $min += 1;
        return date_create("+{$min} days")->format($format);
    }

    public function hitungCuti(Request $request)
    {
        $tanggalAwal = date_create($request->tanggal_awal);
        $tanggalAkhir = date_create($request->tanggal_akhir);

        $totalCuti = $tanggalAwal->diff($tanggalAkhir)->format('%a') + 1;

        // cek hmin cuti
        if ($tanggalAwal < date_create($this->hmin(setupAplikasi('hmin_cuti')))) throw new \Exception('Pengajuan Cuti Min H-'.setupAplikasi('hmin_cuti'));
        
        // hitung libur besar di hari kerja
        $hariLiburNasional = 0;

        foreach(HariLibur::query()->active($request)->get() as $item) {
            for($i = 0; $i <= date_create($item->tanggal_awal)->diff(date_create($item->tanggal_akhir))->format('%a'); $i++) { 
                $date = date_create($item->tanggal_awal)->modify("+{$i} days");

                if ($date >= $tanggalAwal && $date <= $tanggalAkhir) {
                   
                    if (in_array($date->format('D'), setupAplikasi('hari_kerja'))) {
                        $hariLiburNasional ++;
                    }
                }
            }
        }

        //hitung hari libur
        $tanggalAwal->modify('-1 days');
        $hariLibur = 0;
        
        for ($i = 0; $i < $totalCuti; $i++) {
            if (!in_array($tanggalAwal->modify('+1 days')->format('D'), setupAplikasi('hari_kerja'))) {
                $hariLibur++;
            }
        }

        $totalCuti -= ($hariLiburNasional + $hariLibur);
        if ($totalCuti == 0) throw new \Exception('Pengajuan cuti minimal 1 hari');

        // cek dengan sisa cuti
        $sisaCuti = user()->cutiTahunanActive->sisa_cuti;
        if ($totalCuti > ($sisaCuti)) throw new \Exception('Pengajuan cuti melebihi sisa cuti');

        return $totalCuti;
    }

}
