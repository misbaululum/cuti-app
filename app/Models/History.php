<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';
    protected $guarded = ['id'];
    public $timestamps = false;

    protected $casts = [
        'tanggal' => 'datetime',
    ];
}
