<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MobileAppController extends Controller
{
    private const PLATFORMS = [
        'android' => 'Play Store',
        'ios' => 'App Store',
    ];

    // Cible des QR codes : redirige vers le store si l'app est publiée, sinon page « Bientôt disponible »
    public function show(string $platform): View|RedirectResponse
    {
        if (!array_key_exists($platform, self::PLATFORMS)) {
            abort(404);
        }

        $storeUrl = (string) config("mobile.{$platform}");
        if ($storeUrl !== '') {
            return redirect()->away($storeUrl);
        }

        return view('mobile.soon', [
            'storeName' => self::PLATFORMS[$platform],
        ]);
    }
}
