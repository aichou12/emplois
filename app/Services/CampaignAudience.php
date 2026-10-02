<?php

namespace App\Services;

use App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Builder;

class CampaignAudience
{
    public function query(array $filters): Builder
    {
        $query = Utilisateur::query()
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->where(function (Builder $users) {
                $users->whereNull('roles')->orWhere('roles', 'not like', '%admin%');
            });

        if (!empty($filters['status'])) {
            match ($filters['status']) {
                'complete' => $query->whereHas('userdata'),
                'incomplete' => $query->whereDoesntHave('userdata'),
                'active' => $query->where('enabled', true),
                'inactive' => $query->where('enabled', false),
                'recruited' => $query->where('recruted', true),
                'not_recruited' => $query->where('recruted', false),
                default => null,
            };
        }

        if (!empty($filters['region'])) {
            $query->whereHas('userdata', fn (Builder $profile) => $profile->where('regionresidence_id', $filters['region']));
        }

        if (!empty($filters['academic'])) {
            if ($filters['academic'] === 'without') {
                $query->whereHas('userdata', fn (Builder $profile) => $profile->where('academic_id', 20));
            } elseif ($filters['academic'] === 'with') {
                $query->whereHas('userdata', fn (Builder $profile) => $profile->whereNotNull('academic_id')->where('academic_id', '!=', 20));
            } else {
                $query->whereHas('userdata', fn (Builder $profile) => $profile->where('academic_id', (int) $filters['academic']));
            }
        }

        if (!empty($filters['gender'])) {
            $query->whereHas('userdata', fn (Builder $profile) => $profile->where('genre', $filters['gender']));
        }

        if (!empty($filters['sector'])) {
            $sector = (int) $filters['sector'];
            $query->whereHas('userdata', fn (Builder $profile) => $profile->whereHas('emploi1', fn (Builder $job) => $job->where('secteur_id', $sector))
                ->orWhereHas('emploi2', fn (Builder $job) => $job->where('secteur_id', $sector)));
        }

        if (!empty($filters['employment'])) {
            $employment = (int) $filters['employment'];
            $query->whereHas('userdata', fn (Builder $profile) => $profile->where('emploi1_id', $employment)->orWhere('emploi2_id', $employment));
        }

        if (!empty($filters['experience'])) {
            $query->whereHas('userdata', function (Builder $profile) use ($filters) {
                match ($filters['experience']) {
                    'none' => $profile->where(fn (Builder $years) => $years->whereNull('nombreanneeexpe')->orWhere('nombreanneeexpe', '<=', 0)),
                    '1-2' => $profile->whereBetween('nombreanneeexpe', [1, 2]),
                    '3-5' => $profile->whereBetween('nombreanneeexpe', [3, 5]),
                    '6-plus' => $profile->where('nombreanneeexpe', '>=', 6),
                };
            });
        }

        if (!empty($filters['age'])) {
            $today = now()->startOfDay();
            $query->whereHas('userdata', function (Builder $profile) use ($filters, $today) {
                match ($filters['age']) {
                    '18-30' => $profile->whereDate('datenaiss', '>', $today->copy()->subYears(31))->whereDate('datenaiss', '<=', $today->copy()->subYears(18)),
                    '31-45' => $profile->whereDate('datenaiss', '<=', $today->copy()->subYears(31))->whereDate('datenaiss', '>', $today->copy()->subYears(46)),
                    '46-plus' => $profile->whereDate('datenaiss', '<=', $today->copy()->subYears(46)),
                };
            });
        }

        if (!empty($filters['registered_year'])) {
            $query->whereYear('date_inscription', (int) $filters['registered_year']);
        }

        return $query;
    }
}
