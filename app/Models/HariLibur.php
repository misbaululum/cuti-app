<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HariLibur extends Model
{
    protected $table = 'hari_libur';

    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_awal' => 'date',
        'tanggal_akhir' => 'date',
    ];

    public function scopeActive($query)
{
    return $query->where(function ($query) {
        $query->orWhere(function ($query) {
            $query->whereDate('tanggal_akhir', '>=', convertDate(request('tanggal_awal'), 'Y-m-d'))
                  ->whereDate('tanggal_awal', '<=', convertDate(request('tanggal_akhir'), 'Y-m-d'));
        });
    });
}

}
