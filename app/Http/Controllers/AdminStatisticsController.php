<?php

namespace App\Http\Controllers;

use App\Models\Academic;
use App\Models\Emploi;
use App\Models\Region;
use App\Models\Userdata;
use App\Models\Utilisateur;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminStatisticsController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from', 'before_or_equal:today'],
            'year' => ['nullable', 'integer', 'digits:4', 'min:1900', 'before_or_equal:' . now()->year],
            'region' => ['nullable', 'integer'],
            'gender' => ['nullable', 'in:Masculin,Feminin'],
            'academic' => ['nullable', 'integer'],
            'sector' => ['nullable', 'integer'],
        ]);

        $selectedYear = !empty($validated['year']) ? (int) $validated['year'] : null;
        if ($selectedYear) {
            $dateFrom = Carbon::create($selectedYear, 1, 1)->startOfDay();
            $dateTo = Carbon::create($selectedYear, 12, 31)->min(today())->startOfDay();
        } else {
            $dateTo = Carbon::parse($validated['date_to'] ?? today())->startOfDay();
            $dateFrom = Carbon::parse($validated['date_from'] ?? $dateTo->copy()->subDays(29)->toDateString())->startOfDay();
        }
        if ($dateFrom->diffInDays($dateTo) > 365) {
            return back()->withErrors(['date_from' => 'La période ne peut pas dépasser 366 jours.'])->withInput();
        }
        $endExclusive = $dateTo->copy()->addDay();
        $previousFrom = $dateFrom->copy()->subDays($dateFrom->diffInDays($dateTo) + 1);
        $previousTo = $dateFrom->copy()->subDay();

        $profileFilters = function ($query) use ($validated) {
            if (!empty($validated['region'])) $query->where('regionresidence_id', $validated['region']);
            if (!empty($validated['gender'])) $query->where('genre', $validated['gender']);
            if (!empty($validated['academic'])) $query->where('academic_id', $validated['academic']);
        };
        $profileQuery = Userdata::query();
        $profileFilters($profileQuery);
        if (!empty($validated['sector'])) {
            $employmentIds = Emploi::query()->select('id')->where('secteur_id', $validated['sector']);
            $profileQuery->where(function ($query) use ($employmentIds) {
                $query->whereIn('emploi1_id', $employmentIds)->orWhereIn('emploi2_id', $employmentIds);
            });
        }
        $periodProfileQuery = (clone $profileQuery)->whereIn('utilisateur_id', Utilisateur::query()
            ->select('id')->where('date_inscription', '>=', $dateFrom)->where('date_inscription', '<', $endExclusive));
        $profileIds = (clone $periodProfileQuery)->select('id');
        $hasProfileFilter = collect(['region', 'gender', 'academic', 'sector'])->contains(fn ($key) => !empty($validated[$key]));

        $periodUsers = Utilisateur::query()->where('date_inscription', '>=', $dateFrom)->where('date_inscription', '<', $endExclusive);
        $previousUsers = Utilisateur::query()->where('date_inscription', '>=', $previousFrom)->where('date_inscription', '<', $dateFrom);

        $registrationCount = (clone $periodUsers)->count();
        $previousRegistrationCount = (clone $previousUsers)->count();
        $profileCount = (clone $periodProfileQuery)->count();
        $activeCount = (clone $periodUsers)->where('enabled', true)->count();
        $recruitedCount = (clone $periodUsers)->where('recruted', true)->count();
        $withoutProfileCount = (clone $periodUsers)->whereDoesntHave('userdata')->count();

        $dailyCounts = (clone $periodUsers)->selectRaw('DATE(date_inscription) as day, COUNT(*) as total')
            ->groupBy('day')->orderBy('day')->pluck('total', 'day');
        $weeklyTrend = $dateFrom->diffInDays($dateTo) > 90;
        if ($weeklyTrend) {
            $weeklyCounts = [];
            foreach ($dailyCounts as $date => $total) {
                $week = Carbon::parse($date)->startOfWeek()->toDateString();
                $weeklyCounts[$week] = ($weeklyCounts[$week] ?? 0) + (int) $total;
            }
            $days = collect(CarbonPeriod::create($dateFrom->copy()->startOfWeek(), '1 week', $dateTo))->map(fn ($week) => [
                'label' => 'Sem. ' . $week->format('d/m'),
                'date' => $week->toDateString(),
                'total' => (int) ($weeklyCounts[$week->toDateString()] ?? 0),
            ]);
        } else {
            $days = collect(CarbonPeriod::create($dateFrom, $dateTo))->map(fn ($day) => [
                'label' => $day->format('d/m'),
                'date' => $day->toDateString(),
                'total' => (int) ($dailyCounts[$day->toDateString()] ?? 0),
            ]);
        }

        $regionCounts = (clone $periodProfileQuery)->selectRaw('regionresidence_id as item_id, COUNT(*) as total')
            ->whereNotNull('regionresidence_id')->groupBy('regionresidence_id')->orderByDesc('total')->limit(8)->get();
        $regionLabels = Region::whereIn('id', $regionCounts->pluck('item_id'))->pluck('libelle', 'id');
        $regionStats = $regionCounts->map(fn ($row) => ['label' => $regionLabels[$row->item_id] ?? 'Région inconnue', 'count' => (int) $row->total]);

        $academicCounts = (clone $periodProfileQuery)->selectRaw('academic_id as item_id, COUNT(*) as total')
            ->groupBy('academic_id')->orderByDesc('total')->limit(8)->get();
        $academicLabels = Academic::whereIn('id', $academicCounts->pluck('item_id')->filter())->pluck('libelle', 'id');
        $academicStats = $academicCounts->map(fn ($row) => ['label' => $row->item_id === null ? 'Non renseigné' : ($academicLabels[$row->item_id] ?? 'Niveau inconnu'), 'count' => (int) $row->total]);

        $genderStats = (clone $periodProfileQuery)->selectRaw('genre, COUNT(*) as total')->groupBy('genre')->pluck('total', 'genre');
        $experienceStats = (clone $periodProfileQuery)->selectRaw("CASE WHEN nombreanneeexpe IS NULL THEN 'Non renseignée' WHEN nombreanneeexpe < 2 THEN '0 à 1 an' WHEN nombreanneeexpe < 6 THEN '2 à 5 ans' WHEN nombreanneeexpe < 11 THEN '6 à 10 ans' ELSE '11 ans et plus' END as tranche, COUNT(*) as total")
            ->groupBy('tranche')->orderByDesc('total')->get()->map(fn ($row) => ['label' => $row->tranche, 'count' => (int) $row->total]);

        $employmentTotals = collect();
        foreach (['emploi1_id', 'emploi2_id'] as $column) {
            (clone $periodProfileQuery)->selectRaw($column.' as item_id, COUNT(*) as total')->whereNotNull($column)->groupBy($column)->get()->each(function ($row) use ($employmentTotals) {
                $employmentTotals->put($row->item_id, ($employmentTotals->get($row->item_id, 0)) + (int) $row->total);
            });
        }
        $employmentTotals = $employmentTotals->sortDesc()->take(8);
        $employmentLabels = Emploi::whereIn('id', $employmentTotals->keys())->pluck('libelle', 'id');
        $employmentStats = $employmentTotals->map(fn ($count, $id) => ['label' => $employmentLabels[$id] ?? 'Emploi inconnu', 'count' => $count])->values();

        $profileRate = $registrationCount > 0 ? round($profileCount / $registrationCount * 100) : 0;
        $activationRate = $registrationCount > 0 ? round($activeCount / $registrationCount * 100) : 0;
        $registrationChange = $previousRegistrationCount > 0
            ? round(($registrationCount - $previousRegistrationCount) / $previousRegistrationCount * 100, 1)
            : null;

        return view('admin.statistics.index', [
            'dateFrom' => $dateFrom, 'dateTo' => $dateTo, 'filters' => $validated,
            'selectedYear' => $selectedYear,
            'years' => $this->availableYears(),
            'registrationCount' => $registrationCount, 'previousRegistrationCount' => $previousRegistrationCount,
            'registrationChange' => $registrationChange, 'profileCount' => $profileCount,
            'activeCount' => $activeCount, 'recruitedCount' => $recruitedCount,
            'withoutProfileCount' => $withoutProfileCount, 'profileRate' => $profileRate, 'activationRate' => $activationRate,
            'days' => $days, 'maxDaily' => max(1, (int) $days->max('total')),
            'weeklyTrend' => $weeklyTrend,
            'regionStats' => $regionStats, 'academicStats' => $academicStats,
            'genderStats' => $genderStats, 'experienceStats' => $experienceStats, 'employmentStats' => $employmentStats,
            'regions' => Region::orderBy('libelle')->get(['id', 'libelle']),
            'academics' => Academic::orderBy('libelle')->get(['id', 'libelle']),
            'sectors' => DB::table('secteur')->orderBy('libelle')->get(['id', 'libelle']),
            'hasProfileFilter' => $hasProfileFilter,
        ]);
    }

    private function availableYears(): array
    {
        $firstRegistration = Utilisateur::query()->whereNotNull('date_inscription')->min('date_inscription');
        $firstYear = $firstRegistration ? Carbon::parse($firstRegistration)->year : now()->year;

        return range(now()->year, $firstYear);
    }
}
