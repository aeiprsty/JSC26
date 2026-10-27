<?php

namespace App\Models;

use App\Enums\StatusKlaster;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Klaster extends Model
{
    protected $table = 'klaster';
    protected $guarded = [];
    protected $casts = ['status' => StatusKlaster::class];

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class);
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}