<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Suivi mobile — Administration PGDE</title>
    <link rel="icon" href="{{ asset('images/logogris.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pgde-admin.css') }}?v=admin-sidebar-sage-v4">
    <link rel="stylesheet" href="{{ asset('assets/css/pgde-dashboard.css') }}?v=dashboard-motion-v2">
    <link rel="stylesheet" href="{{ asset('assets/css/pgde-mobile-monitor.css') }}?v=mobile-monitor-v2">
</head>
<body>
    @include('partials.site-header')
    <div class="wrapper pgde-admin-wrapper">
        @include('admin.partials.sidebar')
        <main class="main-panel pgde-admin-main">
            @include('admin.partials.page-header')
            <div class="container"><div class="page-inner">
                <div class="pgde-mobile-page pgde-dashboard">
                    <section class="pgde-dashboard-kpis" aria-label="Indicateurs de l’activité mobile">
                        <article class="pgde-dashboard-card pgde-dashboard-kpi pgde-mobile-metric">
                            <span class="pgde-dashboard-kpi-icon"><i class="fas fa-sign-in-alt" aria-hidden="true"></i></span>
                            <div><div class="pgde-dashboard-kpi-value">{{ number_format($successfulLogins, 0, ',', ' ') }}</div><div class="pgde-dashboard-kpi-label">Connexions réussies</div><div class="pgde-dashboard-kpi-note">Sur la période sélectionnée</div></div>
                        </article>
                        <article class="pgde-dashboard-card pgde-dashboard-kpi pgde-mobile-metric">
                            <span class="pgde-dashboard-kpi-icon"><i class="fas fa-user-check" aria-hidden="true"></i></span>
                            <div><div class="pgde-dashboard-kpi-value">{{ number_format($uniqueAccounts, 0, ',', ' ') }}</div><div class="pgde-dashboard-kpi-label">Comptes connectés</div><div class="pgde-dashboard-kpi-note">Comptes distincts sur la période</div></div>
                        </article>
                        <article class="pgde-dashboard-card pgde-dashboard-kpi pgde-mobile-metric">
                            <span class="pgde-dashboard-kpi-icon is-yellow"><i class="fas fa-user-clock" aria-hidden="true"></i></span>
                            <div><div class="pgde-dashboard-kpi-value">{{ number_format($failedLogins, 0, ',', ' ') }}</div><div class="pgde-dashboard-kpi-label">Échecs de connexion</div><div class="pgde-dashboard-kpi-note is-yellow">Sur la période sélectionnée</div></div>
                        </article>
                        <article class="pgde-dashboard-card pgde-dashboard-kpi pgde-mobile-metric">
                            <span class="pgde-dashboard-kpi-icon"><i class="fas fa-key" aria-hidden="true"></i></span>
                            <div><div class="pgde-dashboard-kpi-value">{{ number_format($activeApiTokens, 0, ',', ' ') }}</div><div class="pgde-dashboard-kpi-label">Jetons API utilisés</div><div class="pgde-dashboard-kpi-note">Encore valides sur la période</div></div>
                        </article>
                    </section>

                    <form class="pgde-mobile-filters" method="GET" action="{{ route('admin.mobile') }}">
                        <div class="pgde-mobile-filter-heading">
                            <div><strong>Choisir une période</strong><small>Les indicateurs et le journal suivent cette période.</small></div>
                            @if($filters)<a href="{{ route('admin.mobile') }}">Réinitialiser</a>@endif
                        </div>
                        <label><span>Du</span><input type="date" name="date_from" value="{{ $dateFrom->toDateString() }}" max="{{ today()->toDateString() }}"></label>
                        <label><span>Au</span><input type="date" name="date_to" value="{{ $dateTo->toDateString() }}" max="{{ today()->toDateString() }}"></label>
                        <button type="submit"><i class="fas fa-filter" aria-hidden="true"></i> Appliquer</button>
                    </form>

                    @if($errors->any())
                        <div class="pgde-mobile-error" role="alert">{{ $errors->first() }}</div>
                    @endif

                    <section class="pgde-mobile-chart-card pgde-dashboard-card" aria-labelledby="mobile-chart-title">
                        <div class="pgde-mobile-section-heading">
                            <div><div><h3 class="pgde-dashboard-card-title" id="mobile-chart-title">Connexions réussies par jour</h3><p>Répartition sur la période sélectionnée</p></div></div>
                            <span class="pgde-mobile-period-pill">{{ $dateFrom->format('d/m/Y') }} — {{ $dateTo->format('d/m/Y') }}</span>
                        </div>
                        @if($days->contains(fn ($day) => $day['total'] > 0))
                            <div class="pgde-mobile-chart" role="img" aria-label="Graphique des connexions mobiles réussies par jour">
                                @foreach($days as $day)
                                    <div class="pgde-mobile-chart-column" title="{{ $day['date'] }} : {{ $day['total'] }} connexion(s)">
                                        <span class="pgde-mobile-chart-value">{{ $day['total'] ?: '' }}</span>
                                        <span class="pgde-mobile-chart-bar" style="--bar-height: {{ max(5, (int) round(($day['total'] / $maxDailyLogins) * 100)) }}%"></span>
                                        <span class="pgde-mobile-chart-label">{{ $day['label'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="pgde-mobile-empty-chart"><i class="far fa-chart-bar" aria-hidden="true"></i><span>Aucune connexion réussie sur cette période.</span></div>
                        @endif
                    </section>

                    <section class="pgde-mobile-events-card pgde-dashboard-card" aria-labelledby="mobile-events-title">
                        <div class="pgde-mobile-section-heading pgde-mobile-events-heading">
                            <div><div><h3 class="pgde-dashboard-card-title" id="mobile-events-title">Journal des connexions mobiles</h3><p>{{ $loginEvents->total() }} événement(s) correspondant aux filtres</p></div></div>
                            <form class="pgde-mobile-search" method="GET" action="{{ route('admin.mobile') }}">
                                <input type="hidden" name="date_from" value="{{ $dateFrom->toDateString() }}">
                                <input type="hidden" name="date_to" value="{{ $dateTo->toDateString() }}">
                                <label class="sr-only" for="mobile-search">Rechercher un compte, un identifiant ou une adresse IP</label>
                                <i class="fas fa-search" aria-hidden="true"></i>
                                <input id="mobile-search" type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Compte, identifiant ou IP">
                                @if(!empty($filters['result']))<input type="hidden" name="result" value="{{ $filters['result'] }}">@endif
                            </form>
                        </div>

                        <form class="pgde-mobile-result-filter" method="GET" action="{{ route('admin.mobile') }}">
                            <input type="hidden" name="date_from" value="{{ $dateFrom->toDateString() }}">
                            <input type="hidden" name="date_to" value="{{ $dateTo->toDateString() }}">
                            @if(!empty($filters['search']))<input type="hidden" name="search" value="{{ $filters['search'] }}">@endif
                            <label for="mobile-result">Résultat</label>
                            <select id="mobile-result" name="result" onchange="this.form.submit()">
                                <option value="">Tous les résultats</option>
                                <option value="success" @selected(($filters['result'] ?? '') === 'success')>Connexion réussie</option>
                                <option value="password_rejected" @selected(($filters['result'] ?? '') === 'password_rejected')>Mot de passe incorrect</option>
                                <option value="account_not_found" @selected(($filters['result'] ?? '') === 'account_not_found')>Compte introuvable</option>
                                <option value="account_not_activated" @selected(($filters['result'] ?? '') === 'account_not_activated')>Compte non activé</option>
                                <option value="account_blocked" @selected(($filters['result'] ?? '') === 'account_blocked')>Compte suspendu</option>
                                <option value="rate_limited" @selected(($filters['result'] ?? '') === 'rate_limited')>Trop de tentatives</option>
                            </select>
                        </form>

                        <div class="pgde-mobile-table-wrap">
                            <table class="pgde-mobile-table">
                                <thead><tr><th>Compte</th><th>Résultat</th><th>Adresse IP</th><th>Appareil / navigateur déclaré</th><th>Date et heure</th></tr></thead>
                                <tbody>
                                    @forelse($loginEvents as $event)
                                        @php
                                            $resultLabels = [
                                                'success' => ['Connexion réussie', 'is-success'],
                                                'password_rejected' => ['Mot de passe incorrect', 'is-warning'],
                                                'account_not_found' => ['Compte introuvable', 'is-muted'],
                                                'account_not_activated' => ['Compte non activé', 'is-warning'],
                                                'account_blocked' => ['Compte suspendu', 'is-danger'],
                                                'rate_limited' => ['Trop de tentatives', 'is-danger'],
                                            ];
                                            [$resultLabel, $resultClass] = $resultLabels[$event->result] ?? [$event->result, 'is-muted'];
                                            $eventUser = $event->utilisateur;
                                            $eventName = $eventUser ? trim(($eventUser->firstname ?? '') . ' ' . ($eventUser->lastname ?? '')) : null;
                                        @endphp
                                        <tr>
                                            <td><div class="pgde-mobile-account"><span class="pgde-mobile-avatar" aria-hidden="true">{{ $eventName ? mb_strtoupper(mb_substr($eventName, 0, 1)) : '?' }}</span><span><strong>{{ $eventName ?: ($event->identifier_hint ?: 'Compte non identifié') }}</strong><small>{{ $eventUser?->email ?: ($eventUser?->username ?: ($event->utilisateur_id ? 'ID ' . $event->utilisateur_id : 'Tentative anonyme')) }}</small></span></div></td>
                                            <td><span class="pgde-mobile-status {{ $resultClass }}"><i class="fas {{ $event->result === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' }}" aria-hidden="true"></i>{{ $resultLabel }}</span></td>
                                            <td><span class="pgde-mobile-mono">{{ $event->ip_address ?: '—' }}</span></td>
                                            <td><span class="pgde-mobile-agent" title="{{ $event->user_agent }}">{{ $event->user_agent ? \Illuminate\Support\Str::limit($event->user_agent, 54) : 'Non communiqué' }}</span></td>
                                            <td><time datetime="{{ $event->created_at?->toIso8601String() }}">{{ $event->created_at?->format('d/m/Y · H:i') ?: '—' }}</time></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5"><div class="pgde-mobile-empty-table"><i class="fas fa-mobile-alt" aria-hidden="true"></i><strong>Aucun événement pour ces filtres</strong><span>Essayez d’élargir la période ou de modifier la recherche.</span></div></td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($loginEvents->hasPages())<div class="pgde-mobile-pagination">{{ $loginEvents->links() }}</div>@endif
                    </section>

                    <aside class="pgde-mobile-notice">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <p><strong>Portée du suivi</strong> Cette page comptabilise les événements de connexion à l’API mobile. Les anciennes connexions classées « historique » ne permettent pas d’identifier leur canal. Les actions dans l’application, les erreurs API hors connexion et la version installée ne sont pas encore suivies.</p>
                    </aside>
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
