<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon dossier — Plateforme de Gestion des Demandes d'Emploi</title>
    <link rel="icon" href="{{ asset('images/mfp.png') }}?v=2" type="image/x-icon">

    <!-- Polices de la charte : Poppins & DM Sans + FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --color-primary: #008C45;
            --color-primary-dark: #006B35;
            --color-primary-light: #EBF7F0;
            --color-warning: #B45309;
            --color-warning-light: #FEF6E7;
            --color-danger: #B91C1C;
            --color-danger-light: #FDEDED;
            --color-text: #1D1D1B;
            --color-text-secondary: #575A7B;
            --color-muted: #6B7A71;
            --color-border: #E5E8E6;
            --color-bg: #F2F3F5;
            --font-heading: 'Poppins', sans-serif;
            --font-body: 'DM Sans', sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--color-bg);
            color: var(--color-text);
            font-family: var(--font-body);
            font-size: 14.5px;
            line-height: 1.55;
            -webkit-font-smoothing: antialiased;
        }

        .dossier {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 16px;
            width: 100%;
            max-width: 1040px;
            margin: 0 auto;
            padding: 24px clamp(12px, 2vw, 20px) 48px;
        }

        .panel {
            background: #ffffff;
            border: 1px solid var(--color-border);
            border-radius: 14px;
            box-shadow: 0 1px 2px rgba(20, 30, 24, .03), 0 8px 24px rgba(20, 30, 24, .04);
        }

        /* Boutons : mêmes que la connexion (vert plein / gris) */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 40px;
            padding: 0 16px;
            border: 0;
            border-radius: 10px;
            font-family: var(--font-heading);
            font-size: 13.5px;
            font-weight: 600;
            white-space: nowrap;
            text-decoration: none;
            cursor: pointer;
            transition: background .2s ease, box-shadow .2s ease, transform .12s ease;
        }

        .btn:active { transform: translateY(1px); }
        .btn:focus-visible, .edit-link:focus-visible, .missing-item a:focus-visible { outline: 3px solid rgba(0, 140, 69, .35); outline-offset: 2px; }

        .btn-primary {
            background: linear-gradient(180deg, #009A4C 0%, var(--color-primary) 100%);
            color: #ffffff;
            box-shadow: 0 1px 0 rgba(255, 255, 255, .2) inset, 0 6px 16px rgba(0, 140, 69, .22);
        }

        .btn-primary:hover { background: linear-gradient(180deg, var(--color-primary) 0%, var(--color-primary-dark) 100%); color: #ffffff; }
        .btn-secondary { background: #5b6b62; color: #ffffff; }
        .btn-secondary:hover { background: #46534b; }

        /* =====================================================================
           1. IDENTITÉ
           ===================================================================== */
        .identity {
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto;
            align-items: center;
            gap: 20px;
            padding: 22px 24px;
        }

        /* Photo en avatar rond */
        .identity-photo {
            width: 84px;
            height: 84px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ffffff;
            box-shadow: 0 0 0 1px var(--color-border), 0 4px 12px rgba(20, 30, 24, .08);
            background: #F2F4F3;
        }

        .identity h1 {
            margin: 0 0 4px;
            font-family: var(--font-heading);
            font-size: clamp(20px, 2.2vw, 24px);
            font-weight: 700;
            line-height: 1.25;
        }

        .identity-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 4px 16px;
            margin: 0;
            padding: 0;
            list-style: none;
            color: var(--color-text-secondary);
            font-size: 13.5px;
        }

        .identity-meta li { display: inline-flex; align-items: center; gap: 6px; }
        .identity-meta i { color: var(--color-primary); font-size: 12px; }
        .identity-meta strong { color: var(--color-text); font-weight: 600; }

        .identity-actions { display: flex; gap: 8px; }

        /* =====================================================================
           2. ÉTAT DU DOSSIER
           ===================================================================== */
        .status {
            display: grid;
            grid-template-columns: auto minmax(0, 1fr);
            gap: 22px;
            align-items: center;
            padding: 20px 24px;
        }

        /* Anneau de progression */
        .ring {
            --percent: 0;
            position: relative;
            display: grid;
            place-items: center;
            width: 92px;
            height: 92px;
            border-radius: 50%;
            background: conic-gradient(var(--ring-color, var(--color-primary)) calc(var(--percent) * 1%), #E8EEEA 0);
        }

        .ring::before {
            content: "";
            position: absolute;
            inset: 9px;
            border-radius: 50%;
            background: #ffffff;
        }

        .ring span {
            position: relative;
            font-family: var(--font-heading);
            font-size: 20px;
            font-weight: 700;
            font-variant-numeric: tabular-nums;
        }

        .status.is-incomplete .ring { --ring-color: #D97706; }

        .status h2 {
            margin: 0 0 4px;
            font-family: var(--font-heading);
            font-size: 16px;
            font-weight: 600;
        }

        .status p { margin: 0; color: var(--color-text-secondary); font-size: 13.5px; }

        .missing-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 12px 0 0;
            padding: 0;
            list-style: none;
        }

        .missing-item a {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            transition: filter .15s ease;
        }

        .missing-item a:hover { filter: brightness(.96); }
        .missing-item.is-required a { background: var(--color-danger-light); color: var(--color-danger); }
        .missing-item.is-optional a { background: var(--color-warning-light); color: var(--color-warning); }
        .missing-item .fa-arrow-right { font-size: 10.5px; opacity: .7; }

        .status-ok { color: var(--color-primary-dark) !important; font-weight: 600; }

        /* =====================================================================
           3. SECTIONS DU DOSSIER
           ===================================================================== */
        .sections {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .section { display: flex; flex-direction: column; min-width: 0; }
        .section.is-wide { grid-column: 1 / -1; }

        .section-head {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
            border-bottom: 1px solid var(--color-border);
        }

        .section-head .tile {
            display: grid;
            place-items: center;
            width: 34px;
            height: 34px;
            flex-shrink: 0;
            border-radius: 10px;
            background: var(--color-primary-light);
            color: var(--color-primary);
            font-size: 14px;
        }

        .section-head h2 {
            flex: 1;
            margin: 0;
            font-family: var(--font-heading);
            font-size: 15px;
            font-weight: 600;
        }

        .section-head .count {
            margin-left: 6px;
            color: var(--color-muted);
            font-family: var(--font-body);
            font-size: 13px;
            font-weight: 500;
        }

        .edit-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 8px;
            color: var(--color-primary-dark);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: background .15s ease;
        }

        .edit-link:hover { background: var(--color-primary-light); }

        .section-body { padding: 16px 20px 20px; }

        /* Grille libellé / valeur */
        .facts {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px 24px;
            margin: 0;
        }

        .fact dt {
            display: flex;
            align-items: center;
            gap: 7px;
            margin: 0 0 2px;
            color: var(--color-muted);
            font-size: 12px;
            font-weight: 600;
        }

        .fact dt i { width: 14px; color: var(--color-primary); font-size: 12px; text-align: center; }

        .fact dd {
            margin: 0;
            color: var(--color-text);
            font-size: 14px;
            font-weight: 500;
            overflow-wrap: anywhere;
        }

        .fact dd.is-empty { color: #9AA5A0; font-weight: 400; font-style: italic; }

        /* Listes (formations, expériences) : titre + badge, puis champs libellés */
        .entries { display: flex; flex-direction: column; gap: 12px; margin: 0; padding: 0; list-style: none; }

        .entry {
            padding: 14px 16px;
            border: 1px solid var(--color-border);
            border-radius: 12px;
            background: #FCFDFC;
        }

        .entry-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .entry h3 {
            margin: 0;
            font-family: var(--font-heading);
            font-size: 14.5px;
            font-weight: 600;
            line-height: 1.35;
            overflow-wrap: anywhere;
        }

        .entry .badge {
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 2px 9px;
            border-radius: 999px;
            background: var(--color-primary-light);
            color: var(--color-primary-dark);
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            font-variant-numeric: tabular-nums;
        }

        .entry-facts {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px 16px;
            margin: 10px 0 0;
        }

        .entry-facts .is-full { grid-column: 1 / -1; }

        .entry-facts dt {
            display: flex;
            align-items: center;
            gap: 6px;
            margin: 0;
            color: var(--color-muted);
            font-size: 11.5px;
            font-weight: 600;
        }

        .entry-facts dt i { width: 13px; color: var(--color-primary); font-size: 11px; text-align: center; }

        .entry-facts dd {
            margin: 1px 0 0;
            color: var(--color-text);
            font-size: 13.5px;
            overflow-wrap: anywhere;
        }

        /* Missions : 3 lignes affichées, le reste avec « Voir plus » */
        .entry-facts dd.is-clamped {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .read-more {
            margin-top: 2px;
            padding: 0;
            border: 0;
            background: none;
            color: var(--color-primary-dark);
            font: 600 12.5px var(--font-body);
            cursor: pointer;
        }

        .read-more:hover { text-decoration: underline; }

        .entry .file {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 10px;
            color: var(--color-primary-dark);
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
        }

        .entry .file:hover { text-decoration: underline; }
        .entry .file i { color: #C2410C; }

        .empty { margin: 0; color: var(--color-muted); font-size: 13.5px; }

        /* Emplois visés */
        .jobs { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }

        .job {
            display: grid;
            grid-template-columns: 32px minmax(0, 1fr);
            gap: 12px;
            align-items: center;
            padding: 12px;
            border: 1px solid var(--color-border);
            border-radius: 12px;
        }

        .job .rank {
            display: grid;
            place-items: center;
            width: 32px;
            height: 32px;
            border-radius: 9px;
            background: var(--color-primary);
            color: #ffffff;
            font-family: var(--font-heading);
            font-size: 13.5px;
            font-weight: 700;
        }

        .job:nth-child(2) .rank { background: var(--color-primary-light); color: var(--color-primary); }
        .job strong { display: block; font-family: var(--font-heading); font-size: 13.5px; font-weight: 600; line-height: 1.3; }
        .job span { color: var(--color-muted); font-size: 12px; }

        .profile-summary {
            margin: 14px 0 0;
            padding: 12px 14px;
            border-radius: 10px;
            background: #F7F9F8;
            color: var(--color-text);
            font-size: 14px;
            line-height: 1.65;
        }

        .profile-summary span {
            display: block;
            margin-bottom: 2px;
            color: var(--color-muted);
            font-size: 12px;
            font-weight: 600;
        }

        /* =====================================================================
           RESPONSIVE
           ===================================================================== */
        @media (max-width: 860px) {
            .identity { grid-template-columns: auto minmax(0, 1fr); }
            .identity-actions { grid-column: 1 / -1; }
            .sections { grid-template-columns: minmax(0, 1fr); }
            .facts { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 560px) {
            .dossier { padding: 12px 10px 32px; gap: 12px; }
            .identity { gap: 14px; padding: 16px; }
            .identity-photo { width: 64px; height: 64px; }
            .identity-actions { flex-direction: column; }
            .identity-actions .btn { width: 100%; }
            .status { grid-template-columns: minmax(0, 1fr); justify-items: center; text-align: center; padding: 18px 16px; }
            .missing-list { justify-content: center; }
            .section-head, .section-body { padding-left: 16px; padding-right: 16px; }
            .facts, .jobs, .entry-facts { grid-template-columns: minmax(0, 1fr); }
            .edit-link span { display: none; }
        }

        /* Impression : le dossier seul, sans header, footer, état ni boutons */
        @media print {
            body { background: #ffffff; }
            .site-header, .pgde-user-footer, .identity-actions, .status, .edit-link { display: none !important; }
            .dossier { max-width: none; padding: 0; }
            .panel { box-shadow: none; break-inside: avoid; }
            .job .rank, .section-head .tile { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }

        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; }
        }
    </style>
</head>
<body>
    @include('partials.user-header')

    @php
        $candidate = $userdata->utilisateur;
        $fullName = trim(($candidate->firstname ?? '') . ' ' . ($candidate->lastname ?? ''));
        $editUrl = fn (int $step): string => route('userdata.edit', ['id' => $userdata->id, 'etape' => $step]);

        // Formations (JSON) avec repli sur l'ancienne formation unique
        $formationsList = [];
        if (!empty($userdata->autresdiplomes)) {
            $decodedFormations = is_array($userdata->autresdiplomes)
                ? $userdata->autresdiplomes
                : json_decode($userdata->autresdiplomes, true);
            if (is_array($decodedFormations)) {
                $formationsList = array_values(array_filter($decodedFormations, 'is_array'));
            }
        }
        if (empty($formationsList) && (!empty($userdata->academic_id) || !empty($userdata->diplome))) {
            $formationsList[] = [
                'academic_id' => $userdata->academic_id,
                'etablissementdiplome' => $userdata->etablissementdiplome,
                'anneediplome' => $userdata->anneediplome,
                'diplome' => $userdata->diplome,
                'specialite' => $userdata->specialite,
            ];
        }
        $academicLabels = \App\Models\Academic::pluck('libelle', 'id')->toArray();

        // Expériences (JSON) avec repli sur l'ancienne expérience unique
        $experiencesList = [];
        if (!empty($userdata->experiences)) {
            $decodedExperiences = is_array($userdata->experiences)
                ? $userdata->experiences
                : json_decode($userdata->experiences, true);
            if (is_array($decodedExperiences)) {
                $experiencesList = array_values(array_filter($decodedExperiences, 'is_array'));
            } elseif (is_string($userdata->experiences) && trim($userdata->experiences) !== '') {
                $experiencesList = [[
                    'poste' => $userdata->posteoccupe ?: 'Expérience professionnelle',
                    'employeur' => $userdata->employeur ?: '',
                    'years' => $userdata->anneeexperience1 ?: $userdata->nombreanneeexpe ?: null,
                    'description' => $userdata->experiences,
                ]];
            }
        }
        if (empty($experiencesList) && (!empty($userdata->posteoccupe) || !empty($userdata->employeur))) {
            $experiencesList[] = [
                'poste' => $userdata->posteoccupe,
                'employeur' => $userdata->employeur,
                'years' => $userdata->nombreanneeexpe,
            ];
        }

        $completeness = \App\Support\DossierCompleteness::evaluate($userdata, $formationsList);
        $isComplete = empty($completeness['missing']);

        $residenceParts = array_filter([
            $userdata->departementResidence->libelle ?? null,
            $userdata->regionResidence->libelle ?? null,
            $userdata->pays->name ?? null,
        ]);
        $residence = $residenceParts ? implode(', ', $residenceParts) : $userdata->lieuresidence;
        $birthPlace = implode(', ', array_filter([$userdata->lieunaiss, $userdata->regionNaissance->libelle ?? null]));
        $genderLabel = match ($userdata->genre) {
            'Masculin' => 'Homme',
            'Feminin' => 'Femme',
            default => null,
        };
        $familyLabel = $userdata->situationmatrimoniale
            ? $userdata->situationmatrimoniale . (is_null($userdata->nombreenfant) ? '' : ' · ' . $userdata->nombreenfant . ' enfant' . ($userdata->nombreenfant > 1 ? 's' : ''))
            : null;

        // Section Identité : [icône, libellé, valeur]
        $identityFacts = [
            ['fa-envelope', 'E-mail', $candidate->email ?? null],
            ['fa-phone', 'Téléphone', implode(' · ', array_filter([$userdata->telephone1, $userdata->telephone2]))],
            ['fa-location-dot', 'Résidence', implode(', ', array_filter([$residence, $userdata->addresse]))],
            ['fa-cake-candles', 'Date de naissance', $userdata->datenaiss],
            ['fa-map-pin', 'Lieu de naissance', $birthPlace],
            ['fa-venus-mars', 'Genre', $genderLabel],
            ['fa-heart', 'Situation familiale', $familyLabel],
            ['fa-id-card', 'CNI ou passeport', $candidate->numberid ?? null],
            ['fa-wheelchair', 'Handicap', $userdata->handicap->libelle ?? 'Aucun'],
        ];
    @endphp

    <main class="dossier">

        <!-- 1. Identité et actions -->
        <section class="panel identity" aria-labelledby="dossier-name">
            <img class="identity-photo" src="{{ asset($userdata->photo_profil ?: 'images/images.png') }}" alt="Photo de {{ $fullName }}">
            <div>
                <h1 id="dossier-name">{{ $fullName ?: 'Mon dossier' }}</h1>
                <ul class="identity-meta">
                    <li><i class="fas fa-hashtag" aria-hidden="true"></i> N° d'inscription <strong>{{ $candidate->id }}</strong></li>
                    @if ($userdata->emploi1)
                        <li><i class="fas fa-bullseye" aria-hidden="true"></i> Vise <strong>{{ $userdata->emploi1->libelle }}</strong></li>
                    @endif
                </ul>
            </div>
            <div class="identity-actions">
                <a href="{{ route('userdata.edit', ['id' => $userdata->id]) }}" class="btn btn-primary">
                    <i class="fas fa-pen-to-square" aria-hidden="true"></i> Modifier mon dossier
                </a>
                <button type="button" class="btn btn-secondary" onclick="window.print()">
                    <i class="fas fa-print" aria-hidden="true"></i> Imprimer
                </button>
            </div>
        </section>

        <!-- 2. État du dossier : complétude et éléments à compléter -->
        <section class="panel status {{ $isComplete ? 'is-complete' : 'is-incomplete' }}" aria-labelledby="dossier-status">
            <div class="ring" style="--percent: {{ $completeness['percent'] }}" role="img" aria-label="Dossier complété à {{ $completeness['percent'] }} %">
                <span>{{ $completeness['percent'] }}%</span>
            </div>
            <div>
                <h2 id="dossier-status">{{ $isComplete ? 'Votre dossier est complet' : 'Complétez votre dossier' }}</h2>
                @if ($isComplete)
                    <p class="status-ok"><i class="fas fa-circle-check" aria-hidden="true"></i> Toutes les informations attendues sont renseignées. Vous pouvez les mettre à jour à tout moment.</p>
                @else
                    <p>Un dossier complet est plus facile à étudier. Cliquez sur un élément pour le compléter.</p>
                    <ul class="missing-list">
                        @foreach ($completeness['missing'] as $missingItem)
                            <li class="missing-item {{ $missingItem['required'] ? 'is-required' : 'is-optional' }}">
                                <a href="{{ $editUrl($missingItem['step']) }}">
                                    <i class="fas {{ $missingItem['required'] ? 'fa-circle-exclamation' : 'fa-circle-plus' }}" aria-hidden="true"></i>
                                    {{ $missingItem['label'] }}
                                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </section>

        <!-- 3. Sections du dossier, chacune modifiable directement -->
        <div class="sections">

            <section class="panel section is-wide" aria-labelledby="section-identity">
                <header class="section-head">
                    <span class="tile" aria-hidden="true"><i class="fas fa-user"></i></span>
                    <h2 id="section-identity">Identité et coordonnées</h2>
                    <a class="edit-link" href="{{ $editUrl(1) }}" aria-label="Modifier l'identité et les coordonnées"><i class="fas fa-pen" aria-hidden="true"></i><span>Modifier</span></a>
                </header>
                <div class="section-body">
                    <dl class="facts">
                        @foreach ($identityFacts as [$icon, $label, $value])
                            <div class="fact">
                                <dt><i class="fas {{ $icon }}" aria-hidden="true"></i>{{ $label }}</dt>
                                <dd class="{{ filled($value) ? '' : 'is-empty' }}">{{ filled($value) ? $value : 'Non renseigné' }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            </section>

            <section class="panel section" aria-labelledby="section-education">
                <header class="section-head">
                    <span class="tile" aria-hidden="true"><i class="fas fa-graduation-cap"></i></span>
                    <h2 id="section-education">Formations<span class="count">({{ count($formationsList) }})</span></h2>
                    <a class="edit-link" href="{{ $editUrl(2) }}" aria-label="Modifier les formations"><i class="fas fa-pen" aria-hidden="true"></i><span>Modifier</span></a>
                </header>
                <div class="section-body">
                    @if (!empty($formationsList))
                        <ul class="entries">
                            @foreach ($formationsList as $formation)
                                @php
                                    $academicId = $formation['academic_id'] ?? null;
                                    $levelLabel = in_array($academicId, ['sansdiplome', '20'], true)
                                        ? 'Sans diplôme'
                                        : ($academicLabels[$academicId] ?? 'Niveau non renseigné');
                                    $diplomaFile = $formation['diplome_file'] ?? null;
                                @endphp
                                <li class="entry">
                                    <div class="entry-head">
                                        <h3>{{ ($formation['diplome'] ?? null) ?: $levelLabel }}</h3>
                                        @if (!empty($formation['anneediplome']))
                                            <span class="badge"><i class="far fa-calendar" aria-hidden="true"></i> {{ $formation['anneediplome'] }}</span>
                                        @endif
                                    </div>
                                    <dl class="entry-facts">
                                        <div>
                                            <dt><i class="fas fa-layer-group" aria-hidden="true"></i> Niveau</dt>
                                            <dd>{{ $levelLabel }}</dd>
                                        </div>
                                        @if (!empty($formation['etablissementdiplome']))
                                            <div>
                                                <dt><i class="fas fa-school" aria-hidden="true"></i> Établissement</dt>
                                                <dd>{{ $formation['etablissementdiplome'] }}</dd>
                                            </div>
                                        @endif
                                        @if (!empty($formation['specialite']))
                                            <div class="is-full">
                                                <dt><i class="fas fa-bookmark" aria-hidden="true"></i> Spécialité</dt>
                                                <dd>{{ $formation['specialite'] }}</dd>
                                            </div>
                                        @endif
                                    </dl>
                                    @if ($diplomaFile)
                                        <a href="{{ asset($diplomaFile) }}" target="_blank" rel="noopener" class="file">
                                            <i class="fas fa-file-pdf" aria-hidden="true"></i> Voir le justificatif
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="empty">Aucune formation renseignée.</p>
                    @endif
                </div>
            </section>

            <section class="panel section" aria-labelledby="section-experience">
                <header class="section-head">
                    <span class="tile" aria-hidden="true"><i class="fas fa-briefcase"></i></span>
                    <h2 id="section-experience">Expériences<span class="count">({{ count($experiencesList) }})</span></h2>
                    <a class="edit-link" href="{{ $editUrl(3) }}" aria-label="Modifier les expériences"><i class="fas fa-pen" aria-hidden="true"></i><span>Modifier</span></a>
                </header>
                <div class="section-body">
                    @if (!empty($experiencesList))
                        <ul class="entries">
                            @foreach ($experiencesList as $experience)
                                <li class="entry">
                                    <div class="entry-head">
                                        <h3>{{ ($experience['poste'] ?? null) ?: ($userdata->posteoccupe ?: 'Expérience professionnelle') }}</h3>
                                        @if (!empty($experience['years']))
                                            <span class="badge"><i class="far fa-clock" aria-hidden="true"></i> {{ $experience['years'] }} an{{ $experience['years'] > 1 ? 's' : '' }}</span>
                                        @endif
                                    </div>
                                    <dl class="entry-facts">
                                        <div class="is-full">
                                            <dt><i class="fas fa-building" aria-hidden="true"></i> Entreprise</dt>
                                            <dd>{{ ($experience['employeur'] ?? null) ?: 'Non renseignée' }}</dd>
                                        </div>
                                        @if (!empty($experience['description']))
                                            <div class="is-full">
                                                <dt><i class="fas fa-list-check" aria-hidden="true"></i> Missions</dt>
                                                <dd class="is-clamped" data-clamp style="white-space: pre-line;">{{ $experience['description'] }}</dd>
                                                <button type="button" class="read-more" hidden>Voir plus</button>
                                            </div>
                                        @endif
                                    </dl>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="empty">Aucune expérience déclarée.</p>
                    @endif
                </div>
            </section>

            <section class="panel section is-wide" aria-labelledby="section-jobs">
                <header class="section-head">
                    <span class="tile" aria-hidden="true"><i class="fas fa-bullseye"></i></span>
                    <h2 id="section-jobs">Emplois visés et profil</h2>
                    <a class="edit-link" href="{{ $editUrl(4) }}" aria-label="Modifier les emplois visés"><i class="fas fa-pen" aria-hidden="true"></i><span>Modifier</span></a>
                </header>
                <div class="section-body">
                    <div class="jobs">
                        @foreach ([$userdata->emploi1, $userdata->emploi2] as $rank => $job)
                            <div class="job">
                                <span class="rank" aria-label="{{ $rank === 0 ? 'Premier' : 'Second' }} choix">{{ $rank + 1 }}</span>
                                <div>
                                    <strong>{{ $job->libelle ?? 'Non renseigné' }}</strong>
                                    <span>{{ $job->secteur->libelle ?? 'Secteur non renseigné' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @php $profileSummary = $userdata->cv_summary ?: $userdata->motivation; @endphp
                    @if (!empty($profileSummary))
                        <p class="profile-summary" style="white-space: pre-line;"><span>{{ !empty($userdata->cv_summary) ? 'Résumé du profil' : 'Lettre de motivation / Profil' }}</span>{{ $profileSummary }}</p>
                    @endif
                </div>
            </section>
        </div>
    </main>

    @include('partials.user-footer')

    <script>
        // « Voir plus » seulement si les missions dépassent 3 lignes
        document.querySelectorAll('[data-clamp]').forEach(text => {
            const button = text.nextElementSibling;
            if (!button || text.scrollHeight <= text.clientHeight + 1) return;
            button.hidden = false;
            button.addEventListener('click', () => {
                const expanded = text.classList.toggle('is-clamped') === false;
                button.textContent = expanded ? 'Voir moins' : 'Voir plus';
            });
        });
    </script>

    <!-- Notification après enregistrement -->
    @if (session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Succès !',
                    text: @json(session('success')),
                    timer: 3000,
                    showConfirmButton: false,
                });
            });
        </script>
    @endif
</body>
</html>
