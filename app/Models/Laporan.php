<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laporan extends Model
{
    protected $table = 'laporan';
    protected $guarded = [];

    public function klaster(): BelongsTo
    {
        return $this->belongsTo(Klaster::class);
    }
}