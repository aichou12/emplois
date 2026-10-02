<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord — Administration PGDE</title>
    <link rel="icon" href="{{ asset('images/logogris.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pgde-admin.css') }}?v=admin-sidebar-sage-v4">
    <link rel="stylesheet" href="{{ asset('assets/css/pgde-dashboard.css') }}?v=dashboard-motion-v2">
</head>
<body>
    @include('partials.site-header')

    @php
        $activeRate = $registeredUsers > 0 ? round($activeUsers / $registeredUsers * 100) : 0;
        $diasporaRate = $totalUsers > 0 ? round($diasporaUsers / $totalUsers * 100, 1) : 0;
        $genderTotal = $totalMales + $totalFemales;
        $maleShare = $genderTotal > 0 ? round($totalMales / $genderTotal * 100, 1) : 50;
        $femaleShare = $genderTotal > 0 ? round($totalFemales / $genderTotal * 100) : 0;
        $maxRegionCount = max(1, (int) $regionStats->max('count'));
        $maxAcademicCount = max(1, (int) $academicStats->max('count'));
    @endphp

    <div class="wrapper pgde-admin-wrapper">
        @include('admin.partials.sidebar')

        <main class="main-panel pgde-admin-main">
            @include('admin.partials.page-header')



            <div class="container">
                <div class="page-inner">
                    <div class="pgde-dashboard">
                        <section class="pgde-dashboard-kpis" aria-label="Indicateurs principaux">
                            <article class="pgde-dashboard-card pgde-dashboard-kpi">
                                <span class="pgde-dashboard-kpi-icon"><i class="fas fa-users" aria-hidden="true"></i></span>
                                <div>
                                    <div class="pgde-dashboard-kpi-value">{{ number_format($registeredUsers, 0, ',', ' ') }}</div>
                                    <div class="pgde-dashboard-kpi-label">Inscrits</div>
                                    <div class="pgde-dashboard-kpi-note">{{ number_format($currentYearUsers, 0, ',', ' ') }} cette année</div>
                                </div>
                            </article>

                            <article class="pgde-dashboard-card pgde-dashboard-kpi">
                                <span class="pgde-dashboard-kpi-icon"><i class="fas fa-user-check" aria-hidden="true"></i></span>
                                <div>
                                    <div class="pgde-dashboard-kpi-value">{{ number_format($activeUsers, 0, ',', ' ') }}</div>
                                    <div class="pgde-dashboard-kpi-label">Comptes activés</div>
                                    <div class="pgde-dashboard-kpi-note">{{ $activeRate }} % des comptes</div>
                                </div>
                            </article>

                            <article class="pgde-dashboard-card pgde-dashboard-kpi">
                                <span class="pgde-dashboard-kpi-icon is-yellow"><i class="fas fa-user-clock" aria-hidden="true"></i></span>
                                <div>
                                    <div class="pgde-dashboard-kpi-value">{{ number_format($incomplet, 0, ',', ' ') }}</div>
                                    <div class="pgde-dashboard-kpi-label">Comptes sans dossier</div>
                                    <div class="pgde-dashboard-kpi-note is-yellow">Profil candidat absent</div>
                                </div>
                            </article>

                            <article class="pgde-dashboard-card pgde-dashboard-kpi">
                                <span class="pgde-dashboard-kpi-icon"><i class="fas fa-globe-africa" aria-hidden="true"></i></span>
                                <div>
                                    <div class="pgde-dashboard-kpi-value">{{ number_format($diasporaUsers, 0, ',', ' ') }}</div>
                                    <div class="pgde-dashboard-kpi-label">Diaspora</div>
                                    <div class="pgde-dashboard-kpi-note">{{ $diasporaRate }} % des profils</div>
                                </div>
                            </article>
                        </section>

                        <section class="pgde-dashboard-grid-2" aria-label="Évolution et répartition des candidats">
                            <article class="pgde-dashboard-card">
                                <h2 class="pgde-dashboard-card-title">Inscriptions par semaine</h2>
                                <div class="pgde-dashboard-chart">
                                    <canvas id="registrationTrendChart" role="img" aria-label="Nombre d’inscriptions par semaine sur les huit dernières semaines"></canvas>
                                </div>
                            </article>

                            <article class="pgde-dashboard-card">
                                <h2 class="pgde-dashboard-card-title">Répartition par sexe</h2>
                                @if($genderTotal > 0)
                                    <div class="pgde-dashboard-donut" style="--male-share: {{ $maleShare }}%" role="img" aria-label="{{ $maleShare }} % d’hommes et {{ $femaleShare }} % de femmes">
                                        <div class="pgde-dashboard-donut-center">
                                            <span class="pgde-dashboard-donut-value">{{ $femaleShare }} %</span>
                                            <span class="pgde-dashboard-donut-label">de femmes</span>
                                        </div>
                                    </div>
                                    <div class="pgde-dashboard-legend" aria-hidden="true">
                                        <span class="pgde-dashboard-legend-item"><i class="pgde-dashboard-legend-dot is-green"></i>Hommes {{ 100 - $femaleShare }} %</span>
                                        <span class="pgde-dashboard-legend-item"><i class="pgde-dashboard-legend-dot is-yellow"></i>Femmes {{ $femaleShare }} %</span>
                                    </div>
                                @else
                                    <p class="pgde-dashboard-empty">Aucune donnée de sexe renseignée.</p>
                                @endif
                            </article>
                        </section>

                        <section class="pgde-dashboard-grid-3" aria-label="Répartitions des profils candidats">
                            <article class="pgde-dashboard-card">
                                <h2 class="pgde-dashboard-card-title">Profils par région de résidence</h2>
                                @forelse($regionStats as $stat)
                                    <div class="pgde-dashboard-bar-row">
                                        <span class="pgde-dashboard-bar-label" title="{{ $stat['label'] }}">{{ $stat['label'] }}</span>
                                        <span class="pgde-dashboard-bar-track" aria-hidden="true"><span class="pgde-dashboard-bar-fill" style="width: {{ max(6, round($stat['count'] / $maxRegionCount * 100)) }}%"></span></span>
                                        <span class="pgde-dashboard-bar-value">{{ number_format($stat['count'], 0, ',', ' ') }}</span>
                                    </div>
                                @empty
                                    <p class="pgde-dashboard-empty">Aucune région de résidence renseignée.</p>
                                @endforelse
                            </article>

                            <article class="pgde-dashboard-card">
                                <h2 class="pgde-dashboard-card-title">Par niveau de diplôme</h2>
                                @forelse($academicStats as $stat)
                                    <div class="pgde-dashboard-bar-row">
                                        <span class="pgde-dashboard-bar-label" title="{{ $stat['label'] }}">{{ $stat['label'] }}</span>
                                        <span class="pgde-dashboard-bar-track" aria-hidden="true"><span class="pgde-dashboard-bar-fill" style="width: {{ max(6, round($stat['count'] / $maxAcademicCount * 100)) }}%"></span></span>
                                        <span class="pgde-dashboard-bar-value">{{ number_format($stat['count'], 0, ',', ' ') }}</span>
                                    </div>
                                @empty
                                    <p class="pgde-dashboard-empty">Aucun niveau de diplôme renseigné.</p>
                                @endforelse
                            </article>

                            <article class="pgde-dashboard-card">
                                <h2 class="pgde-dashboard-card-title">Emplois les plus demandés</h2>
                                @forelse($employmentStats as $stat)
                                    <div class="pgde-dashboard-rank">
                                        <span class="pgde-dashboard-rank-label">{{ $stat['label'] }}</span>
                                        <span class="pgde-dashboard-rank-count">{{ number_format($stat['count'], 0, ',', ' ') }}</span>
                                    </div>
                                @empty
                                    <p class="pgde-dashboard-empty">Aucun emploi ciblé renseigné.</p>
                                @endforelse
                            </article>
                        </section>
                    </div>
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid d-flex justify-content-center">
                    <div class="copyright text-center">© {{ now()->year }} MFPRSP</div>
                </div>
            </footer>
        </main>
    </div>

    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
    <script src="{{ asset('assets/js/pgde-admin.js') }}?v=settings-dropdown-v1"></script>
    <script>
        const trendCanvas = document.getElementById('registrationTrendChart');
        if (trendCanvas && window.Chart) {
            new Chart(trendCanvas, {
                type: 'line',
                data: {
                    labels: @json($registrationTrend->pluck('label')->values()),
                    datasets: [{
                        data: @json($registrationTrend->pluck('count')->values()),
                        borderColor: '#00843f',
                        backgroundColor: 'rgba(0, 132, 63, .12)',
                        borderWidth: 2.5,
                        pointRadius: 2,
                        pointHoverRadius: 4,
                        pointBackgroundColor: '#00843f',
                        fill: true,
                        lineTension: .35
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: { display: false },
                    scales: {
                        xAxes: [{ gridLines: { display: false }, ticks: { fontColor: '#6c757d' } }],
                        yAxes: [{
                            ticks: { beginAtZero: true, precision: 0, fontColor: '#6c757d' },
                            gridLines: { color: '#e5e5e5' }
                        }]
                    }
                }
            });
        }
    </script>
</body>
</html>
