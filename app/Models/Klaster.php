<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klaster extends Model
{
    use HasFactory;

    protected $table = 'klasters'; // <--- Wajib ditambahkan agar tidak mencari tabel 'klaster'

    protected $fillable = [
        'anchor_lat',
        'anchor_lng',
        'status',
        'assigned_to',
        'alasan_tolak',
        'foto_bukti',
    ];

    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'klaster_id');
    }
}