<?php

namespace App\Http\Controllers;

use App\Services\PlatformSettings;
use App\Mail\ConfiguredEmailPreview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

    public function emailTemplates(PlatformSettings $settings)
    {
        return view('admin.settings.emails', ['settings' => $settings->all()]);
    }

    public function updateEmailTemplates(Request $request, PlatformSettings $settings)
    {
        $validated = $request->validate([
            'mail_verify_subject' => ['required', 'string', 'max:180', 'not_regex:/[\r\n]/'],
            'mail_verify_intro' => ['required', 'string', 'max:1500'],
            'mail_verify_signature' => ['required', 'string', 'max:300'],
            'mail_reset_subject' => ['required', 'string', 'max:180', 'not_regex:/[\r\n]/'],
            'mail_reset_intro' => ['required', 'string', 'max:1500'],
            'mail_reset_signature' => ['required', 'string', 'max:300'],
        ]);

        $settings->update(array_map('trim', $validated));

        return redirect()->route('admin.settings.emails')->with('success', 'Les modèles d’e-mail ont été enregistrés.');
    }

    public function previewEmailTemplate(string $template, PlatformSettings $settings)
    {
        abort_unless(in_array($template, ['verify', 'reset'], true), 404);

        $mail = new ConfiguredEmailPreview($template, $settings->all(), true, true);

        return response($mail->render())->header('Content-Type', 'text/html; charset=UTF-8');
    }

    public function sendTestEmail(Request $request, PlatformSettings $settings)
    {
        $validated = $request->validate([
            'template' => ['required', 'in:verify,reset'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        try {
            Mail::to($validated['email'])->send(new ConfiguredEmailPreview(
                $validated['template'],
                $settings->all(),
                true
            ));
        } catch (\Throwable $exception) {
            report($exception);

            return back()->withErrors(['test_email' => 'L’e-mail test n’a pas pu être envoyé. Vérifiez la configuration du service mail.']);
        }

        return back()->with('success', 'L’e-mail test a été envoyé à ' . $validated['email'] . '.');
    }

}
