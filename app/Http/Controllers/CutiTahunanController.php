<?php

namespace App\Http\Controllers;

use App\DataTables\CutiTahunanDataTable;
use App\Models\CutiTahunan;
use Illuminate\Http\Request;
use App\Http\Requests\CutiTahunanRequest;

class CutiTahunanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CutiTahunanDataTable $cutiTahunanDataTable)
    {
        return $cutiTahunanDataTable->render('pages.cuti-tahunan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.cuti-tahunan-form',[
            'action' => route('cuti-tahunan.store'),
            'data' => new CutiTahunan(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CutiTahunanRequest $request, CutiTahunan $cutiTahunan)
    {
        try {
            $request->validateExistingData();
            $request->fillData($cutiTahunan);

            $cutiTahunan->digunakan = 0;
            $cutiTahunan->save();

            return responseSuccess();
        } catch (\Throwable $th) {
            return responseError($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CutiTahunan $cutiTahunan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CutiTahunan $cutiTahunan)
    {
        return view('pages.cuti-tahunan-form',[
            'action' => route('cuti-tahunan.update', $cutiTahunan->id),
            'data' => $cutiTahunan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CutiTahunanRequest $request, CutiTahunan $cutiTahunan)
    {
        try {
            if ($cutiTahunan->user_id != $request->user_id) {
                $request->validateExistingData(); 
            }
    
            $request->fillData($cutiTahunan);
    
            $cutiTahunan->save();
            return responseSuccess();
            
        } catch (\Throwable $th) {
            return responseError($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CutiTahunan $cutiTahunan)
    {
        $cutiTahunan->delete();
        return responseSuccess('Berhasil menghapus data');
    }
}
