<?php

namespace App\Http\Controllers;

use App\Services\PlatformSettings;
use Illuminate\Contracts\View\View;
use Throwable;

class GuideController extends Controller
{
    // Page publique « Guide du candidat »
    public function show(PlatformSettings $settings): View
    {
        try {
            $platformValues = $settings->all();
        } catch (Throwable $exception) {
            // Table des réglages indisponible : on garde les valeurs par défaut
            report($exception);
            $platformValues = PlatformSettings::DEFAULTS;
        }

        return view('guide.show', [
            'guideVideoEmbedUrl' => PlatformSettings::youtubeEmbedUrl($platformValues['login_video_url'] ?? null),
            'registrationOpen' => ($platformValues['registration_blocked'] ?? '0') !== '1',
        ]);
    }
}
