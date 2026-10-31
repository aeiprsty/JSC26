<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Edukasi extends Model
{
    protected $fillable = [
        'jenis',
        'judul',
        'slug',
        'kategori',
        'ringkasan',
        'isi',
        'gambar',
        'url_video',
        'durasi',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }
}