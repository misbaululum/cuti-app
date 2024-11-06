<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    protected $table = 'divisi';

    protected $guarded = ['id'];

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class, 'divisi_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}


