<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Edukasi extends Model
{
    protected $fillable = [
        'jenis',
        'judul',
        'penulis',
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

    // Mengambil ID video dari URL YouTube
    public function getYoutubeVideoIdAttribute(): ?string
    {
        if (!$this->url_video) {
            return null;
        }

        $host = strtolower(parse_url($this->url_video, PHP_URL_HOST) ?? '');
        $path = parse_url($this->url_video, PHP_URL_PATH) ?? '';

        $videoId = null;

        if (in_array($host, ['youtu.be', 'www.youtu.be'])) {
            $videoId = trim($path, '/');
        } elseif (in_array($host, [
            'youtube.com',
            'www.youtube.com',
            'm.youtube.com',
        ])) {
            parse_str(parse_url($this->url_video, PHP_URL_QUERY) ?? '', $query);

            $videoId = $query['v'] ?? null;

            if (!$videoId && preg_match(
                '#^/(?:embed|shorts|live)/([a-zA-Z0-9_-]+)#',
                $path,
                $matches
            )) {
                $videoId = $matches[1];
            }
        }

        if (!$videoId || !preg_match('/^[a-zA-Z0-9_-]{11}$/', $videoId)) {
            return null;
        }

        return $videoId;
    }

    // Mengambil thumbnail otomatis dari YouTube atau Supabase
    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->jenis === 'video') {
            return $this->youtube_video_id
                ? "https://img.youtube.com/vi/{$this->youtube_video_id}/hqdefault.jpg"
                : null;
        }

        return $this->gambar
            ? \Illuminate\Support\Facades\Storage::disk('supabase')->url($this->gambar)
            : null;
    }

    // Membentuk URL untuk pemutar video
    public function getVideoEmbedUrlAttribute(): ?string
    {
        if (!$this->youtube_video_id) {
            return null;
        }

        return 'https://www.youtube-nocookie.com/embed/' . $this->youtube_video_id;
    }

    protected static function booted(): void
    {
        static::saving(function ($edukasi) {
            if ($edukasi->isDirty('status') && $edukasi->status === 'published') {
                $edukasi->published_at = now();
            }
        });
    }
}