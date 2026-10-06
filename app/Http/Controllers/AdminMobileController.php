<?php

namespace App\Http\Controllers;

use App\Models\SecurityLoginEvent;
use App\Models\Utilisateur;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminMobileController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'date_from' => ['nullable', 'date', 'before_or_equal:today'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from', 'before_or_equal:today'],
            'result' => ['nullable', Rule::in([
                'success', 'password_rejected', 'account_not_found', 'account_not_activated',
                'account_blocked', 'rate_limited',
            ])],
            'search' => ['nullable', 'string', 'max:180'],
        ]);

        $to = CarbonImmutable::parse($filters['date_to'] ?? today())->endOfDay();
        $from = CarbonImmutable::parse($filters['date_from'] ?? $to->subDays(29)->toDateString())->startOfDay();
        if ($from->diffInDays($to->startOfDay()) > 89) {
            return back()->withErrors(['date_from' => 'La période ne peut pas dépasser 90 jours.'])->withInput();
        }

        $periodEvents = SecurityLoginEvent::query()
            ->where('channel', 'mobile')
            ->whereBetween('created_at', [$from, $to]);

        $successfulLogins = (clone $periodEvents)->where('result', 'success')->count();
        $uniqueAccounts = (clone $periodEvents)
            ->where('result', 'success')
            ->whereNotNull('utilisateur_id')
            ->distinct('utilisateur_id')
            ->count('utilisateur_id');
        $failedLogins = (clone $periodEvents)->where('result', '!=', 'success')->count();

        $activeApiTokens = DB::table('personal_access_tokens')
            ->where('tokenable_type', Utilisateur::class)
            ->whereNotNull('last_used_at')
            ->whereBetween('last_used_at', [$from, $to])
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->count();

        $dailyLogins = (clone $periodEvents)
            ->where('result', 'success')
            ->selectRaw('DATE(created_at) as event_date, COUNT(*) as total')
            ->groupByRaw('DATE(created_at)')
            ->pluck('total', 'event_date');

        $days = collect();
        $cursor = $from->startOfDay();
        while ($cursor->lte($to->startOfDay())) {
            $date = $cursor->toDateString();
            $days->push([
                'date' => $date,
                'label' => $cursor->format('d/m'),
                'total' => (int) ($dailyLogins[$date] ?? 0),
            ]);
            $cursor = $cursor->addDay();
        }
        $maxDailyLogins = max(1, (int) $days->max('total'));

        $eventsQuery = SecurityLoginEvent::with('utilisateur')
            ->where('channel', 'mobile')
            ->whereBetween('created_at', [$from, $to])
            ->when($filters['result'] ?? null, fn ($query, $result) => $query->where('result', $result))
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('ip_address', 'like', '%' . $search . '%')
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
            });

        return view('admin.mobile.index', [
            'filters' => $filters,
            'dateFrom' => $from,
            'dateTo' => $to,
            'successfulLogins' => $successfulLogins,
            'uniqueAccounts' => $uniqueAccounts,
            'failedLogins' => $failedLogins,
            'activeApiTokens' => $activeApiTokens,
            'days' => $days,
            'maxDailyLogins' => $maxDailyLogins,
            'loginEvents' => $eventsQuery->latest('created_at')->paginate(20)->withQueryString()->onEachSide(1),
        ]);
    }
}
