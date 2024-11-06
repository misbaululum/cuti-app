<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\CutiTahunan;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'user_id', 'id');
    }

    public function atasan()
    {
        return $this->belongsToMany(User::class, 'atasan_user', 'user_id', 'atasan_id')->withPivot('level');
    }

    public function cutiTahunan()
    {
        return $this->hasMany(CutiTahunan::class, 'user_id', 'id');
    }

    public function cutiTahunanActive()
    {
        return $this->hasOne(CutiTahunan::class, 'user_id', 'id')->ofMany(['tahun' => 'MAX'], function ($query) {
            return $query->where('tahun', date('Y'));
        });
    }
    
}
