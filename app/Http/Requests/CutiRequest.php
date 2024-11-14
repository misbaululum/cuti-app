<?php

namespace App\Http\Requests;

use App\Models\Cuti;
use Illuminate\Foundation\Http\FormRequest;

class CutiRequest extends FormRequest
{

    public function fillData(Cuti $cuti)
    {
        $cuti->fill([
            'tanggal_awal' => convertDate($this->tanggal_awal, 'Y-m-d'),
            'tanggal_akhir' => convertDate($this->tanggal_akhir, 'Y-m-d'),
            'keterangan' => $this->keterangan,
            'sisa_cuti_awal' => user()->cutiTahunanActive->sisa_cuti,
            
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tanggal_awal' => 'required|date:d-m-Y',
            'tanggal_akhir' => 'required|date:d-m-Y',
            'keterangan' => 'required',
        ];
    }
}
