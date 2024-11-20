<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Izin extends Model
{
    use HasFactory;

    protected $table = 'izin';
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_awal' => 'date',
        'tanggal_akhir' => 'date'
    ];

    public function history(): MorphMany
    {
        return $this->morphMany(History::class, 'referensi');
    }

    public function latestHistory()
    {
        return $this->morphOne(History::class, 'referensi')->ofMany(['tanggal' => 'max']);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function foto(): MorphMany
    {
        return $this->morphMany(Foto::class, 'referensi');
    }

}
