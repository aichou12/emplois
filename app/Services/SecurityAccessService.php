<?php

namespace App\Services;

use App\Models\SecurityLoginEvent;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SecurityAccessService
{
    public function recordSuccessfulLogin(Utilisateur $user, Request $request, string $channel): void
    {
        $now = now();
        $user->update(['last_login' => $now]);

        SecurityLoginEvent::create([
            'utilisateur_id' => $user->id,
            'channel' => $channel,
            'ip_address' => $request->ip(),
            'user_agent' => mb_substr((string) $request->userAgent(), 0, 1000),
            'created_at' => $now,
        ]);
    }

    public function isAccountBlocked(int|string $userId): bool
    {
        return DB::table('security_blocked_accounts')
            ->where('utilisateur_id', $userId)
            ->whereNull('released_at')
            ->exists();
    }

    public function isIpBlocked(?string $ip): bool
    {
        return $ip !== null && DB::table('security_blocked_ips')
            ->where('ip_address', $ip)
            ->whereNull('released_at')
            ->exists();
    }
}
