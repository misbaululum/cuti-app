<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use Illuminate\Http\Request;
use App\Services\IzinService;
use App\DataTables\IzinDataTable;

class IzinController extends Controller
{

    public function __construct(private IzinService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(IzinDataTable $izinDataTable)
    {
        return $izinDataTable->render('pages.pengajuan.izin');
    }

    public function hitungIzin(Request $request)
    {
        $request->validate([
           'tanggal_awal' => 'required|date:d-m-Y',
           'tanggal_akhir' => 'required|date:d-m-Y',
        ]);

        try {
            $totalCuti = $this->service->hitungIzin($request);
            
            return $totalCuti;
        } catch (\Throwable $th) {
            return responseError($th);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.pengajuan.izin-form', [
            'data' => new Izin(),
            'action' => route('pengajuan.izin.store'),
            'hmin' => hmin(setupAplikasi('hmin_izin')),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Izin $izin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Izin $izin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Izin $izin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Izin $izin)
    {
        //
    }
}
