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
            max-width: 1040px;
            margin: 0 auto;
            padding: 24px clamp(12px, 2vw, 20px) 48px;
        }

        .cv {
            overflow: hidden;
            background: #ffffff;
            border: 1px solid var(--color-border);
            border-radius: 16px;
            box-shadow: 0 12px 36px rgba(29, 29, 27, .07);
        }

        /* =====================================================================
           EN-TÊTE DU CV : bandeau vert, photo, nom, emploi visé, actions
           ===================================================================== */
        .cv-hero {
            position: relative;
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto;
            align-items: center;
            gap: 24px;
            padding: 32px 36px;
            background:
                radial-gradient(120% 140% at 100% 0%, rgba(247, 198, 0, .16) 0%, transparent 45%),
                linear-gradient(135deg, var(--color-primary-deep) 0%, var(--color-primary-dark) 55%, var(--color-primary) 100%);
            color: #ffffff;
        }

        .cv-photo {
            width: 128px;
            height: 128px;
            padding: 4px;
            border-radius: 22px;
            background: rgba(255, 255, 255, .95);
            box-shadow: 0 10px 24px rgba(0, 0, 0, .25);
        }

        .cv-photo img {
            display: block;
            width: 100%;
            height: 100%;
            border-radius: 18px;
            object-fit: cover;
        }

        .cv-identity { min-width: 0; }

        .cv-eyebrow {
            margin: 0 0 4px;
            color: rgba(255, 255, 255, .75);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .12em;
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
            margin: 6px 0 14px;
            color: rgba(255, 255, 255, .9);
            font-size: 15px;
        }

        .cv-headline strong { color: #ffffff; font-weight: 600; }

        .cv-chips { display: flex; flex-wrap: wrap; gap: 8px; }

        .cv-chip {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 12px;
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 999px;
            background: rgba(255, 255, 255, .1);
            color: #ffffff;
            font-size: 12.5px;
            font-weight: 500;
        }

        .cv-chip i { color: var(--color-yellow); font-size: 12px; }
        .cv-chip strong { font-weight: 700; letter-spacing: .03em; }

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
            transition: background .2s ease, color .2s ease, transform .12s ease;
        }

        .cv-btn:active { transform: translateY(1px); }
        .cv-btn:focus-visible { outline: 3px solid rgba(247, 198, 0, .7); outline-offset: 2px; }

        .cv-btn-light { background: #ffffff; color: var(--color-primary-dark); }
        .cv-btn-light:hover { background: var(--color-primary-light); color: var(--color-primary-dark); }

        .cv-btn-ghost {
            background: rgba(255, 255, 255, .12);
            color: #ffffff;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .3);
        }

        .cv-btn-ghost:hover { background: rgba(255, 255, 255, .2); }

        /* =====================================================================
           CORPS : colonne latérale (coordonnées, infos) + colonne principale
           ===================================================================== */
        .cv-body {
            display: grid;
            grid-template-columns: 300px minmax(0, 1fr);
        }

        .cv-side {
            display: flex;
            flex-direction: column;
            gap: 28px;
            padding: 28px 26px;
            background: #F7F9F8;
            border-right: 1px solid var(--color-border);
        }

        /* Coordonnées + Informations : empilées sur ordinateur, côte à côte sur tablette */
        .cv-side-grid { display: flex; flex-direction: column; gap: 28px; }

        .cv-main {
            display: flex;
            flex-direction: column;
            gap: 32px;
            padding: 28px 34px 34px;
            min-width: 0;
        }

        /* Titres de section */
        .cv-section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0 0 16px;
            font-family: var(--font-heading);
            font-size: 15px;
            font-weight: 600;
            color: var(--color-text);
        }

        .cv-section-title .tile {
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

        .cv-section-title::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--color-border);
        }

        .cv-side .cv-section-title { font-size: 14px; margin-bottom: 14px; }

        /* Lignes d'information (icône + libellé + valeur) */
        .cv-info { display: flex; flex-direction: column; gap: 12px; margin: 0; }

        .cv-info-row {
            display: grid;
            grid-template-columns: 30px minmax(0, 1fr);
            gap: 10px;
            align-items: start;
        }

        .cv-info-row .ic {
            display: grid;
            place-items: center;
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: #ffffff;
            border: 1px solid var(--color-border);
            color: var(--color-primary);
            font-size: 13px;
        }

        .cv-info-row dt {
            margin: 0;
            color: var(--color-muted);
            font-size: 11.5px;
            font-weight: 600;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .cv-info-row dd {
            margin: 1px 0 0;
            color: var(--color-text);
            font-size: 14px;
            font-weight: 500;
            overflow-wrap: anywhere;
        }

        .cv-info-row dd a { color: inherit; text-decoration: none; }
        .cv-info-row dd a:hover { color: var(--color-primary); text-decoration: underline; }

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

        .cv-job.is-second .rank { background: var(--color-primary-light); color: var(--color-primary); }

        .cv-job .job { font-family: var(--font-heading); font-size: 13.5px; font-weight: 600; line-height: 1.3; }
        .cv-job .sector { color: var(--color-muted); font-size: 12px; }

        /* Profil (résumé) */
        .cv-summary {
            margin: 0;
            padding: 16px 18px;
            border-radius: 12px;
            background: var(--color-primary-light);
            color: var(--color-text);
            font-size: 14.5px;
            line-height: 1.7;
        }

        /* Parcours (formations, expériences) : frise verticale */
        .cv-timeline {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .cv-timeline li {
            position: relative;
            display: grid;
            grid-template-columns: 40px minmax(0, 1fr);
            gap: 14px;
        }

        /* Trait qui relie les étapes du parcours */
        .cv-timeline li:not(:last-child)::before {
            content: "";
            position: absolute;
            top: 44px;
            bottom: -10px;
            left: 19px;
            width: 2px;
            border-radius: 2px;
            background: #dfeee5;
        }

        .cv-timeline .dot {
            display: grid;
            place-items: center;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--color-primary-light);
            color: var(--color-primary);
            font-size: 16px;
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
            flex-wrap: wrap;
            align-items: baseline;
            justify-content: space-between;
            gap: 4px 12px;
        }

        .cv-entry h3 {
            margin: 0;
            font-family: var(--font-heading);
            font-size: 15px;
            font-weight: 600;
            line-height: 1.35;
            overflow-wrap: anywhere;
        }

        .cv-entry .place { color: var(--color-text-secondary); font-size: 13.5px; }

        .cv-entry .when {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
            padding: 2px 10px;
            border-radius: 999px;
            background: #F2F4F3;
            color: var(--color-primary-dark);
            font-size: 12px;
            font-weight: 600;
        }

        .cv-entry .detail { margin: 8px 0 0; color: var(--color-text); font-size: 13.5px; overflow-wrap: anywhere; }
        .cv-entry .detail span { color: var(--color-muted); }

        .cv-file {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            max-width: 100%;
            margin-top: 10px;
            padding: 6px 12px;
            border-radius: 8px;
            background: #F2F4F3;
            color: var(--color-primary-dark);
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            overflow-wrap: anywhere;
        }

        .cv-file:hover { background: var(--color-primary); color: #ffffff; }
        .cv-file i { color: #D9342B; }
        .cv-file:hover i { color: #ffffff; }

        .cv-empty a { color: var(--color-primary); font-weight: 600; }

        .cv-empty {
            margin: 0;
            padding: 14px 16px;
            border: 1px dashed var(--color-border);
            border-radius: 12px;
            color: var(--color-muted);
            font-size: 13.5px;
        }

        /* =====================================================================
           RESPONSIVE
           ===================================================================== */
        @media (max-width: 900px) {
            .cv-hero { grid-template-columns: auto minmax(0, 1fr); }
            .cv-actions { grid-column: 1 / -1; flex-direction: row; flex-wrap: wrap; }
            .cv-body { grid-template-columns: minmax(0, 1fr); }
            .cv-side { border-right: 0; border-bottom: 1px solid var(--color-border); }
            .cv-side-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 28px; }
        }

        @media (max-width: 600px) {
            .cv-wrap { padding: 12px 10px 32px; }
            .cv { border-radius: 12px; }
            .cv-hero { grid-template-columns: minmax(0, 1fr); justify-items: center; gap: 16px; padding: 24px 18px; text-align: center; }
            .cv-photo { width: 108px; height: 108px; border-radius: 20px; }
            .cv-chips { justify-content: center; }
            .cv-actions { width: 100%; flex-direction: column; }
            .cv-btn { width: 100%; }
            .cv-side, .cv-main { padding: 22px 16px; }
            .cv-side-grid { grid-template-columns: minmax(0, 1fr); }
            .cv-timeline li { grid-template-columns: 34px minmax(0, 1fr); gap: 10px; }
            .cv-timeline .dot { width: 34px; height: 34px; border-radius: 10px; font-size: 14px; }
            .cv-timeline li:not(:last-child)::before { top: 38px; left: 16px; }
        }

        /* =====================================================================
           IMPRESSION : le CV seul, sans header, footer ni boutons
           ===================================================================== */
        @media print {
            body { background: #ffffff; }
            .site-header, .pgde-user-footer, .cv-actions { display: none !important; }
            .cv-wrap { max-width: none; padding: 0; }
            .cv { border: 0; border-radius: 0; box-shadow: none; }
            .cv-hero, .cv-job .rank, .cv-summary, .cv-side { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
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

        // Formations (JSON) avec repli sur l'ancienne formation unique
        $formationsList = [];
        if (!empty($userdata->autresdiplomes)) {
            $decodedFormations = is_array($userdata->autresdiplomes)
                ? $userdata->autresdiplomes
                : json_decode($userdata->autresdiplomes, true);
            if (is_array($decodedFormations)) {
                $formationsList = $decodedFormations;
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
                $experiencesList = $decodedExperiences;
            }
        }
        if (empty($experiencesList) && (!empty($userdata->posteoccupe) || !empty($userdata->employeur))) {
            $experiencesList[] = [
                'poste' => $userdata->posteoccupe,
                'employeur' => $userdata->employeur,
                'years' => $userdata->nombreanneeexpe,
            ];
        }

        // Résidence lisible : département, région ou pays + adresse
        $residenceParts = array_filter([
            $userdata->departementResidence->libelle ?? null,
            $userdata->regionResidence->libelle ?? null,
            $userdata->pays->name ?? null,
        ]);
        $residence = $residenceParts ? implode(', ', $residenceParts) : ($userdata->lieuresidence ?: 'Non renseignée');

        $birthPlace = array_filter([$userdata->lieunaiss, $userdata->regionNaissance->libelle ?? null]);
        $genderLabel = match ($userdata->genre) {
            'Masculin' => 'Homme',
            'Feminin' => 'Femme',
            default => 'Non renseigné',
        };
        $firstJob = $userdata->emploi1->libelle ?? null;
    @endphp

    <main class="cv-wrap">
        <article class="cv" aria-labelledby="cv-name">

            <!-- En-tête du CV -->
            <header class="cv-hero">
                <div class="cv-photo">
                    <img src="{{ asset($userdata->photo_profil ?: 'images/images.png') }}" alt="Photo de {{ $fullName }}">
                </div>

                <div class="cv-identity">
                    <p class="cv-eyebrow">Candidat à la fonction publique</p>
                    <h1 id="cv-name">{{ $fullName ?: 'Candidat' }}</h1>
                    @if ($firstJob)
                        <p class="cv-headline">Emploi visé : <strong>{{ $firstJob }}</strong></p>
                    @else
                        <p class="cv-headline">Emploi visé non renseigné</p>
                    @endif
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
                    <div class="cv-side-grid">
                        <section aria-labelledby="cv-contact">
                            <h2 class="cv-section-title" id="cv-contact"><span class="tile" aria-hidden="true"><i class="fas fa-address-book"></i></span>Coordonnées</h2>
                            <dl class="cv-info">
                                <div class="cv-info-row">
                                    <span class="ic" aria-hidden="true"><i class="fas fa-envelope"></i></span>
                                    <div><dt>E-mail</dt><dd><a href="mailto:{{ $candidate->email }}">{{ $candidate->email }}</a></dd></div>
                                </div>
                                <div class="cv-info-row">
                                    <span class="ic" aria-hidden="true"><i class="fas fa-phone"></i></span>
                                    <div>
                                        <dt>Téléphone</dt>
                                        <dd>{{ $userdata->telephone1 ?: 'Non renseigné' }}@if ($userdata->telephone2)<br>{{ $userdata->telephone2 }}@endif</dd>
                                    </div>
                                </div>
                                <div class="cv-info-row">
                                    <span class="ic" aria-hidden="true"><i class="fas fa-location-dot"></i></span>
                                    <div><dt>Résidence</dt><dd>{{ $residence }}@if ($userdata->addresse)<br>{{ $userdata->addresse }}@endif</dd></div>
                                </div>
                            </dl>
                        </section>

                        <section aria-labelledby="cv-personal">
                            <h2 class="cv-section-title" id="cv-personal"><span class="tile" aria-hidden="true"><i class="fas fa-user"></i></span>Informations</h2>
                            <dl class="cv-info">
                                <div class="cv-info-row">
                                    <span class="ic" aria-hidden="true"><i class="fas fa-cake-candles"></i></span>
                                    <div><dt>Naissance</dt><dd>{{ $userdata->datenaiss ?: 'Non renseignée' }}@if ($birthPlace)<br>à {{ implode(', ', $birthPlace) }}@endif</dd></div>
                                </div>
                                <div class="cv-info-row">
                                    <span class="ic" aria-hidden="true"><i class="fas fa-venus-mars"></i></span>
                                    <div><dt>Genre</dt><dd>{{ $genderLabel }}</dd></div>
                                </div>
                                <div class="cv-info-row">
                                    <span class="ic" aria-hidden="true"><i class="fas fa-heart"></i></span>
                                    <div>
                                        <dt>Situation familiale</dt>
                                        <dd>{{ $userdata->situationmatrimoniale ?: 'Non renseignée' }}@if (!is_null($userdata->nombreenfant)) · {{ $userdata->nombreenfant }} enfant{{ $userdata->nombreenfant > 1 ? 's' : '' }}@endif</dd>
                                    </div>
                                </div>
                                @if ($userdata->handicap)
                                    <div class="cv-info-row">
                                        <span class="ic" aria-hidden="true"><i class="fas fa-wheelchair"></i></span>
                                        <div><dt>Handicap</dt><dd>{{ $userdata->handicap->libelle }}</dd></div>
                                    </div>
                                @endif
                            </dl>
                        </section>
                    </div>

                    <section aria-labelledby="cv-jobs">
                        <h2 class="cv-section-title" id="cv-jobs"><span class="tile" aria-hidden="true"><i class="fas fa-bullseye"></i></span>Emplois visés</h2>
                        <div class="cv-jobs">
                            <div class="cv-job">
                                <span class="rank" aria-label="Premier choix">1</span>
                                <div>
                                    <div class="job">{{ $userdata->emploi1->libelle ?? 'Non renseigné' }}</div>
                                    <div class="sector">{{ $userdata->emploi1->secteur->libelle ?? 'Secteur non renseigné' }}</div>
                                </div>
                            </div>
                            <div class="cv-job is-second">
                                <span class="rank" aria-label="Deuxième choix">2</span>
                                <div>
                                    <div class="job">{{ $userdata->emploi2->libelle ?? 'Non renseigné' }}</div>
                                    <div class="sector">{{ $userdata->emploi2->secteur->libelle ?? 'Secteur non renseigné' }}</div>
                                </div>
                            </div>
                        </div>
                    </section>
                </aside>

                <!-- Colonne principale -->
                <div class="cv-main">
                    @if (!empty($userdata->cv_summary))
                        <section aria-labelledby="cv-profile">
                            <h2 class="cv-section-title" id="cv-profile"><span class="tile" aria-hidden="true"><i class="fas fa-align-left"></i></span>Profil</h2>
                            <p class="cv-summary">{{ $userdata->cv_summary }}</p>
                        </section>
                    @endif

                    <section aria-labelledby="cv-education">
                        <h2 class="cv-section-title" id="cv-education"><span class="tile" aria-hidden="true"><i class="fas fa-graduation-cap"></i></span>Formations & diplômes</h2>
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
                                                <h3>{{ $formation['diplome'] ?? null ?: $levelLabel }}</h3>
                                                @if (!empty($formation['anneediplome']))
                                                    <span class="when"><i class="far fa-calendar" aria-hidden="true"></i> {{ $formation['anneediplome'] }}</span>
                                                @endif
                                            </div>
                                            @if (!empty($formation['etablissementdiplome']))
                                                <div class="place">{{ $formation['etablissementdiplome'] }}</div>
                                            @endif
                                            @if (!empty($formation['diplome']))
                                                <p class="detail"><span>Niveau :</span> {{ $levelLabel }}</p>
                                            @endif
                                            @if (!empty($formation['specialite']))
                                                <p class="detail"><span>Spécialité :</span> {{ $formation['specialite'] }}</p>
                                            @endif
                                            @if ($diplomaFile)
                                                <a href="{{ asset($diplomaFile) }}" target="_blank" rel="noopener" class="cv-file">
                                                    <i class="fas fa-file-pdf" aria-hidden="true"></i> {{ basename($diplomaFile) }}
                                                </a>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        @else
                            <p class="cv-empty">Aucune formation renseignée. <a href="{{ route('userdata.edit', ['id' => $userdata->id]) }}">Compléter mon dossier</a></p>
                        @endif
                    </section>

                    <section aria-labelledby="cv-experience">
                        <h2 class="cv-section-title" id="cv-experience"><span class="tile" aria-hidden="true"><i class="fas fa-briefcase"></i></span>Expérience professionnelle</h2>
                        @if (!empty($experiencesList))
                            <ol class="cv-timeline">
                                @foreach ($experiencesList as $experience)
                                    <li>
                                        <span class="dot" aria-hidden="true"><i class="fas fa-briefcase"></i></span>
                                        <div class="cv-entry">
                                            <div class="cv-entry-head">
                                                <h3>{{ $experience['poste'] ?? null ?: 'Poste non renseigné' }}</h3>
                                                @if (!empty($experience['years']))
                                                    <span class="when"><i class="far fa-clock" aria-hidden="true"></i> {{ $experience['years'] }} an{{ $experience['years'] > 1 ? 's' : '' }}</span>
                                                @endif
                                            </div>
                                            @if (!empty($experience['employeur']))
                                                <div class="place">{{ $experience['employeur'] }}</div>
                                            @endif
                                            @if (!empty($experience['description']))
                                                <p class="detail">{{ $experience['description'] }}</p>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        @else
                            <p class="cv-empty">Aucune expérience professionnelle renseignée.</p>
                        @endif
                    </section>
                </div>
            </div>
        </article>
    </main>

    @include('partials.user-footer')

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
