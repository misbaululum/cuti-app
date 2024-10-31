<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\DataTables\UserDataTable;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\Divisi;
use DateTime;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(UserDataTable $UserDataTable)

    {
        return $UserDataTable->render('pages.user');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.user-form',[
            'action' => route('users.store'),
            'data' => new User(),
            'jenisKelamin' => [
                'Laki-laki' => 'L',
                'Perempuan' => 'P'
            ],
            'divisi' => Divisi::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = new User($request->validated());
            $user->password = Hash::make($request->password);
            $user->save();

            $divisi = Divisi::find($request->divisi);
            $user->karyawan()->create([
                'nama' => $user->nama,
                'divisi_id' => $request->divisi,
                'nama_divisi' => $divisi->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status_karyawan' => $request->status_karyawan,
                'tanggal_masuk' => (new DateTime($request->tanggal_masuk))->format('Y-m-d')
            ]);

            DB::commit();

        return response()->json([
            'status' => 'success'
        ]);
        } catch (\Throwable $th) {
            DB::rollBack();
        return response()->json([
            'status' => 'error',
            'message' => $th->getMessage()
        ], 403);
     }
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
