<?php

namespace App\Http\Controllers;

use App\Services\PlatformSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminSettingsController extends Controller
{
    public function index(PlatformSettings $settings)
    {
        return view('admin.settings.index', ['settings' => $settings->all()]);
    }

    public function update(Request $request, PlatformSettings $settings)
    {
        $validated = $request->validate([
            'user_area_blocked' => ['nullable', 'boolean'],
            'user_area_message' => ['required', 'string', 'max:500'],
            'registration_blocked' => ['nullable', 'boolean'],
            'login_video_url' => [
                'required',
                'url',
                'max:2048',
                function (string $attribute, mixed $value, \Closure $fail) {
                    if (!PlatformSettings::youtubeVideoId($value)) {
                        $fail('Indique un lien vidéo YouTube valide.');
                    }
                },
            ],
        ]);

        DB::transaction(function () use ($settings, $validated) {
            $settings->update([
                'user_area_blocked' => !empty($validated['user_area_blocked']) ? '1' : '0',
                'user_area_message' => trim($validated['user_area_message']),
                'registration_blocked' => !empty($validated['registration_blocked']) ? '1' : '0',
                'login_video_url' => trim($validated['login_video_url']),
            ]);
        });

        return redirect()->route('admin.settings')
            ->with('success', 'Les paramètres ont été enregistrés.');
    }
}
