<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cuti extends Model
{
    use HasFactory;

    protected $table = 'cuti';

    protected $guarded = ['id'];

    // public function cutiTahunanActive()
    // {
    //     return $this->cuti()->where('status', 'active')->first(); // Sesuaikan dengan logika bisnis Anda
    // }

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

    public function sisaCuti(): Attribute
    {
        return Attribute::make(get: fn ($value, array $attributes) => $attributes['sisa_cuti_awal'] - $attributes['total_cuti']);
    }

    public function routeNotification(?int $priority = 1, $ref = 'notification')
    {
        return route('pengajuan.cuti.index', ['id' => $this->uuid ?? $this->id, 'priority' => $priority, 'ref' => $ref]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function notificationTitle(): string{
        return 'Pengajuan Cuti';
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
