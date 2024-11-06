<?php

namespace App\Http\Requests;

use App\Models\SetupAplikasi;
use Illuminate\Foundation\Http\FormRequest;

class SetupAplikasiRequest extends FormRequest
{
    public function fillData(SetupAplikasi $setupAplikasi)
    {
        $setupAplikasi->fill($this->validated());
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
    return [
        'hari_kerja' => 'required|array',  // Pastikan ini adalah array
        'hmin_cuti' => 'required|integer',
    ];
    }

}
