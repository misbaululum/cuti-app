<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\User;
use Mockery\Matcher\Not;
use Illuminate\Http\Request;
use App\Models\SetupAplikasi;
use App\Services\CutiService;
use App\DataTables\CutiDataTable;
use App\Http\Requests\CutiRequest;
use Illuminate\Support\Facades\DB;
use App\Notifications\CutiNotification;
use Illuminate\Support\Facades\Notification;

class CutiController extends Controller
{

    public function __construct(private CutiService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(CutiDataTable $cutiDataTable)
    {
        return $cutiDataTable->render('pages.pengajuan.cuti');
    }

    public function hitungCuti(Request $request)
    {
        $request->validate([
           'tanggal_awal' => 'required|date:d-m-Y',
           'tanggal_akhir' => 'required|date:d-m-Y',
        ]);

        try {
            $totalCuti = $this->service->hitungCuti($request);
            
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
       
        return view('pages.pengajuan.cuti-form', [
            'action' => route('pengajuan.cuti.store'),
            'data' => new Cuti(),
            'hmin' => $this->service->hmin(setupAplikasi('hmin_cuti')),
            'sisaCuti' => user()->cutiTahunanActive->sisa_cuti
        ]);
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(CutiRequest $request, Cuti $cuti)
    {
        DB::beginTransaction();
        try {
            // cek outstanding pengajuan
            if (user()->cuti()->whereNull('status_approve')->orWhere(function($query){
                $query->whereNotNull('status_approve')->whereHas(
                    'latestHistory',
                    function ($query) {
                        $query->whereNotNull('next_approve');
                    }
                );
            })->first()) throw new \Exception('Masih ada cuti yang belum diproses');

            $request->fillData($cuti);
            $cuti->fill([
                'uuid' => \Illuminate\Support\Str::uuid(),
                'user_id' => user('id'),
                'user_input' => user('nama'),
                'nomor' => numbering($cuti, 'PC'.date('ym')),
                'total_cuti' => $this->service->hitungCuti($request)
            ]);

            $cuti->save();

            $atasanLangsung = user()->atasan()->wherePivot('level', 1)->first();

            // create history
            $history = $cuti->history()->create([
                'keterangan' => 'Input Cuti',
                'user_id' => user('id'),
                'next_approve_id' => $atasanLangsung?->id,
                'next_approve' => $atasanLangsung?->nama,
                'tanggal' => now()
            ]);


            // notification ke atasan langsung
            if ($atasanLangsung) {
                Notification::send($atasanLangsung, new CutiNotification($cuti, [
                    'title' => 'Pengajuan Cuti',
                    'body' => 'Terdapat pengajuan nomor: '. $cuti->nomor . ', an '.$cuti->user_input,
                ]));
            } else {
                $hrd = User::role('hrd')->first();
                $history->next_approve_id = $hrd->id;
                $history->next_approve = $hrd->name;
                $history->save();
                Notification::send($hrd, new CutiNotification($cuti, [
                    'title' => 'Pengajuan Cuti',
                    'body' => 'Terdapat pengajuan nomor: '. $cuti->nomor . ', an '.$cuti->user_input,
                ]));
            }

            DB::commit();

            return responseSuccess();
        } catch (\Throwable $th) {
            DB::rollBack();
            return responseError($th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cuti $cuti)
    {
        return view('pages.pengajuan.cuti-form-detail', [
           'data' => $cuti,
           'action' => null
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cuti $cuti)
    {
        return view('pages.pengajuan.cuti-form', [
            'action' => route('pengajuan.cuti.update', $cuti->uuid),
            'data' => $cuti,
            'hmin' => $this->service->hmin(setupAplikasi('hmin_cuti')),
            'sisaCuti' => user()->cutiTahunanActive->sisa_cuti
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CutiRequest $request, Cuti $cuti)
    {
        $request->fillData($cuti);

        $cuti->fill([
            'total_cuti' => $this->service->hitungCuti($request)
        ]);

        $cuti->save();

        return responseSuccess();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cuti $cuti)
    {
        //
    }
}
