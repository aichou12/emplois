<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Statistiques — Administration PGDE</title>
    <link rel="icon" href="{{ asset('images/logogris.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pgde-admin.css') }}?v=admin-sidebar-sage-v4">
    <link rel="stylesheet" href="{{ asset('assets/css/pgde-dashboard.css') }}?v=dashboard-motion-v2">
    <link rel="stylesheet" href="{{ asset('assets/css/pgde-statistics.css') }}?v=statistics-v3">
</head>
<body>
    @include('partials.site-header')
    <div class="wrapper pgde-admin-wrapper">
        @include('admin.partials.sidebar')
        <main class="main-panel pgde-admin-main">
            @include('admin.partials.page-header')
            <div class="container"><div class="page-inner">
                <div class="pgde-statistics pgde-dashboard">
                    <form class="pgde-statistics-filters" method="GET" action="{{ route('admin.statistics') }}">
                        <div class="pgde-statistics-filter-title"><span class="pgde-statistics-filter-icon"><i class="fas fa-sliders-h" aria-hidden="true"></i></span><div><strong>Affiner l’analyse</strong><small>La période pilote les inscriptions ; les critères de profil filtrent les répartitions.</small></div></div>
                        <label><span>Année d’inscription</span><select name="year"><option value="">Période personnalisée</option>@foreach($years as $year)<option value="{{ $year }}" @selected($selectedYear === (int) $year)>{{ $year }}</option>@endforeach</select></label>
                        @if(!$selectedYear)
                            <label><span>Du</span><input type="date" name="date_from" value="{{ $dateFrom->toDateString() }}" max="{{ $dateTo->toDateString() }}"></label>
                            <label><span>Au</span><input type="date" name="date_to" value="{{ $dateTo->toDateString() }}" max="{{ today()->toDateString() }}"></label>
                        @else
                            <div class="pgde-statistics-year-hint"><i class="far fa-calendar-check" aria-hidden="true"></i><span>Année complète</span><strong>{{ $selectedYear }}</strong></div>
                        @endif
                        <label><span>Région de résidence</span><select name="region"><option value="">Toutes les régions</option>@foreach($regions as $region)<option value="{{ $region->id }}" @selected(($filters['region'] ?? '') == $region->id)>{{ $region->libelle }}</option>@endforeach</select></label>
                        <label><span>Sexe</span><select name="gender"><option value="">Tous</option><option value="Masculin" @selected(($filters['gender'] ?? '') === 'Masculin')>Masculin</option><option value="Feminin" @selected(($filters['gender'] ?? '') === 'Feminin')>Féminin</option></select></label>
                        <label><span>Niveau d’étude</span><select name="academic"><option value="">Tous les niveaux</option>@foreach($academics as $academic)<option value="{{ $academic->id }}" @selected(($filters['academic'] ?? '') == $academic->id)>{{ $academic->libelle }}</option>@endforeach</select></label>
                        <label><span>Secteur recherché</span><select name="sector"><option value="">Tous les secteurs</option>@foreach($sectors as $sector)<option value="{{ $sector->id }}" @selected(($filters['sector'] ?? '') == $sector->id)>{{ $sector->libelle }}</option>@endforeach</select></label>
                        <div class="pgde-statistics-filter-actions"><button type="submit"><i class="fas fa-filter" aria-hidden="true"></i> Appliquer</button><a href="{{ route('admin.statistics') }}">Réinitialiser</a></div>
                    </form>

                    @if($errors->any())<div class="pgde-statistics-error" role="alert">{{ $errors->first() }}</div>@endif
                    <div class="pgde-statistics-period"><span><i class="far fa-calendar-alt" aria-hidden="true"></i> Période analysée</span><strong>{{ $dateFrom->format('d/m/Y') }} — {{ $dateTo->format('d/m/Y') }}</strong><small>Comparaison avec les {{ $dateFrom->diffInDays($dateTo) + 1 }} jours précédents</small></div>

                    <section class="pgde-dashboard-kpis" aria-label="Indicateurs de la période">
                        <article class="pgde-dashboard-card pgde-dashboard-kpi">
                            <span class="pgde-dashboard-kpi-icon"><i class="fas fa-user-plus" aria-hidden="true"></i></span>
                            <div>
                                <div class="pgde-dashboard-kpi-value">{{ number_format($registrationCount, 0, ',', ' ') }}</div>
                                <div class="pgde-dashboard-kpi-label">Nouvelles inscriptions</div>
                                <div class="pgde-dashboard-kpi-note {{ $registrationChange !== null && $registrationChange < 0 ? 'is-yellow' : '' }}">
                                    @if($registrationChange === null)
                                        Première période de comparaison
                                    @else
                                        <i class="fas fa-{{ $registrationChange >= 0 ? 'arrow-up' : 'arrow-down' }}" aria-hidden="true"></i>
                                        {{ abs($registrationChange) }} % vs période précédente
                                    @endif
                                </div>
                            </div>
                        </article>
                        <article class="pgde-dashboard-card pgde-dashboard-kpi"><span class="pgde-dashboard-kpi-icon"><i class="fas fa-id-card" aria-hidden="true"></i></span><div><div class="pgde-dashboard-kpi-value">{{ number_format($profileCount, 0, ',', ' ') }}</div><div class="pgde-dashboard-kpi-label">Profils candidats</div><div class="pgde-dashboard-kpi-note">{{ $profileRate }} % des nouveaux inscrits</div></div></article>
                        <article class="pgde-dashboard-card pgde-dashboard-kpi"><span class="pgde-dashboard-kpi-icon is-yellow"><i class="fas fa-user-clock" aria-hidden="true"></i></span><div><div class="pgde-dashboard-kpi-value">{{ number_format($withoutProfileCount, 0, ',', ' ') }}</div><div class="pgde-dashboard-kpi-label">Sans dossier candidat</div><div class="pgde-dashboard-kpi-note is-yellow">Comptes créés sans profil</div></div></article>
                        <article class="pgde-dashboard-card pgde-dashboard-kpi"><span class="pgde-dashboard-kpi-icon"><i class="fas fa-user-check" aria-hidden="true"></i></span><div><div class="pgde-dashboard-kpi-value">{{ number_format($activeCount, 0, ',', ' ') }}</div><div class="pgde-dashboard-kpi-label">Comptes activés</div><div class="pgde-dashboard-kpi-note">{{ $activationRate }} % des inscriptions</div></div></article>
                        <article class="pgde-dashboard-card pgde-dashboard-kpi"><span class="pgde-dashboard-kpi-icon is-blue"><i class="fas fa-briefcase" aria-hidden="true"></i></span><div><div class="pgde-dashboard-kpi-value">{{ number_format($recruitedCount, 0, ',', ' ') }}</div><div class="pgde-dashboard-kpi-label">Candidats recrutés</div><div class="pgde-dashboard-kpi-note">Comptes marqués recrutés</div></div></article>
                    </section>

                    <section class="pgde-dashboard-grid-2" aria-label="Évolution et répartition des inscriptions">
                        <article class="pgde-dashboard-card pgde-statistics-trend-card"><div class="pgde-statistics-card-heading"><div><h2 class="pgde-dashboard-card-title">Évolution des inscriptions</h2><p>Nombre de comptes créés {{ $weeklyTrend ? 'par semaine' : 'chaque jour' }}</p></div><span class="pgde-statistics-badge"><i class="fas fa-chart-line" aria-hidden="true"></i> {{ $registrationCount }} au total</span></div>
                            @if($registrationCount > 0)<div class="pgde-statistics-trend" role="img" aria-label="Inscriptions par jour sur la période">@foreach($days as $day)<div class="pgde-statistics-day" title="{{ $day['date'] }} : {{ $day['total'] }} inscription(s)"><span class="pgde-statistics-day-value">{{ $day['total'] ?: '' }}</span><span class="pgde-statistics-day-bar" style="--bar-height: {{ max(4, (int) round(($day['total'] / $maxDaily) * 100)) }}%"></span>@if($loop->first || $loop->last || $loop->iteration % max(1, (int) ceil($days->count() / 10)) === 0)<span class="pgde-statistics-day-label">{{ $day['label'] }}</span>@endif</div>@endforeach</div>@else<div class="pgde-statistics-empty"><i class="far fa-chart-bar" aria-hidden="true"></i><span>Aucune inscription sur cette période.</span></div>@endif
                        </article>
                        <article class="pgde-dashboard-card"><div class="pgde-statistics-card-heading"><div><h2 class="pgde-dashboard-card-title">État des dossiers</h2><p>Avancement des comptes inscrits pendant la période</p></div></div>
                            <div class="pgde-statistics-progress"><div class="pgde-statistics-progress-head"><span>Profil candidat créé</span><strong>{{ $profileRate }} %</strong></div><div class="pgde-statistics-progress-track"><span style="width: {{ $profileRate }}%"></span></div><small>{{ number_format($profileCount, 0, ',', ' ') }} profil(s) sur {{ number_format($registrationCount, 0, ',', ' ') }} inscription(s)</small></div>
                            <div class="pgde-statistics-progress is-activation"><div class="pgde-statistics-progress-head"><span>Compte activé</span><strong>{{ $activationRate }} %</strong></div><div class="pgde-statistics-progress-track"><span style="width: {{ $activationRate }}%"></span></div><small>{{ number_format($activeCount, 0, ',', ' ') }} compte(s) activé(s)</small></div>
                            @if($hasProfileFilter)<p class="pgde-statistics-note"><i class="fas fa-info-circle" aria-hidden="true"></i> Les critères de région, sexe, niveau d’étude et secteur filtrent les profils des graphiques. Les indicateurs de comptes restent calculés sur toutes les inscriptions de la période.</p>@endif
                        </article>
                    </section>

                    <section class="pgde-dashboard-grid-3" aria-label="Répartition des profils candidats">
                        <article class="pgde-dashboard-card"><h2 class="pgde-dashboard-card-title">Par région de résidence</h2>@include('admin.statistics.partials.ranking', ['items' => $regionStats])</article>
                        <article class="pgde-dashboard-card"><h2 class="pgde-dashboard-card-title">Par niveau d’étude</h2>@include('admin.statistics.partials.ranking', ['items' => $academicStats, 'variant' => 'chips'])</article>
                        <article class="pgde-dashboard-card"><h2 class="pgde-dashboard-card-title">Par sexe</h2>@php($genderTotal = (int) $genderStats->sum())
                            @if($genderTotal > 0)
                                @php($maleShare = $genderTotal > 0 ? round(((int) ($genderStats['Masculin'] ?? 0)) / $genderTotal * 100) : 0)
                                <div class="pgde-statistics-gender-summary">
                                    <div class="pgde-statistics-gender-donut" style="--male-share: {{ $maleShare }}%"><div><strong>{{ $genderTotal }}</strong><small>profils</small></div></div>
                                    <div class="pgde-statistics-gender-legend">
                                        <div><i class="is-male"></i><span>Masculin</span><strong>{{ number_format((int) ($genderStats['Masculin'] ?? 0), 0, ',', ' ') }}</strong><small>{{ $maleShare }} %</small></div>
                                        <div><i class="is-female"></i><span>Féminin</span><strong>{{ number_format((int) ($genderStats['Feminin'] ?? 0), 0, ',', ' ') }}</strong><small>{{ 100 - $maleShare }} %</small></div>
                                    </div>
                                </div>
                            @else<p class="pgde-dashboard-empty">Aucun sexe renseigné pour ces profils.</p>@endif
                        </article>
                    </section>

                    <section class="pgde-dashboard-grid-2" aria-label="Expérience et emplois recherchés">
                        <article class="pgde-dashboard-card"><h2 class="pgde-dashboard-card-title">Années d’expérience</h2>@include('admin.statistics.partials.ranking', ['items' => $experienceStats, 'variant' => 'tiles'])</article>
                        <article class="pgde-dashboard-card"><h2 class="pgde-dashboard-card-title">Emplois les plus recherchés</h2>@include('admin.statistics.partials.ranking', ['items' => $employmentStats])</article>
                    </section>
                    <p class="pgde-statistics-footnote"><i class="fas fa-database" aria-hidden="true"></i> Les statistiques sont calculées à partir des comptes et profils déjà enregistrés. Aucun historique antérieur aux données conservées n’est reconstitué.</p>
                </div>
            </div></div>
        </main>
    </div>
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
    <script src="{{ asset('assets/js/pgde-admin.js') }}?v=settings-dropdown-v1"></script>
</body>
</html>
