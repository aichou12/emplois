@php
    $userdata = $utilisateur->userdata;
    $isAdminPreview = auth()->user()?->hasRole('admin') ?? false;
    $formations = $userdata?->autresdiplomes;
    $formationsList = is_array($formations) ? $formations : (is_string($formations) ? json_decode($formations, true) : []);
    $formationsList = is_array($formationsList) ? $formationsList : [];
    $experiences = $userdata?->experiences;
    $experiencesList = is_array($experiences) ? $experiences : (is_string($experiences) ? json_decode($experiences, true) : []);
    $experiencesList = is_array($experiencesList) ? $experiencesList : [];
    if (empty($experiencesList) && !empty($experiences) && is_string($experiences) && trim($experiences) !== '') {
        $experiencesList = [[
            'poste' => $userdata->posteoccupe ?: 'Expérience professionnelle',
            'employeur' => $userdata->employeur ?: '',
            'years' => $userdata->anneeexperience1 ?: $userdata->nombreanneeexpe ?: null,
            'description' => $experiences,
        ]];
    }
    $academicMap = \App\Models\Academic::pluck('libelle', 'id')->toArray();

    $normalizeFiles = static function ($files) {
        if (is_array($files)) {
            return $files;
        }
        if (!is_string($files) || trim($files) === '') {
            return [];
        }
        $decoded = json_decode($files, true);
        return is_array($decoded) ? $decoded : [$files];
    };
    $cvFiles = $normalizeFiles($userdata?->cv_file);
    $diplomaFiles = $normalizeFiles($userdata?->diplome_file);
    $candidateName = trim(($utilisateur->firstname ?? '') . ' ' . ($utilisateur->lastname ?? '')) ?: ($utilisateur->username ?? 'Candidat');
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#00843f">
    <title>Profil de {{ $candidateName }} — PGDE</title>
    <link rel="icon" href="{{ asset('images/mfp.png') }}?v=2" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        :root { --resume-green: #00843f; --resume-green-dark: #006b33; --resume-green-soft: #ebf7f0; --resume-yellow: #fcc207; --resume-ink: #282b2d; --resume-muted: #6c757d; --resume-line: #e5e9e6; --resume-bg: #f4f6f5; --resume-card: #fafaf9; --resume-heading: 'Poppins', sans-serif; --resume-body: 'DM Sans', sans-serif; }
        *, *::before, *::after { box-sizing: border-box; }
        body { margin: 0; color: var(--resume-ink); background: var(--resume-bg); font: 15px/1.5 var(--resume-body); -webkit-font-smoothing: antialiased; }
        .resume-admin-bar { display: flex; min-height: 66px; align-items: center; justify-content: space-between; gap: 16px; padding: 10px max(24px, calc((100vw - 1160px) / 2)); border-bottom: 1px solid #e5ece7; background: #fff; }
        .resume-admin-context { display: flex; min-width: 0; align-items: center; gap: 12px; }
        .resume-admin-mark { display: grid; width: 38px; height: 38px; flex: 0 0 38px; place-items: center; border-radius: 11px; color: var(--resume-green-dark); background: var(--resume-green-soft); }
        .resume-admin-context strong { display: block; font-family: var(--resume-heading); font-size: 13px; font-weight: 700; }
        .resume-admin-context small { display: block; color: var(--resume-muted); font-size: 11px; }
        .resume-admin-actions { display: flex; align-items: center; gap: 8px; }
        .resume-action { display: inline-flex; min-height: 38px; align-items: center; justify-content: center; gap: 8px; padding: 0 12px; border: 1px solid #dce7df; border-radius: 7px; color: #3d5545; background: #fff; font: 600 12px var(--resume-body); text-decoration: none; cursor: pointer; transition: border-color .16s ease, color .16s ease, background .16s ease, transform .16s ease; }
        .resume-action:hover { transform: translateY(-1px); border-color: #aad1b7; color: var(--resume-green-dark); background: #f6fbf7; }
        .resume-action.is-primary { border-color: var(--resume-green); color: #fff; background: var(--resume-green); }
        .resume-action.is-primary:hover { border-color: var(--resume-green-dark); color: #fff; background: var(--resume-green-dark); }
        main.resume-wrap { width: min(100% - 32px, 1080px); margin: 28px auto 56px; }
        .resume-card { overflow: hidden; border: 1px solid var(--resume-line); border-radius: 12px; background: #fff; box-shadow: 0 10px 30px rgba(40, 43, 45,.06); }
        .resume-accent { height: 5px; background: linear-gradient(90deg, var(--resume-green) 0 80%, var(--resume-yellow) 100%); }
        .resume-inner { padding: 32px; }
        .resume-profile-head { display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 25px; padding-bottom: 24px; border-bottom: 1px solid var(--resume-line); }
        .resume-identity { display: flex; min-width: 0; align-items: center; gap: 18px; }
        .resume-avatar { width: 92px; height: 92px; flex: 0 0 92px; padding: 3px; border: 2px solid var(--resume-line); border-radius: 50%; background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,.07); object-fit: cover; }
        .resume-name { margin: 0 0 7px; font: 700 23px/1.3 var(--resume-heading); overflow-wrap: anywhere; }
        .resume-registration { display: inline-flex; align-items: center; gap: 8px; padding: 7px 10px; border: 1px solid #cfe8d9; border-radius: 8px; color: var(--resume-green-dark); background: #f0f8f3; font-size: 12px; }
        .resume-registration strong { font-weight: 700; }
        .resume-head-label { margin-top: 9px; color: var(--resume-muted); font-size: 12px; }
        .resume-head-label i { margin-right: 5px; color: var(--resume-green); }
        .resume-quick-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 12px; margin-bottom: 30px; }
        .resume-quick-item { display: flex; min-width: 0; align-items: center; gap: 10px; padding: 12px; border: 1px solid var(--resume-line); border-radius: 7px; background: var(--resume-card); }
        .resume-quick-icon { display: grid; width: 34px; height: 34px; flex: 0 0 34px; place-items: center; border-radius: 50%; color: var(--resume-green-dark); background: var(--resume-green-soft); font-size: 13px; }
        .resume-quick-label { margin-bottom: 2px; color: var(--resume-muted); font-size: 10px; font-weight: 700; letter-spacing: .035em; text-transform: uppercase; }
        .resume-quick-value { color: var(--resume-ink); font-size: 12px; font-weight: 600; overflow-wrap: anywhere; }
        .resume-section { padding: 0 0 26px; }
        .resume-section:last-child { padding-bottom: 0; }
        .resume-section-title { display: flex; align-items: center; gap: 10px; margin: 0 0 14px; padding-bottom: 9px; border-bottom: 1px solid #edf0ed; font: 700 15px var(--resume-heading); }
        .resume-section-title i { color: var(--resume-green); font-size: 15px; }
        .resume-timeline { position: relative; display: grid; gap: 11px; padding-left: 19px; }
        .resume-timeline::before { position: absolute; top: 7px; bottom: 7px; left: 4px; width: 2px; background: var(--resume-line); content: ''; }
        .resume-entry { position: relative; padding: 13px 15px; border: 1px solid var(--resume-line); border-radius: 7px; background: #fff; overflow-wrap: anywhere; }
        .resume-entry::before { position: absolute; top: 17px; left: -19px; width: 10px; height: 10px; border: 2px solid var(--resume-green); border-radius: 50%; background: #fff; content: ''; }
        .resume-entry-title { margin: 0; font: 600 14px var(--resume-heading); }
        .resume-entry-subtitle { color: var(--resume-muted); font: 400 12px var(--resume-body); }
        .resume-entry-meta { margin-top: 5px; color: var(--resume-green-dark); font-size: 11px; font-weight: 600; }
        .resume-entry-meta i { margin-right: 5px; }
        .resume-entry-detail { margin-top: 6px; color: #454d47; font-size: 13px; }
        .resume-file-link { display: inline-flex; max-width: 100%; align-items: center; gap: 7px; margin-top: 9px; padding: 6px 10px; border: 1px solid #cfe8d9; border-radius: 6px; color: var(--resume-green-dark); background: #f2f9f4; font-size: 11px; font-weight: 600; text-decoration: none; overflow-wrap: anywhere; }
        .resume-file-link:hover { color: #fff; background: var(--resume-green); }
        .resume-empty { margin: 0; padding: 12px 14px; border: 1px dashed #dce5de; border-radius: 7px; color: var(--resume-muted); background: #fbfcfb; font-size: 13px; }
        .resume-summary { margin-bottom: 14px; padding: 15px 17px; border: 1px solid #e5ece7; border-radius: 7px; background: #f8faf8; }
        .resume-summary strong { display: block; margin-bottom: 6px; color: var(--resume-green-dark); font: 600 11px var(--resume-heading); letter-spacing: .04em; text-transform: uppercase; }
        .resume-summary p { margin: 0; font-size: 13px; line-height: 1.7; white-space: pre-line; }
        .resume-jobs { display: grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap: 12px; }
        .resume-job { padding: 14px; border: 1px solid var(--resume-line); border-radius: 7px; background: #fff; }
        .resume-job-rank { display: inline-flex; align-items: center; gap: 6px; margin-bottom: 8px; padding: 4px 8px; border: 1px solid #f0dfad; border-radius: 999px; color: #806000; background: #fff8e5; font-size: 10px; font-weight: 700; }
        .resume-job-sector { color: var(--resume-muted); font-size: 11px; }
        .resume-job-title { margin-top: 3px; font: 600 14px var(--resume-heading); }
        .resume-admin-footer { display: flex; justify-content: center; padding: 0 16px 28px; color: #7a837d; font-size: 11px; }
        @media (max-width: 800px) { .resume-quick-grid { grid-template-columns: repeat(2, minmax(0,1fr)); } }
        @media (max-width: 600px) { .resume-admin-bar { align-items: flex-start; padding: 10px 14px; } .resume-admin-context small { display: none; } .resume-admin-actions { gap: 6px; } .resume-action { min-height: 36px; padding: 0 9px; font-size: 11px; } .resume-action span { display: none; } main.resume-wrap { width: min(100% - 20px, 1080px); margin: 14px auto 32px; } .resume-inner { padding: 19px 16px; } .resume-profile-head { align-items: flex-start; flex-direction: column; } .resume-identity { gap: 12px; } .resume-avatar { width: 76px; height: 76px; flex-basis: 76px; } .resume-name { font-size: 18px; } .resume-quick-grid { gap: 8px; } .resume-quick-item { align-items: flex-start; flex-direction: column; gap: 6px; padding: 10px; } .resume-jobs { grid-template-columns: 1fr; } }
        @media print { body { background: #fff; } .resume-admin-bar, .resume-user-header, .resume-user-footer, .resume-print-hidden { display: none !important; } main.resume-wrap { width: 100%; max-width: none; margin: 0; padding: 0; } .resume-card { border: 0; border-radius: 0; box-shadow: none; } .resume-inner { padding: 18px 22px; } .resume-entry, .resume-job, .resume-quick-item { break-inside: avoid; } .resume-section { break-inside: avoid-page; } a { color: inherit; text-decoration: none; } }
    </style>
</head>
<body>
    @if($isAdminPreview)
        <header class="resume-admin-bar resume-print-hidden">
            <div class="resume-admin-context">
                <span class="resume-admin-mark"><i class="fas fa-user-check" aria-hidden="true"></i></span>
                <div><strong>Consultation du profil</strong><small>Vue administrateur · {{ $candidateName }}</small></div>
            </div>
            <nav class="resume-admin-actions" aria-label="Actions administrateur">
                <a class="resume-action" href="{{ route('liste.utilisateurs') }}"><i class="fas fa-arrow-left" aria-hidden="true"></i><span>Retour aux candidats</span></a>
                <a class="resume-action" href="{{ route('admin.edit', $utilisateur->id) }}"><i class="fas fa-pen" aria-hidden="true"></i><span>Modifier le dossier</span></a>
            </nav>
        </header>
    @else
        <div class="resume-user-header">@include('partials.user-header')</div>
    @endif

    <main class="resume-wrap">
        <article class="resume-card">
            <div class="resume-accent" aria-hidden="true"></div>
            <div class="resume-inner">
                <header class="resume-profile-head">
                    <div class="resume-identity">
                        <img class="resume-avatar" src="{{ asset($userdata?->photo_profil ?: 'images/images.png') }}" alt="Photo de {{ $candidateName }}">
                        <div>
                            <h1 class="resume-name">{{ $candidateName }}</h1>
                            <div class="resume-registration"><i class="fas fa-id-card" aria-hidden="true"></i><span>N° candidat</span><strong>{{ $utilisateur->id }}</strong></div>
                            @if($userdata?->specialite)<div class="resume-head-label"><i class="fas fa-certificate" aria-hidden="true"></i>{{ $userdata->specialite }}</div>@endif
                        </div>
                    </div>
                    @if(!$isAdminPreview)
                        <a class="resume-action resume-print-hidden" href="{{ $userdata ? route('userdata.summary', $userdata->id) : route('home') }}"><i class="fas fa-arrow-left" aria-hidden="true"></i><span>Retour à mon profil</span></a>
                    @endif
                </header>

                @if($userdata)
                    <section class="resume-quick-grid" aria-label="Informations principales">
                        <div class="resume-quick-item"><span class="resume-quick-icon"><i class="fas fa-calendar-alt" aria-hidden="true"></i></span><div><div class="resume-quick-label">Date de naissance</div><div class="resume-quick-value">{{ $userdata->datenaiss ? \Illuminate\Support\Carbon::parse($userdata->datenaiss)->format('d/m/Y') : 'Non renseignée' }}</div></div></div>
                        <div class="resume-quick-item"><span class="resume-quick-icon"><i class="fas fa-envelope" aria-hidden="true"></i></span><div><div class="resume-quick-label">Adresse e-mail</div><div class="resume-quick-value">{{ $utilisateur->email ?: 'Non renseignée' }}</div></div></div>
                        <div class="resume-quick-item"><span class="resume-quick-icon"><i class="fas fa-phone" aria-hidden="true"></i></span><div><div class="resume-quick-label">Téléphone</div><div class="resume-quick-value">{{ $userdata->telephone1 ?: 'Non renseigné' }}</div></div></div>
                        <div class="resume-quick-item"><span class="resume-quick-icon"><i class="fas fa-location-dot" aria-hidden="true"></i></span><div><div class="resume-quick-label">Résidence</div><div class="resume-quick-value">{{ $userdata->lieuresidence ?: 'Non renseignée' }}</div></div></div>
                    </section>

                    <section class="resume-section">
                        <h2 class="resume-section-title"><i class="fas fa-graduation-cap" aria-hidden="true"></i>Formations et diplômes</h2>
                        @if(count($formationsList) || $userdata->academic_id || $userdata->diplome)
                            <div class="resume-timeline">
                                @forelse($formationsList as $formation)
                                    @php
                                        $academicId = $formation['academic_id'] ?? null;
                                        $formationName = in_array((string) $academicId, ['sansdiplome', '14', '20'], true) ? 'Sans diplôme' : ($academicMap[$academicId] ?? ($userdata->academic->libelle ?? 'Formation'));
                                        $formationFile = $formation['diplome_file'] ?? null;
                                    @endphp
                                    <article class="resume-entry">
                                        <h3 class="resume-entry-title">{{ $formationName }}@if(!empty($formation['etablissementdiplome'])) <span class="resume-entry-subtitle">· {{ $formation['etablissementdiplome'] }}</span>@endif</h3>
                                        @if(!empty($formation['anneediplome']))<div class="resume-entry-meta"><i class="far fa-calendar-check" aria-hidden="true"></i>{{ $formation['anneediplome'] }}</div>@endif
                                        @if(!empty($formation['diplome']))<div class="resume-entry-detail"><strong>Intitulé :</strong> {{ $formation['diplome'] }}</div>@endif
                                        @if(!empty($formation['specialite']))<div class="resume-entry-detail"><strong>Spécialité :</strong> {{ $formation['specialite'] }}</div>@endif
                                        @if($formationFile)<a class="resume-file-link" href="{{ asset($formationFile) }}" target="_blank" rel="noopener"><i class="fas fa-file-pdf" aria-hidden="true"></i>{{ basename($formationFile) }}</a>@endif
                                    </article>
                                @empty
                                    <article class="resume-entry">
                                        <h3 class="resume-entry-title">{{ $userdata->academic->libelle ?? 'Formation renseignée' }}</h3>
                                        @if($userdata->etablissementdiplome)<div class="resume-entry-detail">{{ $userdata->etablissementdiplome }}</div>@endif
                                        @if($userdata->anneediplome)<div class="resume-entry-meta"><i class="far fa-calendar-check" aria-hidden="true"></i>{{ $userdata->anneediplome }}</div>@endif
                                        @if($userdata->diplome)<div class="resume-entry-detail"><strong>Intitulé :</strong> {{ $userdata->diplome }}</div>@endif
                                        @if($userdata->specialite)<div class="resume-entry-detail"><strong>Spécialité :</strong> {{ $userdata->specialite }}</div>@endif
                                    </article>
                                @endforelse
                            </div>
                        @else
                            <p class="resume-empty">Aucune formation renseignée.</p>
                        @endif
                        @if(count($diplomaFiles))
                            <div class="resume-file-list">@foreach($diplomaFiles as $file)<a class="resume-file-link" href="{{ asset($file) }}" target="_blank" rel="noopener"><i class="fas fa-file-pdf" aria-hidden="true"></i>{{ basename($file) }}</a>@endforeach</div>
                        @endif
                    </section>

                    <section class="resume-section">
                        <h2 class="resume-section-title"><i class="fas fa-briefcase" aria-hidden="true"></i>Expérience professionnelle</h2>
                        @if(count($experiencesList) || $userdata->posteoccupe || $userdata->employeur || $userdata->nombreanneeexpe)
                            <div class="resume-timeline">
                                @forelse($experiencesList as $experience)
                                    <article class="resume-entry">
                                        <h3 class="resume-entry-title">{{ $experience['poste'] ?? $userdata->posteoccupe ?? 'Expérience professionnelle' }}@if(!empty($experience['employeur'])) <span class="resume-entry-subtitle">· {{ $experience['employeur'] }}</span>@endif</h3>
                                        @if(!empty($experience['years']))<div class="resume-entry-meta"><i class="far fa-clock" aria-hidden="true"></i>{{ $experience['years'] }} année(s) d’expérience</div>@endif
                                        @if(!empty($experience['description']))<div class="resume-entry-detail">{{ $experience['description'] }}</div>@endif
                                    </article>
                                @empty
                                    <article class="resume-entry">
                                        <h3 class="resume-entry-title">{{ $userdata->posteoccupe ?: 'Expérience professionnelle' }}@if($userdata->employeur) <span class="resume-entry-subtitle">· {{ $userdata->employeur }}</span>@endif</h3>
                                        @if($userdata->nombreanneeexpe)<div class="resume-entry-meta"><i class="far fa-clock" aria-hidden="true"></i>{{ $userdata->nombreanneeexpe }} année(s) d’expérience</div>@endif
                                    </article>
                                @endforelse
                            </div>
                        @else
                            <p class="resume-empty">Aucune expérience professionnelle renseignée.</p>
                        @endif
                    </section>

                    <section class="resume-section">
                        @php $summaryText = $userdata->cv_summary ?: $userdata->motivation; @endphp
                        @if($summaryText)<div class="resume-summary"><strong><i class="fas fa-align-left" aria-hidden="true"></i> {{ $userdata->cv_summary ? 'Résumé du profil' : 'Lettre de motivation / Profil' }}</strong><p style="white-space: pre-line;">{{ $summaryText }}</p></div>@endif
                        <div class="resume-jobs">
                            <article class="resume-job"><span class="resume-job-rank"><i class="fas fa-star" aria-hidden="true"></i> 1er choix</span><div class="resume-job-sector">{{ $userdata->emploi1?->secteur?->libelle ?? 'Secteur non renseigné' }}</div><div class="resume-job-title">{{ $userdata->emploi1?->libelle ?? 'Métier non renseigné' }}</div></article>
                            <article class="resume-job"><span class="resume-job-rank"><i class="fas fa-star-half-stroke" aria-hidden="true"></i> 2e choix</span><div class="resume-job-sector">{{ $userdata->emploi2?->secteur?->libelle ?? 'Secteur non renseigné' }}</div><div class="resume-job-title">{{ $userdata->emploi2?->libelle ?? 'Métier non renseigné' }}</div></article>
                        </div>
                        @if(count($cvFiles))
                            <div class="resume-file-list">@foreach($cvFiles as $file)<a class="resume-file-link" href="{{ asset($file) }}" target="_blank" rel="noopener"><i class="fas fa-file-pdf" aria-hidden="true"></i>{{ basename($file) }}</a>@endforeach</div>
                        @endif
                    </section>
                @else
                    <p class="resume-empty">Ce compte ne possède pas encore de dossier candidat.</p>
                @endif
            </div>
        </article>
    </main>

    @if($isAdminPreview)
        <footer class="resume-admin-footer">Consultation du dossier candidat dans l’espace administration PGDE</footer>
    @else
        <div class="resume-user-footer">@include('partials.user-footer')</div>
    @endif
</body>
</html>
