<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;

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
            ->select('id', 'total_cuti', 'status_approve', 'user_input')
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
}
