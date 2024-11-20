<?php

namespace App\Http\Requests;

use App\Models\Izin;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class IzinRequest extends FormRequest
{
    public function fillData(Izin $izin)
    {
        $izin->fill([
            'tanggal_awal' => convertDate($this->tanggal_awal, 'Y-m-d'),
            'tanggal_akhir' => convertDate($this->tanggal_akhir, 'Y-m-d'),
            'keterangan' => $this->keterangan,
            'jenis' => $this->jenis
            
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
            'jenis' => 'required|in:sakit,izin',
            'foto' => [Rule::requiredIf(function() {
                return request('jenis') == 'sakit';
            })],
        ];
    }
}
