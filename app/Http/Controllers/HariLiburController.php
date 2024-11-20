<?php

namespace App\Http\Controllers;

use App\Http\Requests\HariLiburRequest;
use App\Models\HariLibur;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HariLiburController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->has('start') && request()->has('end')) {
            request()->merge([
                'tanggal_awal' => request()->start,
                'tanggal_akhir' => request()->end,
            ]);
            $hariLibur = HariLibur::active()->get()->map(function($item) {
                return [
                    'id' => $item->id,
                    'start' => $item->tanggal_awal,
                    'end' => $item->tanggal_akhir->addDay(),
                    'title' => $item->nama,
                    'textColor' => '#842029',
                    'backgroundColor' => '#f8d7da',
                    'borderColor' => '#f5c2c7',
                    'allDay' => true
                ];
            });

            return response()->json($hariLibur);
        }
        return view('pages.hari-libur');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.hari-libur-form', [
            'action' => route('hari-libur.store'),
            'data' => new HariLibur([
                'tanggal_awal' => date_create(request('tanggal_awal'))->format('d-m-Y'),
                'tanggal_akhir' => date_create(request('tanggal_akhir'))->format('d-m-Y'),
            ])
        ]); 
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HariLiburRequest $request, HariLibur $hariLibur)
    {
        $request->fillData($hariLibur);
        $hariLibur->save();

        return responseSuccess();
    }

    /**
     * Display the specified resource.
     */
    public function show(HariLibur $hariLibur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HariLibur $hariLibur)
    {
        return view('pages.hari-libur-form', [
            'action' => route('hari-libur.update', $hariLibur->id),
            'data' => $hariLibur
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HariLiburRequest $request, HariLibur $hariLibur)
    {
        try {
            if (user()->cannot('update', $hariLibur)) throw new \Exception('Anda tidak memiliki izin untuk mengedit data ini.');
            if ($request->has('delete')) {
                $hariLibur->delete();
            } else {
                if ($request->ref == 'modify') {
                    $tanggalAkhir = Carbon::create($request->input('tanggal_akhir'))->subDay()->format('Y-m-d');
                    $request->request->set('tanggal_akhir', $tanggalAkhir);
                }
    
                // Mengisi data dengan menggunakan HariLiburRequest
                $request->fillData($hariLibur);
                $hariLibur->save();
            }
    
            return responseSuccess();
            
        } catch (\Throwable $th) {
            return responseError($th);
            
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HariLibur $hariLibur)
    {
        //
    }
}
