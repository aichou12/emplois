<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guide du candidat — Plateforme de Gestion des Demandes d'Emploi</title>
    <link rel="icon" href="{{ asset('images/mfp.png') }}?v=2" type="image/x-icon">

    <!-- Polices de la charte : Poppins & DM Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --color-primary: #008C45;
            --color-primary-dark: #006B35;
            --color-primary-light: #EBF7F0;
            --color-yellow: #F7C600;
            --color-danger: #ED2939;
            --color-text: #1D1D1B;
            --color-text-secondary: #575A7B;
            --color-muted: #5b6b62;
            --color-border: #e5e7eb;
            --color-bg-page: #F2F3F5;
            --font-heading: 'Poppins', sans-serif;
            --font-body: 'DM Sans', sans-serif;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--color-bg-page);
            color: var(--color-text);
            font-family: var(--font-body);
            font-size: 15px;
            line-height: 1.6;
        }

        /* Même largeur que le header et le footer */
        .guide-wrap {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 clamp(14px, 2vw, 20px);
        }

        /* ===== Introduction ===== */
        .guide-intro {
            background: #ffffff;
            border-bottom: 1px solid var(--color-border);
        }

        .guide-intro .guide-wrap {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px 40px;
            padding-top: clamp(24px, 3.5vw, 40px);
            padding-bottom: clamp(24px, 3.5vw, 40px);
        }

        .guide-kicker {
            margin: 0 0 6px;
            font-family: var(--font-heading);
            font-size: 12.5px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--color-primary);
        }

        .guide-intro h1 {
            margin: 0 0 10px;
            font-family: var(--font-heading);
            font-size: clamp(24px, 2.6vw, 32px);
            font-weight: 700;
            line-height: 1.2;
            text-wrap: balance;
        }

        .guide-intro p.lead {
            margin: 0;
            max-width: 60ch;
            color: var(--color-text-secondary);
        }

        .guide-intro-actions {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        /* Pastille d'état des inscriptions (réglage admin) */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12.5px;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .status-pill::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: currentColor;
        }

        .status-pill.is-open { background: var(--color-primary-light); color: var(--color-primary-dark); }
        .status-pill.is-closed { background: #fdecee; color: #b3121f; }

        .guide-buttons { display: flex; flex-wrap: wrap; gap: 10px; }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 3px;
            font-family: var(--font-heading);
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            text-decoration: none;
            transition: background .15s ease, color .15s ease;
        }

        .btn-primary { background: var(--color-primary); color: #fff; box-shadow: 0 2px 0 var(--color-primary-dark); }
        .btn-primary:hover { background: var(--color-primary-dark); }
        .btn-outline { border: 1.5px solid var(--color-primary); color: var(--color-primary); background: #fff; }
        .btn-outline:hover { background: var(--color-primary-light); }
        .btn:focus-visible, .guide-toc a:focus-visible, summary:focus-visible { outline: 2px solid var(--color-text); outline-offset: 2px; }

        /* ===== Mise en page : sommaire + contenu ===== */
        .guide-body {
            display: grid;
            grid-template-columns: 230px minmax(0, 1fr);
            gap: 32px;
            align-items: start;
            padding-top: 32px;
            padding-bottom: 56px;
        }

        .guide-toc {
            position: sticky;
            top: 16px;
            display: flex;
            flex-direction: column;
            gap: 2px;
            padding: 14px;
            background: #ffffff;
            border: 1px solid var(--color-border);
            border-radius: 8px;
        }

        .guide-toc-title {
            margin: 0 0 6px;
            padding: 0 10px;
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--color-muted);
        }

        .guide-toc a {
            padding: 7px 10px;
            border-left: 3px solid transparent;
            color: var(--color-text);
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
        }

        .guide-toc a:hover {
            border-left-color: var(--color-primary);
            background: var(--color-primary-light);
            color: var(--color-primary-dark);
        }

        .guide-sections { display: flex; flex-direction: column; gap: 20px; }

        .guide-section {
            scroll-margin-top: 16px;
            padding: clamp(20px, 2.6vw, 32px);
            background: #ffffff;
            border: 1px solid var(--color-border);
            border-radius: 8px;
        }

        .guide-section h2 {
            margin: 0 0 14px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--color-border);
            font-family: var(--font-heading);
            font-size: clamp(17px, 1.5vw, 20px);
            font-weight: 600;
        }

        .guide-section p { margin: 0 0 12px; max-width: 70ch; }
        .guide-section p:last-child { margin-bottom: 0; }

        /* Étapes : vraie séquence, donc numérotées */
        .guide-steps {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .guide-steps li {
            display: grid;
            grid-template-columns: 34px minmax(0, 1fr);
            gap: 14px;
            align-items: start;
        }

        .step-number {
            display: grid;
            place-items: center;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--color-primary-light);
            color: var(--color-primary);
            font-family: var(--font-heading);
            font-weight: 700;
        }

        .guide-steps li.is-account .step-number { background: var(--color-primary); color: #fff; }

        .guide-steps strong {
            display: block;
            font-family: var(--font-heading);
            font-size: 15px;
            font-weight: 600;
        }

        .guide-steps span.step-detail { color: var(--color-text-secondary); font-size: 14px; }

        /* Tableau des documents */
        .table-scroll { overflow-x: auto; }

        .docs-table {
            width: 100%;
            min-width: 520px;
            border-collapse: collapse;
            font-size: 14px;
        }

        .docs-table th {
            padding: 10px 12px;
            background: #f2f2f2;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-align: left;
            text-transform: uppercase;
            color: var(--color-muted);
        }

        .docs-table td {
            padding: 12px;
            border-bottom: 1px solid var(--color-border);
            vertical-align: top;
        }

        .docs-table td:first-child { font-weight: 600; }
        .tag {
            display: inline-block;
            padding: 1px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: 600;
        }
        .tag-required { background: #fdecee; color: #b3121f; }
        .tag-optional { background: #f2f2f2; color: var(--color-muted); }

        .guide-note {
            margin-top: 14px;
            padding: 12px 14px;
            border-left: 3px solid var(--color-yellow);
            background: #fffbea;
            font-size: 14px;
        }

        /* Vidéo */
        .video-frame {
            position: relative;
            width: 100%;
            max-width: 760px;
            aspect-ratio: 16 / 9;
            overflow: hidden;
            border-radius: 8px;
            background: #000;
        }

        .video-frame iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; }

        /* Questions fréquentes */
        .faq { display: flex; flex-direction: column; }

        .faq details { border-bottom: 1px solid var(--color-border); }
        .faq details:last-child { border-bottom: 0; }

        .faq summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 14px 0;
            font-weight: 600;
            cursor: pointer;
            list-style: none;
        }

        .faq summary::-webkit-details-marker { display: none; }

        .faq summary::after {
            content: "+";
            flex-shrink: 0;
            font-family: var(--font-heading);
            font-size: 20px;
            line-height: 1;
            color: var(--color-primary);
        }

        .faq details[open] summary::after { content: "−"; }
        .faq details p { padding-bottom: 14px; color: var(--color-text-secondary); }
        .faq a, .guide-section a.inline-link { color: var(--color-primary); font-weight: 600; }

        @media (max-width: 860px) {
            .guide-body { grid-template-columns: 1fr; gap: 20px; }
            .guide-toc { position: static; flex-direction: row; flex-wrap: wrap; gap: 6px; }
            .guide-toc-title { width: 100%; }
            .guide-toc a { border: 1px solid var(--color-border); border-radius: 3px; font-size: 13px; }
        }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
        }

        html { scroll-behavior: smooth; }
    </style>
