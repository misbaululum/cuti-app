<?php

namespace App\Models;

use App\Traits\HasTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cuti extends Model
{
    use HasFactory, HasTransaction;

    protected $table = 'cuti';

    protected $guarded = ['id'];
    protected $route = 'pengajuan.cuti.index';
    protected $notificationTitle = 'Pengajuan cuti';

    // public function cutiTahunanActive()
    // {
    //     return $this->cuti()->where('status', 'active')->first(); // Sesuaikan dengan logika bisnis Anda
    // }

    protected $casts = [
        'tanggal_awal' => 'date',
        'tanggal_akhir' => 'date'
    ];

    // public function history(): MorphMany
    // {
    //     return $this->morphMany(History::class, 'referensi');
    // }

    // public function latestHistory()
    // {
    //     return $this->morphOne(History::class, 'referensi')->ofMany(['tanggal' => 'max']);
    // }

    public function sisaCuti(): Attribute
    {
        return Attribute::make(get: fn ($value, array $attributes) => $attributes['sisa_cuti_awal'] - $attributes['total_cuti']);
    }

    // public function routeNotification(?int $priority = 1, $ref = 'notification')
    // {
    //     return route('pengajuan.cuti.index', ['id' => $this->uuid ?? $this->id, 'priority' => $priority, 'ref' => $ref]);
    // }

    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    // public function notificationTitle(): string{
    //     return 'Pengajuan Cuti';
    // }

    // public function getRouteKeyName()
    // {
    //     return 'uuid';
    // }

    // Relasi ke model User untuk approver
    public function approver()
    {
        return $this->belongsTo(User::class, 'approve_by'); // Kolom foreign key: approve_by
    }

    // Accessor untuk mendapatkan nama approver
    public function getNamaApproveAttribute()
    {
        return $this->approver ? $this->approver->name : 'Tidak Diketahui'; // Default jika approver kosong
    }

    // Relasi untuk mendapatkan atasan yang akan menyetujui selanjutnya
    public function nextApprover()
    {
        return $this->belongsTo(User::class, 'next_approve_id'); // Kolom foreign key: next_approve_id
    }

    // // Accessor untuk mendapatkan nama atasan yang akan approve selanjutnya
    // public function getNextApproveAttribute()
    // {
    //     return $this->nextApprover ? $this->nextApprover->name : 'Tidak Diketahui'; // Default jika next approver kosong
    // }

}
