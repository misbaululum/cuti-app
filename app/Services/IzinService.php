<?php

namespace App\Services;
use App\Models\HariLibur;
use Illuminate\Http\Request;

class IzinService
{
    
    public function hitungIzin(Request $request)
    {
        $tanggalAwal = date_create($request->tanggal_awal);
        $tanggalAkhir = date_create($request->tanggal_akhir);

        $totalCuti = $tanggalAwal->diff($tanggalAkhir)->format('%a') + 1;

        // cek hmin
        if ($request->jenis == 'izin' && $tanggalAwal < date_create(hmin(setupAplikasi('hmin_izin')))) throw new \Exception('Pengajuan izin min h-'.setupAplikasi('hmin_izin'));

        // hitung hari besar di hari kerja
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
        if ($totalCuti == 0) throw new \Exception('Pengajuan izin minimal 1 hari');

        return $totalCuti;
    }
}
