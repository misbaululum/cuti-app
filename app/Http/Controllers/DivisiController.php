<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;
use App\DataTables\DivisiDataTable;
use App\Http\Requests\DivisiRequest;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DivisiDataTable $divisiDataTable)
    {
        return $divisiDataTable->render('pages.divisi');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.divisi-form',[
            'action' => route('divisi.store'),
            'data' => new Divisi(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DivisiRequest $request)
    {
        Divisi::create($request->validated());

        return responseSuccess();
    }

    /**
     * Display the specified resource.
     */
    public function show(Divisi $divisi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Divisi $divisi)
    {
        return view('pages.divisi-form',[
            'action' => route('divisi.update', $divisi->id),
            'data' => $divisi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DivisiRequest $request, Divisi $divisi)
    {
        $divisi->fill($request->validated());
        $divisi->save();

        return responseSuccess();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Divisi $divisi)
    {
        $divisi->active = 0;
        $divisi->save();

        return responseSuccess('Berhasil menghapus data');
    }
}
