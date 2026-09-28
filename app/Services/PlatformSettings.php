<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class PlatformSettings
{
    public const DEFAULTS = [
        'user_area_blocked' => '0',
        'user_area_message' => 'La plateforme est momentanément indisponible. Merci de revenir un peu plus tard.',
        'registration_blocked' => '0',
        'login_video_url' => 'https://www.youtube.com/watch?v=xuPkjiRKuiY',
    ];

    public function all(): array
    {
        $stored = DB::table('app_settings')->pluck('value', 'key')->all();

        return array_replace(self::DEFAULTS, $stored);
    }

    public function update(array $settings): void
    {
        $now = now();
        foreach ($settings as $key => $value) {
            DB::table('app_settings')->updateOrInsert(
                ['key' => $key],
                ['value' => (string) $value, 'updated_at' => $now, 'created_at' => $now]
            );
        }
    }

    public static function youtubeVideoId(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        $parts = parse_url($url);
        $host = strtolower($parts['host'] ?? '');
        $path = trim($parts['path'] ?? '', '/');
        $videoId = null;

        if (in_array($host, ['youtu.be', 'www.youtu.be'], true)) {
            $videoId = explode('/', $path)[0] ?? null;
        } elseif (in_array($host, ['youtube.com', 'www.youtube.com', 'm.youtube.com', 'youtube-nocookie.com', 'www.youtube-nocookie.com'], true)) {
            parse_str($parts['query'] ?? '', $query);
            $videoId = $query['v'] ?? null;

            if (!$videoId && preg_match('~^(?:embed|shorts|live)/([^/]+)~', $path, $matches)) {
                $videoId = $matches[1];
            }
        }

        return is_string($videoId) && preg_match('/^[A-Za-z0-9_-]{6,20}$/', $videoId)
            ? $videoId
            : null;
    }

    public static function youtubeEmbedUrl(?string $url): string
    {
        $videoId = self::youtubeVideoId($url);

        return $videoId
            ? 'https://www.youtube-nocookie.com/embed/' . $videoId
            : 'https://www.youtube-nocookie.com/embed/xuPkjiRKuiY';
    }
}
