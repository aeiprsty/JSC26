<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class YouTubeService
{
    public function getVideoId(string $url): ?string
    {
        $host = strtolower(parse_url($url, PHP_URL_HOST) ?? '');
        $path = parse_url($url, PHP_URL_PATH) ?? '';

        $videoId = null;

        if (in_array($host, ['youtu.be', 'www.youtu.be'])) {
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

        return $videoId;
    }

    public function getDuration(string $url): ?string
    {
        $videoId = $this->getVideoId($url);

        if (!$videoId || !config('services.youtube.key')) {
            return null;
        }

        try {
            $response = Http::timeout(10)->get(
                'https://www.googleapis.com/youtube/v3/videos',
                [
                    'part' => 'contentDetails',
                    'id' => $videoId,
                    'key' => config('services.youtube.key'),
                ]
            );

            if (!$response->successful()) {
                logger()->error('YouTube API Error', [
                    'status' => $response->status(),
                    'response' => $response->json(),
                ]);

                return null;
            }

            $duration = $response->json('items.0.contentDetails.duration');

            if (!$duration) {
                return null;
            }

            $interval = new \DateInterval($duration);

            $totalSeconds =
                ($interval->d * 86400) +
                ($interval->h * 3600) +
                ($interval->i * 60) +
                $interval->s;

            $hours = intdiv($totalSeconds, 3600);
            $minutes = intdiv($totalSeconds % 3600, 60);
            $seconds = $totalSeconds % 60;

            if ($hours > 0) {
                return sprintf('%d:%02d:%02d', $hours, $minutes, $seconds);
            }

            return sprintf('%02d:%02d', $minutes, $seconds);

        } catch (\Throwable $e) {
            report($e);

            return null;
        }
    }
}