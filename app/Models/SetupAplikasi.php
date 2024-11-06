<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetupAplikasi extends Model
{
    protected $table = 'setup_aplikasi';

    protected $guarded = ['id'];

    protected $casts = [
        'hmin_cuti' => 'integer',
        'hari_kerja' => 'array',
    ];
}
