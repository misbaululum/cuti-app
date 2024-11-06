<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    protected $table = 'cuti';

    public function cutiTahunanActive()
    {
        return $this->cuti()->where('status', 'active')->first(); // Sesuaikan dengan logika bisnis Anda
    }
}
