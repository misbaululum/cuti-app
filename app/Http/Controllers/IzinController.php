<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\IzinService;
use App\DataTables\IzinDataTable;
use App\Http\Requests\IzinRequest;
use Illuminate\Support\Facades\DB;
use App\Notifications\IzinNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

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
    public function store(IzinRequest $request, Izin $izin)
    {
        DB::beginTransaction();
        try {
            // cek outstanding pengajuan
            if (user()->izin()->whereNull('status_approve')->orWhere(function($query){
                $query->whereNotNull('status_approve')->whereHas(
                    'latestHistory',
                    function ($query) {
                        $query->whereNotNull('next_approve');
                    }
                );
            })->first()) throw new \Exception('Masih ada izin yang belum diproses');

            $request->fillData($izin);
            $izin->fill([
                'total_izin' => $this->service->hitungIzin($request),
                'user_id' => user('id'),
                'user_input' => user('nama'),
                'nomor' => numbering($izin, 'PI'.date('ym')),
                'uuid' => \Illuminate\Support\Str::uuid()
            ]);

            $izin->save();

            $atasanLangsung = user()->atasan()->wherePivot('level', 1)->first();

            // create history
            $history = $izin->history()->create([
                'keterangan' => 'Input izin',
                'user_id' => user('id'),
                'next_approve_id' => $atasanLangsung?->id,
                'next_approve' => $atasanLangsung?->nama,
                'tanggal' => now()
            ]);

            if ($request->has('foto')) {
                foreach($request->foto as $foto) {
                    $filename = user('id').'izin'. rand().'.'. $foto->getClientOriginalExtension();
                    $foto->storeAs('public/images/izin', $filename);
                    $izin->foto()->create(['file_name' => $filename]);
                }
            }


            // notification ke atasan langsung
            if ($atasanLangsung) {
                Notification::send($atasanLangsung, new IzinNotification($izin, [
                    'title' => 'Pengajuan Izin',
                    'body' => 'Terdapat pengajuan nomor: '. $izin->nomor . ', an '.$izin->user_input,
                ]));
            } else {
                $hrd = User::role('hrd')->first();
                $history->next_approve_id = $hrd->id;
                $history->next_approve = $hrd->name;
                $history->save();
                Notification::send($hrd, new IzinNotification($izin, [
                    'title' => 'Pengajuan Izin',
                    'body' => 'Terdapat pengajuan nomor: '. $izin->nomor . ', an '.$izin->user_input,
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
