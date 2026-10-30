<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporans';

    protected $fillable = ['klaster_id', 'lat', 'lng', 'deskripsi'];

    public function klaster(): BelongsTo
    {
        return $this->belongsTo(Klaster::class, 'klaster_id');
    }
}
