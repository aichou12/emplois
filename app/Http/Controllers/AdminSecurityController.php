<?php

namespace App\Http\Controllers;

use App\Models\SecurityBlockedAccount;
use App\Models\SecurityBlockedIp;
use App\Models\SecurityLoginEvent;
use App\Models\Utilisateur;
use App\Services\SecurityAccessService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminSecurityController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:180'],
            'channel' => ['nullable', Rule::in(['web', 'admin', 'mobile', 'historique'])],
            'result' => ['nullable', Rule::in(['success', 'password_rejected', 'account_not_found', 'account_not_activated', 'account_blocked', 'admin_access_denied', 'rate_limited'])],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
            'per_page' => ['nullable', Rule::in(['15', '30', '100'])],
        ]);

        $perPage = (int) ($filters['per_page'] ?? 15);

        $eventsQuery = SecurityLoginEvent::with('utilisateur')
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('ip_address', 'like', '%' . $search . '%')
                        ->orWhere('identifier_hint', 'like', '%' . $search . '%')
                        ->orWhereHas('utilisateur', function ($userQuery) use ($search) {
                            $userQuery->where('firstname', 'like', '%' . $search . '%')
                                ->orWhere('lastname', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%')
                                ->orWhere('username', 'like', '%' . $search . '%');
                        });

                    if (ctype_digit((string) $search)) {
                        $query->orWhere('utilisateur_id', (int) $search);
                    }
                });
            })
            ->when($filters['channel'] ?? null, fn ($query, $channel) => $query->where('channel', $channel))
            ->when($filters['result'] ?? null, fn ($query, $result) => $query->where('result', $result))
            ->when($filters['date_from'] ?? null, fn ($query, $date) => $query->where('created_at', '>=', $date . ' 00:00:00'))
            ->when($filters['date_to'] ?? null, fn ($query, $date) => $query->where('created_at', '<=', $date . ' 23:59:59'));

        $hasFilters = collect($filters)->contains(fn ($value) => filled($value));

        return view('admin.security.index', [
            'loginEvents' => $eventsQuery->latest('created_at')->paginate($perPage)->withQueryString()->onEachSide(1),
            'filters' => $filters,
            'perPage' => $perPage,
            'hasFilters' => $hasFilters,
            'blockedAccounts' => SecurityBlockedAccount::with(['utilisateur', 'blockedBy'])
                ->whereNull('released_at')->latest('blocked_at')->get(),
            'blockedIps' => SecurityBlockedIp::with('blockedBy')
                ->whereNull('released_at')->latest('blocked_at')->get(),
        ]);
    }

    public function blockAccount(Request $request, SecurityAccessService $security)
    {
        $validated = $request->validate([
            'account' => ['required', 'string', 'max:180'],
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        $identity = trim($validated['account']);
        $canonical = mb_strtolower($identity, 'UTF-8');
        $user = Utilisateur::where(function ($query) use ($identity, $canonical) {
            $query->where('email_canonical', $canonical)
                ->orWhere('username_canonical', $canonical)
                ->orWhere('email', $identity)
                ->orWhere('username', $identity);
        })->first();

        if (!$user) {
            return back()->withErrors(['account' => 'Aucun compte ne correspond à cet identifiant ou à cet e-mail.']);
        }

        if ((int) $user->id === (int) $request->user()->id) {
            return back()->withErrors(['account' => 'Vous ne pouvez pas suspendre votre propre compte.']);
        }

        if ($security->isAccountBlocked($user->id)) {
            return back()->withErrors(['account' => 'Ce compte est déjà suspendu.']);
        }

        if ($user->hasRole('admin')) {
            $activeAdmins = Utilisateur::where(function ($q) {
                $q->where('roles', 'like', '%ROLE_ADMIN%')
                  ->orWhere('roles', 'like', '%admin%');
            })->get()->filter(function (Utilisateur $admin) use ($security) {
                return $admin->hasRole('admin') && !$security->isAccountBlocked($admin->id);
            })->count();

            if ($activeAdmins <= 1) {
                return back()->withErrors(['account' => 'Le dernier compte administrateur actif ne peut pas être suspendu.']);
            }
        }

        DB::transaction(function () use ($user, $request, $validated) {
            SecurityBlockedAccount::create([
                'utilisateur_id' => $user->id,
                'blocked_by' => $request->user()->id,
                'reason' => trim($validated['reason'] ?? '') ?: null,
                'blocked_at' => now(),
            ]);
            $user->tokens()->delete();
        });

        return redirect()->route('admin.security')->with('success', 'Le compte a été suspendu.');
    }

    public function unblockAccount(SecurityBlockedAccount $block, Request $request)
    {
        abort_if($block->released_at !== null, 404);

        $block->update([
            'released_by' => $request->user()->id,
            'released_at' => now(),
        ]);

        return redirect()->route('admin.security')->with('success', 'La suspension du compte a été levée.');
    }

    public function blockIp(Request $request)
    {
        $validated = $request->validate([
            'ip_address' => ['required', 'ip'],
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        $alreadyBlocked = SecurityBlockedIp::where('ip_address', $validated['ip_address'])
            ->whereNull('released_at')->exists();

        if ($alreadyBlocked) {
            return back()->withErrors(['ip_address' => 'Cette adresse IP est déjà bloquée.']);
        }

        SecurityBlockedIp::create([
            'ip_address' => $validated['ip_address'],
            'blocked_by' => $request->user()->id,
            'reason' => trim($validated['reason'] ?? '') ?: null,
            'blocked_at' => now(),
        ]);

        return redirect()->route('admin.security')->with('success', 'L’adresse IP a été bloquée pour l’espace usager.');
    }

    public function unblockIp(SecurityBlockedIp $block, Request $request)
    {
        abort_if($block->released_at !== null, 404);

        $block->update([
            'released_by' => $request->user()->id,
            'released_at' => now(),
        ]);

        return redirect()->route('admin.security')->with('success', 'Le blocage de l’adresse IP a été levé.');
    }
}
