<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon CV — Plateforme de Gestion des Demandes d'Emploi</title>
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
            --color-primary-deep: #0B3D24;
            --color-primary-light: #EBF7F0;
            --color-yellow: #F7C600;
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

        .cv-wrap {
            flex: 1;
            width: 100%;
            max-width: 1080px;
            margin: 0 auto;
            padding: 24px clamp(12px, 2vw, 20px) 48px;
        }

        .cv {
            overflow: hidden;
            background: #ffffff;
            border: 1px solid var(--color-border);
            border-radius: 18px;
            box-shadow: 0 12px 36px rgba(29, 29, 27, .07);
        }

        /* =====================================================================
           EN-TÊTE : bandeau vert, avatar rond, identité, actions
           ===================================================================== */
        .cv-hero {
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto;
            align-items: center;
            gap: 26px;
            padding: 30px 34px;
            background:
                radial-gradient(110% 150% at 100% 0%, rgba(247, 198, 0, .14) 0%, transparent 45%),
                linear-gradient(135deg, var(--color-primary-deep) 0%, var(--color-primary-dark) 55%, var(--color-primary) 100%);
            color: #ffffff;
        }

        /* Avatar rond avec anneau blanc */
        .cv-avatar {
            width: 124px;
            height: 124px;
            padding: 4px;
            border-radius: 50%;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(255, 255, 255, .18), 0 12px 26px rgba(0, 0, 0, .25);
        }

        .cv-avatar img {
            display: block;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            background: #E8EEEA;
        }

        .cv-identity { min-width: 0; }

        .cv-eyebrow {
            margin: 0 0 4px;
            color: rgba(255, 255, 255, .72);
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .cv-identity h1 {
            margin: 0;
            font-family: var(--font-heading);
            font-size: clamp(22px, 2.6vw, 30px);
            font-weight: 700;
            line-height: 1.2;
            text-wrap: balance;
        }

        .cv-headline {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 6px 0 14px;
            color: rgba(255, 255, 255, .9);
            font-size: 15px;
        }

        .cv-headline i { color: var(--color-yellow); }
        .cv-headline strong { color: #ffffff; font-weight: 600; }

        .cv-chips { display: flex; flex-wrap: wrap; gap: 8px; }

        .cv-chip {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 5px 12px;
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 999px;
            background: rgba(255, 255, 255, .1);
            font-size: 12.5px;
        }

        .cv-chip i { color: var(--color-yellow); font-size: 11.5px; }
        .cv-chip strong { font-weight: 700; letter-spacing: .03em; font-variant-numeric: tabular-nums; }

        .cv-actions { display: flex; flex-direction: column; gap: 10px; }

        .cv-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 42px;
            padding: 0 18px;
            border: 0;
            border-radius: 10px;
            font-family: var(--font-heading);
            font-size: 13.5px;
            font-weight: 600;
            white-space: nowrap;
            text-decoration: none;
            cursor: pointer;
            transition: background .2s ease, transform .12s ease;
        }

        .cv-btn:active { transform: translateY(1px); }
        .cv-btn:focus-visible, .cv-edit:focus-visible { outline: 3px solid rgba(247, 198, 0, .7); outline-offset: 2px; }

        .cv-btn-light { background: #ffffff; color: var(--color-primary-dark); }
        .cv-btn-light:hover { background: var(--color-primary-light); }

        .cv-btn-ghost {
            background: rgba(255, 255, 255, .12);
            color: #ffffff;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .3);
        }

        .cv-btn-ghost:hover { background: rgba(255, 255, 255, .2); }

        /* =====================================================================
           CORPS : colonne latérale + colonne principale
           ===================================================================== */
        .cv-body {
            display: grid;
            grid-template-columns: 310px minmax(0, 1fr);
        }

        .cv-side {
            display: flex;
            flex-direction: column;
            gap: 30px;
            padding: 28px 26px 32px;
            background: #F7F9F8;
            border-right: 1px solid var(--color-border);
        }

        .cv-side-group { display: flex; flex-direction: column; gap: 30px; }

        .cv-main {
            display: flex;
            flex-direction: column;
            gap: 32px;
            min-width: 0;
            padding: 28px 34px 34px;
        }

        /* Titre de section : tuile icône + titre + bouton modifier */
        .cv-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0 0 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--color-border);
        }

        .cv-title .tile {
            display: grid;
            place-items: center;
            width: 32px;
            height: 32px;
            flex-shrink: 0;
            border-radius: 9px;
            background: var(--color-primary-light);
            color: var(--color-primary);
            font-size: 14px;
        }

        .cv-title h2 {
            flex: 1;
            margin: 0;
            font-family: var(--font-heading);
            font-size: 15px;
            font-weight: 600;
        }

        .cv-side .cv-title h2 { font-size: 14px; }

        .cv-title .count { margin-left: 4px; color: var(--color-muted); font-family: var(--font-body); font-size: 13px; font-weight: 500; }

        /* Bouton « modifier » discret, ouvre la bonne étape du formulaire */
        .cv-edit {
            display: grid;
            place-items: center;
            width: 30px;
            height: 30px;
            flex-shrink: 0;
            border-radius: 8px;
            color: var(--color-muted);
            text-decoration: none;
            transition: background .15s ease, color .15s ease;
        }

        .cv-edit:hover { background: var(--color-primary-light); color: var(--color-primary-dark); }

        /* Infos de la colonne latérale */
        .cv-info { display: flex; flex-direction: column; gap: 13px; margin: 0; }

        .cv-info-row {
            display: grid;
            grid-template-columns: 30px minmax(0, 1fr);
            gap: 11px;
            align-items: start;
        }

        .cv-info-row .ic {
            display: grid;
            place-items: center;
            width: 30px;
            height: 30px;
            border: 1px solid var(--color-border);
            border-radius: 8px;
            background: #ffffff;
            color: var(--color-primary);
            font-size: 12.5px;
        }

        .cv-info-row dt {
            margin: 0;
            color: var(--color-muted);
            font-size: 11.5px;
            font-weight: 600;
        }

        .cv-info-row dd {
            margin: 1px 0 0;
            font-size: 13.5px;
            font-weight: 500;
            overflow-wrap: anywhere;
        }

        .cv-info-row dd.is-empty { color: #9AA5A0; font-weight: 400; font-style: italic; }

        /* Emplois visés */
        .cv-jobs { display: flex; flex-direction: column; gap: 10px; }

        .cv-job {
            display: grid;
            grid-template-columns: 34px minmax(0, 1fr);
            gap: 12px;
            align-items: center;
            padding: 12px;
            border: 1px solid var(--color-border);
            border-radius: 12px;
            background: #ffffff;
        }

        .cv-job .rank {
            display: grid;
            place-items: center;
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: linear-gradient(180deg, #009A4C 0%, var(--color-primary) 100%);
            color: #ffffff;
            font-family: var(--font-heading);
            font-size: 14px;
            font-weight: 700;
        }

        .cv-job + .cv-job .rank { background: var(--color-primary-light); color: var(--color-primary); }
        .cv-job strong { display: block; font-family: var(--font-heading); font-size: 13.5px; font-weight: 600; line-height: 1.3; }
        .cv-job span { color: var(--color-muted); font-size: 12px; }

        /* Profil */
        .cv-summary {
            margin: 0;
            padding: 16px 18px;
            border-radius: 12px;
            background: var(--color-primary-light);
            font-size: 14.5px;
            line-height: 1.7;
            white-space: pre-line;
        }

        .cv-summary-label { display: block; margin-bottom: 2px; color: var(--color-primary-dark); font-size: 12px; font-weight: 700; }

        /* Frise des formations et expériences */
        .cv-timeline {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .cv-timeline > li {
            position: relative;
            display: grid;
            grid-template-columns: 40px minmax(0, 1fr);
            gap: 14px;
        }

        .cv-timeline > li:not(:last-child)::before {
            content: "";
            position: absolute;
            top: 46px;
            bottom: -12px;
            left: 19px;
            width: 2px;
            border-radius: 2px;
            background: #DCEDE3;
        }

        .cv-timeline .dot {
            display: grid;
            place-items: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--color-primary-light);
            color: var(--color-primary);
            font-size: 15px;
            box-shadow: 0 0 0 4px #ffffff;
        }

        .cv-entry {
            min-width: 0;
            padding: 14px 16px;
            border: 1px solid var(--color-border);
            border-radius: 12px;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .cv-entry:hover { border-color: #cfd6d1; box-shadow: 0 6px 16px rgba(20, 30, 24, .06); }

        .cv-entry-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .cv-entry h3 {
            margin: 0;
            font-family: var(--font-heading);
            font-size: 15px;
            font-weight: 600;
            line-height: 1.35;
            overflow-wrap: anywhere;
        }

        .cv-badge {
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 2px 10px;
            border-radius: 999px;
            background: var(--color-primary-light);
            color: var(--color-primary-dark);
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            font-variant-numeric: tabular-nums;
        }

        /* Champs libellés d'une formation ou d'une expérience */
        .cv-facts {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px 18px;
            margin: 10px 0 0;
        }

        .cv-facts .is-full { grid-column: 1 / -1; }

        .cv-facts dt {
            display: flex;
            align-items: center;
            gap: 6px;
            margin: 0;
            color: var(--color-muted);
            font-size: 11.5px;
            font-weight: 600;
        }

        .cv-facts dt i { width: 13px; color: var(--color-primary); font-size: 11px; text-align: center; }

        .cv-facts dd {
            margin: 1px 0 0;
            font-size: 13.5px;
            overflow-wrap: anywhere;
        }

        /* Missions : 3 lignes, le reste avec « Voir plus » */
        .cv-facts dd.is-clamped {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .cv-more {
            margin-top: 2px;
            padding: 0;
            border: 0;
            background: none;
            color: var(--color-primary-dark);
            font: 600 12.5px var(--font-body);
            cursor: pointer;
        }

        .cv-more:hover { text-decoration: underline; }

        .cv-file {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-top: 10px;
            padding: 5px 11px;
            border-radius: 8px;
            background: #F2F4F3;
            color: var(--color-primary-dark);
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
        }

        .cv-file:hover { background: var(--color-primary); color: #ffffff; }
        .cv-file i { color: #C2410C; }
        .cv-file:hover i { color: #ffffff; }

        .cv-empty {
            margin: 0;
            padding: 14px 16px;
            border: 1px dashed var(--color-border);
            border-radius: 12px;
            color: var(--color-muted);
            font-size: 13.5px;
        }

        .cv-empty a { color: var(--color-primary-dark); font-weight: 600; }

        /* =====================================================================
           RESPONSIVE
           ===================================================================== */
        @media (max-width: 900px) {
            .cv-hero { grid-template-columns: auto minmax(0, 1fr); }
            .cv-actions { grid-column: 1 / -1; flex-direction: row; flex-wrap: wrap; }
            .cv-body { grid-template-columns: minmax(0, 1fr); }
            .cv-side { border-right: 0; border-bottom: 1px solid var(--color-border); }
            .cv-side-group { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 28px; }
        }

        @media (max-width: 600px) {
            .cv-wrap { padding: 12px 10px 32px; }
            .cv { border-radius: 14px; }
            .cv-hero { grid-template-columns: minmax(0, 1fr); justify-items: center; gap: 16px; padding: 26px 18px; text-align: center; }
            .cv-avatar { width: 108px; height: 108px; }
            .cv-headline { justify-content: center; }
            .cv-chips { justify-content: center; }
            .cv-actions { width: 100%; flex-direction: column; }
            .cv-btn { width: 100%; }
            .cv-side, .cv-main { padding: 22px 16px; }
            .cv-side-group, .cv-facts { grid-template-columns: minmax(0, 1fr); }
            .cv-timeline > li { grid-template-columns: 34px minmax(0, 1fr); gap: 10px; }
            .cv-timeline .dot { width: 34px; height: 34px; font-size: 13px; }
            .cv-timeline > li:not(:last-child)::before { top: 40px; left: 16px; }
            .cv-entry { padding: 12px 14px; }
        }

        /* Impression : le CV seul */
        @media print {
            body { background: #ffffff; }
            .site-header, .pgde-user-footer, .cv-actions, .cv-edit, .cv-more { display: none !important; }
            .cv-wrap { max-width: none; padding: 0; }
            .cv { border: 0; border-radius: 0; box-shadow: none; }
            .cv-hero, .cv-side, .cv-summary, .cv-job .rank, .cv-title .tile, .cv-timeline .dot { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .cv-facts dd.is-clamped { display: block; overflow: visible; }
            .cv-entry { break-inside: avoid; }
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
        // Lien « modifier » vers une étape précise du formulaire (1 à 4)
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

        // Expériences (JSON), anciennes expériences en texte brut, ou expérience unique
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

        $residenceParts = array_filter([
            $userdata->departementResidence->libelle ?? null,
            $userdata->regionResidence->libelle ?? null,
            $userdata->pays->name ?? null,
        ]);
        $residence = implode(', ', array_filter([
            $residenceParts ? implode(', ', $residenceParts) : $userdata->lieuresidence,
            $userdata->addresse,
        ]));
        $birthPlace = implode(', ', array_filter([$userdata->lieunaiss, $userdata->regionNaissance->libelle ?? null]));
        $genderLabel = match ($userdata->genre) {
            'Masculin' => 'Homme',
            'Feminin' => 'Femme',
            default => null,
        };
        $familyLabel = $userdata->situationmatrimoniale
            ? $userdata->situationmatrimoniale . (is_null($userdata->nombreenfant) ? '' : ' · ' . $userdata->nombreenfant . ' enfant' . ($userdata->nombreenfant > 1 ? 's' : ''))
            : null;
        $profileSummary = $userdata->cv_summary ?: $userdata->motivation;

        // Colonne latérale : [icône, libellé, valeur]
        $contactRows = [
            ['fa-envelope', 'E-mail', $candidate->email ?? null],
            ['fa-phone', 'Téléphone', implode(' · ', array_filter([$userdata->telephone1, $userdata->telephone2]))],
            ['fa-location-dot', 'Résidence', $residence],
        ];
        $personalRows = [
            ['fa-cake-candles', 'Date de naissance', $userdata->datenaiss],
            ['fa-map-pin', 'Lieu de naissance', $birthPlace],
            ['fa-venus-mars', 'Genre', $genderLabel],
            ['fa-heart', 'Situation familiale', $familyLabel],
        ];
        if ($userdata->handicap) {
            $personalRows[] = ['fa-wheelchair', 'Handicap', $userdata->handicap->libelle];
        }
    @endphp

    <main class="cv-wrap">
        <article class="cv" aria-labelledby="cv-name">

            <!-- En-tête du CV -->
            <header class="cv-hero">
                <div class="cv-avatar">
                    <img src="{{ asset($userdata->photo_profil ?: 'images/images.png') }}" alt="Photo de {{ $fullName }}">
                </div>

                <div class="cv-identity">
                    <p class="cv-eyebrow">Candidat à la fonction publique</p>
                    <h1 id="cv-name">{{ $fullName ?: 'Mon CV' }}</h1>
                    <p class="cv-headline">
                        <i class="fas fa-bullseye" aria-hidden="true"></i>
                        @if ($userdata->emploi1)
                            <span>Emploi visé : <strong>{{ $userdata->emploi1->libelle }}</strong></span>
                        @else
                            <span>Emploi visé non renseigné</span>
                        @endif
                    </p>
                    <div class="cv-chips">
                        <span class="cv-chip"><i class="fas fa-hashtag" aria-hidden="true"></i> N° d'inscription <strong>{{ $candidate->id }}</strong></span>
                        @if (!empty($candidate->numberid))
                            <span class="cv-chip"><i class="fas fa-id-card" aria-hidden="true"></i> CNI / Passeport <strong>{{ $candidate->numberid }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="cv-actions">
                    <a href="{{ route('userdata.edit', ['id' => $userdata->id]) }}" class="cv-btn cv-btn-light">
                        <i class="fas fa-pen-to-square" aria-hidden="true"></i> Modifier mon dossier
                    </a>
                    <button type="button" class="cv-btn cv-btn-ghost" onclick="window.print()">
                        <i class="fas fa-print" aria-hidden="true"></i> Imprimer / PDF
                    </button>
                </div>
            </header>

            <div class="cv-body">
                <!-- Colonne latérale -->
                <aside class="cv-side">
                    <div class="cv-side-group">
                        <section aria-labelledby="cv-contact">
                            <div class="cv-title">
                                <span class="tile" aria-hidden="true"><i class="fas fa-address-book"></i></span>
                                <h2 id="cv-contact">Coordonnées</h2>
                                <a class="cv-edit" href="{{ $editUrl(1) }}" title="Modifier les coordonnées" aria-label="Modifier les coordonnées"><i class="fas fa-pen" aria-hidden="true"></i></a>
                            </div>
                            <dl class="cv-info">
                                @foreach ($contactRows as [$icon, $label, $value])
                                    <div class="cv-info-row">
                                        <span class="ic" aria-hidden="true"><i class="fas {{ $icon }}"></i></span>
                                        <div><dt>{{ $label }}</dt><dd class="{{ filled($value) ? '' : 'is-empty' }}">{{ filled($value) ? $value : 'Non renseigné' }}</dd></div>
                                    </div>
                                @endforeach
                            </dl>
                        </section>

                        <section aria-labelledby="cv-personal">
                            <div class="cv-title">
                                <span class="tile" aria-hidden="true"><i class="fas fa-user"></i></span>
                                <h2 id="cv-personal">Informations</h2>
                                <a class="cv-edit" href="{{ $editUrl(1) }}" title="Modifier les informations personnelles" aria-label="Modifier les informations personnelles"><i class="fas fa-pen" aria-hidden="true"></i></a>
                            </div>
                            <dl class="cv-info">
                                @foreach ($personalRows as [$icon, $label, $value])
                                    <div class="cv-info-row">
                                        <span class="ic" aria-hidden="true"><i class="fas {{ $icon }}"></i></span>
                                        <div><dt>{{ $label }}</dt><dd class="{{ filled($value) ? '' : 'is-empty' }}">{{ filled($value) ? $value : 'Non renseigné' }}</dd></div>
                                    </div>
                                @endforeach
                            </dl>
                        </section>
                    </div>

                    <section aria-labelledby="cv-jobs">
                        <div class="cv-title">
                            <span class="tile" aria-hidden="true"><i class="fas fa-bullseye"></i></span>
                            <h2 id="cv-jobs">Emplois visés</h2>
                            <a class="cv-edit" href="{{ $editUrl(4) }}" title="Modifier les emplois visés" aria-label="Modifier les emplois visés"><i class="fas fa-pen" aria-hidden="true"></i></a>
                        </div>
                        <div class="cv-jobs">
                            @foreach ([$userdata->emploi1, $userdata->emploi2] as $rank => $job)
                                <div class="cv-job">
                                    <span class="rank" aria-label="{{ $rank === 0 ? 'Premier' : 'Second' }} choix">{{ $rank + 1 }}</span>
                                    <div>
                                        <strong>{{ $job->libelle ?? 'Non renseigné' }}</strong>
                                        <span>{{ $job->secteur->libelle ?? 'Secteur non renseigné' }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </aside>

                <!-- Colonne principale -->
                <div class="cv-main">
                    @if (!empty($profileSummary))
                        <section aria-labelledby="cv-profile">
                            <div class="cv-title">
                                <span class="tile" aria-hidden="true"><i class="fas fa-align-left"></i></span>
                                <h2 id="cv-profile">Profil</h2>
                                <a class="cv-edit" href="{{ $editUrl(4) }}" title="Modifier le profil" aria-label="Modifier le profil"><i class="fas fa-pen" aria-hidden="true"></i></a>
                            </div>
                            <p class="cv-summary"><span class="cv-summary-label">{{ !empty($userdata->cv_summary) ? 'Résumé du profil' : 'Lettre de motivation' }}</span>{{ $profileSummary }}</p>
                        </section>
                    @endif

                    <section aria-labelledby="cv-education">
                        <div class="cv-title">
                            <span class="tile" aria-hidden="true"><i class="fas fa-graduation-cap"></i></span>
                            <h2 id="cv-education">Formations & diplômes<span class="count">({{ count($formationsList) }})</span></h2>
                            <a class="cv-edit" href="{{ $editUrl(2) }}" title="Modifier les formations" aria-label="Modifier les formations"><i class="fas fa-pen" aria-hidden="true"></i></a>
                        </div>
                        @if (!empty($formationsList))
                            <ol class="cv-timeline">
                                @foreach ($formationsList as $formation)
                                    @php
                                        $academicId = $formation['academic_id'] ?? null;
                                        $levelLabel = in_array($academicId, ['sansdiplome', '20'], true)
                                            ? 'Sans diplôme'
                                            : ($academicLabels[$academicId] ?? 'Niveau non renseigné');
                                        $diplomaFile = $formation['diplome_file'] ?? null;
                                    @endphp
                                    <li>
                                        <span class="dot" aria-hidden="true"><i class="fas fa-graduation-cap"></i></span>
                                        <div class="cv-entry">
                                            <div class="cv-entry-head">
                                                <h3>{{ ($formation['diplome'] ?? null) ?: $levelLabel }}</h3>
                                                @if (!empty($formation['anneediplome']))
                                                    <span class="cv-badge"><i class="far fa-calendar" aria-hidden="true"></i> {{ $formation['anneediplome'] }}</span>
                                                @endif
                                            </div>
                                            <dl class="cv-facts">
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
                                                <a href="{{ asset($diplomaFile) }}" target="_blank" rel="noopener" class="cv-file">
                                                    <i class="fas fa-file-pdf" aria-hidden="true"></i> Voir le justificatif
                                                </a>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        @else
                            <p class="cv-empty">Aucune formation renseignée. <a href="{{ $editUrl(2) }}">Ajouter une formation</a></p>
                        @endif
                    </section>

                    <section aria-labelledby="cv-experience">
                        <div class="cv-title">
                            <span class="tile" aria-hidden="true"><i class="fas fa-briefcase"></i></span>
                            <h2 id="cv-experience">Expérience professionnelle<span class="count">({{ count($experiencesList) }})</span></h2>
                            <a class="cv-edit" href="{{ $editUrl(3) }}" title="Modifier les expériences" aria-label="Modifier les expériences"><i class="fas fa-pen" aria-hidden="true"></i></a>
                        </div>
                        @if (!empty($experiencesList))
                            <ol class="cv-timeline">
                                @foreach ($experiencesList as $experience)
                                    <li>
                                        <span class="dot" aria-hidden="true"><i class="fas fa-briefcase"></i></span>
                                        <div class="cv-entry">
                                            <div class="cv-entry-head">
                                                <h3>{{ ($experience['poste'] ?? null) ?: ($userdata->posteoccupe ?: 'Expérience professionnelle') }}</h3>
                                                @if (!empty($experience['years']))
                                                    <span class="cv-badge"><i class="far fa-clock" aria-hidden="true"></i> {{ $experience['years'] }} an{{ $experience['years'] > 1 ? 's' : '' }}</span>
                                                @endif
                                            </div>
                                            <dl class="cv-facts">
                                                <div class="is-full">
                                                    <dt><i class="fas fa-building" aria-hidden="true"></i> Entreprise</dt>
                                                    <dd>{{ ($experience['employeur'] ?? null) ?: 'Non renseignée' }}</dd>
                                                </div>
                                                @if (!empty($experience['description']))
                                                    <div class="is-full">
                                                        <dt><i class="fas fa-list-check" aria-hidden="true"></i> Missions</dt>
                                                        <dd class="is-clamped" data-clamp style="white-space: pre-line;">{{ $experience['description'] }}</dd>
                                                        <button type="button" class="cv-more" hidden>Voir plus</button>
                                                    </div>
                                                @endif
                                            </dl>
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        @else
                            <p class="cv-empty">Aucune expérience professionnelle déclarée.</p>
                        @endif
                    </section>
                </div>
            </div>
        </article>
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
