<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'rincian',
        'ikon',
        'urutan',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'rincian' => 'array',
            'status' => 'boolean',
        ];
    }
}