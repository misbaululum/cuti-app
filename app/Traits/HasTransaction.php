<?php

namespace App\Traits;

use App\Models\History;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasTransaction
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function history(): MorphMany
    {
        return $this->morphMany(History::class, 'referensi');
    }

    public function latestHistory(): MorphOne
    {
        return $this->morphOne(History::class, 'referensi')->ofMany(['tanggal' => 'max']);
    }

    public function routeNotification(?int $priority = 1, $ref = 'notification'): string
    {
        return route($this->route, ['id' => $this->uuid ?? $this->id, 'priority' => $priority, 'ref' => $ref]);
    }

    public function notificationTitle(): string{
        return $this->notificationTitle;
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

}
