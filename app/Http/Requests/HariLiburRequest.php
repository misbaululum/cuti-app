<?php

namespace App\Http\Requests;

use App\Models\HariLibur;
use Illuminate\Foundation\Http\FormRequest;

class HariLiburRequest extends FormRequest
{
    public function fillData(HariLibur $hariLibur)
    {
        $hariLibur->fill([
            'tanggal_awal' => date_create($this->tanggal_awal)->format('Y-m-d'),
            'tanggal_akhir' => date_create($this->tanggal_akhir)->format('Y-m-d'),
            'nama' => $this->nama 
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
            'nama' => 'required',
        ];
    }
}
