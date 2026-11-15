<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Laporan;

class KlasterRiwayat extends Model
{
    protected $table = 'klaster_riwayat';

    protected $guarded = [];

    public function klaster(): BelongsTo
    {
        return $this->belongsTo(Klaster::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function petugasSebelum(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_sebelum');
    }

    public function petugasSesudah(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_sesudah');
    }

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class);
    }
}