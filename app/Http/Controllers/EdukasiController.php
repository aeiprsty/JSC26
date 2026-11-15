<?php

namespace App\Http\Controllers;

use App\Models\Edukasi;
use Illuminate\View\View;

class EdukasiController extends Controller
{

    public function index(): View
    {
        $sort = request()->query('sort', 'desc');

        // Batasi pilihan hanya ASC atau DESC.
        $sort = in_array($sort, ['asc', 'desc']) ? $sort : 'desc';

        $videos = Edukasi::query()
            ->where('jenis', 'video')
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->orderBy('created_at', $sort)
            ->get();

        $artikels = Edukasi::query()
            ->where('jenis', 'artikel')
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->orderBy('created_at', $sort)
            ->get();

        return view('edukasi', compact('videos', 'artikels', 'sort'));
    }

    public function show(string $slug): View
    {
        $edukasi = Edukasi::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->firstOrFail();

        if ($edukasi->jenis === 'video') {
            $videoEmbedUrl = $edukasi->video_embed_url;

            return view('edukasi.detail-video', compact(
                'edukasi',
                'videoEmbedUrl'
            ));
        }

        return view('edukasi.detail-artikel', compact('edukasi'));
    }

    private function getYoutubeEmbedUrl(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        $host = strtolower(parse_url($url, PHP_URL_HOST) ?? '');
        $path = parse_url($url, PHP_URL_PATH) ?? '';

        $videoId = null;

        if ($host === 'youtu.be' || $host === 'www.youtu.be') {
            $videoId = trim($path, '/');
        } elseif (in_array($host, [
            'youtube.com',
            'www.youtube.com',
            'm.youtube.com',
        ])) {
            parse_str(parse_url($url, PHP_URL_QUERY) ?? '', $query);

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

        return 'https://www.youtube-nocookie.com/embed/' . $videoId;
    }
}