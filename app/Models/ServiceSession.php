<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ServiceSession extends Model
{
    protected $fillable = [
        'user_id',
        'machine_id',
        'machine_name',
        'started_at',
        'finished_at',
        'duration_seconds',
        'status',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function report(): HasOne
    {
        return $this->hasOne(ServiceReport::class);
    }

    public function getDurationFormattedAttribute(): string
    {
        $seconds = $this->duration_seconds ?? 0;
        $h = intdiv($seconds, 3600);
        $m = intdiv($seconds % 3600, 60);
        $s = $seconds % 60;

        if ($h > 0) {
            return sprintf('%dh %02dmin %02ds', $h, $m, $s);
        }

        if ($m > 0) {
            return sprintf('%dmin %02ds', $m, $s);
        }

        return sprintf('%ds', $s);
    }
}
