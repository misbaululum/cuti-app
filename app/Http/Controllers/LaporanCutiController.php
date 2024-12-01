<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Exports\CutiExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanCutiController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = [];
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $data = Cuti::query()
            ->select('id', 'total_cuti', 'status_approve', 'user_input', 'tanggal_awal', 'tanggal_akhir', 'nomor')
            ->where(function($query) {
                $query->whereDate('tanggal_akhir', '>=', convertDate(request('tanggal_awal'), 'Y-m-d'))
                      ->whereDate('tanggal_awal', '<=', convertDate(request('tanggal_akhir'), 'Y-m-d'));
            })
            ->where('status_approve', 1)
            ->whereHas('latestHistory', function($query) {
                $query->whereNull('next_approve');
            })
            ->get()->groupBy('user_input');
        }
        return view('pages.laporan.cuti', [
            'data' => $data
        ]);
    }

    public function export(Request $request)
    {
        // Ambil parameter tanggal dari request
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
    
        // Pastikan tanggal dalam format yang benar
        $tanggal_awal = Carbon::createFromFormat('d-m-Y', $tanggal_awal)->format('Y-m-d');
        $tanggal_akhir = Carbon::createFromFormat('d-m-Y', $tanggal_akhir)->format('Y-m-d');
    
        return Excel::download(
            new CutiExport($tanggal_awal, $tanggal_akhir),
            'cuti-' . Carbon::now()->timestamp . '.xlsx'
        );
    }
    
}