</head>
<body>
    @include('partials.site-header')

    <!-- Introduction -->
    <section class="guide-intro">
        <div class="guide-wrap">
            <div>
                <p class="guide-kicker">Guide du candidat</p>
                <h1>Préparer et déposer votre demande d'emploi</h1>
                <p class="lead">Tout ce qu'il faut savoir avant de commencer : qui peut s'inscrire, les étapes du dossier, les documents à préparer et les réponses aux questions les plus fréquentes.</p>
            </div>
            <div class="guide-intro-actions">
                @if ($registrationOpen)
                    <span class="status-pill is-open">Inscriptions ouvertes</span>
                @else
                    <span class="status-pill is-closed">Inscriptions fermées pour le moment</span>
                @endif
                <div class="guide-buttons">
                    @auth
                        <a href="{{ route('home') }}" class="btn btn-primary">Mon dossier</a>
                    @else
                        @if ($registrationOpen)
                            <a href="{{ route('register') }}" class="btn btn-primary">Créer un compte</a>
                        @endif
                        <a href="{{ route('login') }}" class="btn btn-outline">Se connecter</a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <main class="guide-wrap guide-body">
        <!-- Sommaire -->
        <nav class="guide-toc" aria-label="Sommaire du guide">
            <p class="guide-toc-title">Sommaire</p>
            <a href="#qui">Qui peut s'inscrire</a>
            <a href="#etapes">Les étapes</a>
            <a href="#documents">Documents à préparer</a>
            <a href="#video">Vidéo de présentation</a>
            <a href="#faq">Questions fréquentes</a>
        </nav>

        <div class="guide-sections">
            <section class="guide-section" id="qui">
                <h2>Qui peut s'inscrire</h2>
                <p>La plateforme s'adresse à <strong>tout Sénégalais</strong> souhaitant intégrer la fonction publique.</p>
                <p>Les Sénégalais établis à l'étranger peuvent également déposer leur demande : il suffit d'indiquer votre pays et votre adresse de résidence à l'étape 1.</p>
            </section>

            <section class="guide-section" id="etapes">
                <h2>Les étapes</h2>
                <ol class="guide-steps">
                    <li class="is-account">
                        <span class="step-number" aria-hidden="true">0</span>
                        <div>
                            <strong>Créer votre compte</strong>
                            <span class="step-detail">Prénom, nom, numéro de CNI ou de passeport, adresse e-mail, nom d'utilisateur et mot de passe. Un e-mail d'activation vous est ensuite envoyé : cliquez sur le lien qu'il contient avant de vous connecter.</span>
                        </div>
                    </li>
                    <li>
                        <span class="step-number" aria-hidden="true">1</span>
                        <div>
                            <strong>Informations personnelles</strong>
                            <span class="step-detail">Date et lieu de naissance, situation familiale, téléphone, lieu de résidence (au Sénégal ou à l'étranger), situation de handicap éventuelle et photo.</span>
                        </div>
                    </li>
                    <li>
                        <span class="step-number" aria-hidden="true">2</span>
                        <div>
                            <strong>Formation et diplômes</strong>
                            <span class="step-detail">Au moins une formation. Vous pouvez joindre un justificatif pour chaque diplôme.</span>
                        </div>
                    </li>
                    <li>
                        <span class="step-number" aria-hidden="true">3</span>
                        <div>
                            <strong>Expérience professionnelle</strong>
                            <span class="step-detail">Indiquez si vous avez déjà travaillé et, si oui, détaillez vos expériences.</span>
                        </div>
                    </li>
                    <li>
                        <span class="step-number" aria-hidden="true">4</span>
                        <div>
                            <strong>Emplois visés</strong>
                            <span class="step-detail">Choisissez deux emplois, chacun dans un secteur, parmi le référentiel de la fonction publique.</span>
                        </div>
                    </li>
                </ol>
                <p class="guide-note">Une fois le dossier envoyé, un récapitulatif de vos informations est disponible depuis « Mon dossier ».</p>
            </section>

            <section class="guide-section" id="documents">
                <h2>Documents à préparer</h2>
                <div class="table-scroll">
                    <table class="docs-table">
                        <thead>
                            <tr>
                                <th scope="col">Document</th>
                                <th scope="col">Formats acceptés</th>
                                <th scope="col">Taille maximale</th>
                                <th scope="col">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Pièce d'identité</td>
                                <td>Numéro de CNI ou de passeport (lettres et chiffres)</td>
                                <td>—</td>
                                <td><span class="tag tag-required">Obligatoire</span></td>
                            </tr>
                            <tr>
                                <td>Photo d'identité</td>
                                <td>JPG, PNG ou GIF</td>
                                <td>2 Mo</td>
                                <td><span class="tag tag-optional">Facultatif</span></td>
                            </tr>
                            <tr>
                                <td>Justificatif de diplôme</td>
                                <td>PDF, Word (DOC, DOCX), RTF, TXT, JPG ou PNG</td>
                                <td>4 Mo par fichier</td>
                                <td><span class="tag tag-optional">Facultatif</span></td>
                            </tr>
                            <tr>
                                <td>Numéro de téléphone</td>
                                <td>Chiffres uniquement, de 7 à 15</td>
                                <td>—</td>
                                <td><span class="tag tag-required">Obligatoire</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="guide-note">Conseil : scannez vos diplômes en PDF avant de commencer. Une photo prise au téléphone dépasse souvent 2 Mo ; réduisez-la si l'envoi est refusé.</p>
            </section>

            <section class="guide-section" id="video">
                <h2>Vidéo de présentation</h2>
                <p>Une présentation de la plateforme pour vous guider dans votre espace candidat.</p>
                <div class="video-frame">
                    <iframe
                        src="{{ $guideVideoEmbedUrl }}"
                        title="Présentation de la Plateforme de Gestion des Demandes d'Emploi"
                        loading="lazy"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
            </section>

            <section class="guide-section" id="faq">
                <h2>Questions fréquentes</h2>
                <div class="faq">
                    <details>
                        <summary>Je n'ai pas reçu l'e-mail d'activation</summary>
                        <p>Vérifiez votre dossier « Courriers indésirables » ou « Spam ». Si l'e-mail n'y est pas, vous pouvez en demander un nouveau depuis la <a href="{{ route('verification.notice') }}">page de vérification</a>.</p>
                    </details>
                    <details>
                        <summary>J'ai oublié mon mot de passe</summary>
                        <p>Utilisez la page <a href="{{ route('password.request') }}">Mot de passe oublié</a> : un lien de réinitialisation vous sera envoyé par e-mail.</p>
                    </details>
                    <details>
                        <summary>Je n'ai pas de diplôme, puis-je m'inscrire ?</summary>
                        <p>Oui. À l'étape 2, choisissez « Sans diplôme » dans la liste des niveaux.</p>
                    </details>
                    <details>
                        <summary>J'habite à l'étranger</summary>
                        <p>À l'étape 1, indiquez que vous résidez à l'étranger, puis renseignez votre pays et votre adresse.</p>
                    </details>
                    <details>
                        <summary>Puis-je modifier mon dossier après l'avoir envoyé ?</summary>
                        <p>Oui. Connectez-vous puis cliquez sur « Mon dossier » en haut de la page pour mettre vos informations à jour.</p>
                    </details>
                    <details>
                        <summary>Combien d'emplois puis-je viser ?</summary>
                        <p>Deux emplois, chacun dans un secteur. Vous les choisissez à l'étape 4 parmi le référentiel des emplois de la fonction publique.</p>
                    </details>
                </div>
            </section>
        </div>
    </main>

    @include('partials.user-footer')
</body>
</html>
