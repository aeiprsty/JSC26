<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPenjemputan extends Model
{
    protected $fillable = [
        'kelurahan',
        'kecamatan',
        'cakupan_rt',
        'hari_penjemputan',
        'jam_mulai',
        'jam_selesai',
        'urutan',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }
}