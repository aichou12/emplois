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
            'result' => 'success',
            'ip_address' => $request->ip(),
            'user_agent' => mb_substr((string) $request->userAgent(), 0, 1000),
            'created_at' => $now,
        ]);
    }

    public function recordLoginFailure(
        Request $request,
        string $channel,
        string $result,
        ?Utilisateur $user = null,
        ?string $identifier = null
    ): void {
        SecurityLoginEvent::create([
            'utilisateur_id' => $user?->id,
            'channel' => $channel,
            'result' => $result,
            'identifier_hint' => $user ? null : $this->maskIdentifier($identifier),
            'ip_address' => $request->ip(),
            'user_agent' => mb_substr((string) $request->userAgent(), 0, 1000),
            'created_at' => now(),
        ]);
    }

    private function maskIdentifier(?string $identifier): ?string
    {
        $identifier = trim((string) $identifier);
        if ($identifier === '') {
            return null;
        }

        if (str_contains($identifier, '@')) {
            [$localPart, $domain] = array_pad(explode('@', $identifier, 2), 2, '');
            $visible = mb_substr($localPart, 0, 1, 'UTF-8');
            return mb_substr($visible . '***@' . $domain, 0, 180, 'UTF-8');
        }

        return mb_substr(mb_substr($identifier, 0, 1, 'UTF-8') . '***', 0, 180, 'UTF-8');
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
