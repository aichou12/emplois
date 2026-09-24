<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Résumé du profil — Plateforme de Gestion des Demandes d'Emploi</title>
    <link rel="icon" href="{{ asset('images/mfp.png') }}?v=2" type="image/x-icon">
    
    <!-- Polices Google & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <style>
      :root {
        --color-primary: #008C45;
        --color-primary-dark: #006B35;
        --color-primary-light: #EBF7F0;
        --color-secondary: #FFC107;
        --color-secondary-dark: #D99F00;
        --color-danger: #ED2939;
        --color-text: #1D1D1B;
        --color-text-secondary: #575A7B;
        --color-white: #FFFFFF;
        --color-border: #E5E5E5;
        --color-bg: #F4F6F5;
        --color-card-bg: #FAFAF9;
        --font-heading: 'Poppins', sans-serif;
        --font-body: 'DM Sans', sans-serif;
        --radius-sm: 6px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --shadow-card: 0 10px 30px rgba(29, 29, 27, 0.06);
      }

      *, *::before, *::after {
        box-sizing: border-box;
      }

      body {
        background-color: var(--color-bg);
        font-family: var(--font-body);
        color: var(--color-text);
        margin: 0;
        padding: 0;
        font-size: 15px;
        line-height: 1.5;
        -webkit-font-smoothing: antialiased;
      }

      main.wrap {
        max-width: 960px;
        margin: 24px auto 60px;
        padding: 0 16px;
      }

      /* Top bar inscription */
      .top-status-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 14px;
      }

      .insc-chip {
        font-size: 13px;
        font-weight: 500;
        color: var(--color-text-secondary);
        background: var(--color-white);
        border: 1px solid var(--color-border);
        padding: 6px 14px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.03);
      }

      .insc-chip i {
        color: var(--color-primary);
      }

      /* ===== CARTE PROFIL PRINCIPALE ===== */
      .profile-card {
        background: var(--color-white);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        position: relative;
      }

      /* Ligne accent élégante en haut de carte */
      .top-accent-line {
        height: 5px;
        width: 100%;
        background: linear-gradient(90deg, var(--color-primary) 0%, var(--color-primary) 80%, var(--color-secondary) 100%);
      }

      .card-inner {
        padding: 32px 32px 16px;
      }

      /* En-tête profil (Photo + Nom + Bouton Modifier) */
      .profile-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding-bottom: 28px;
        border-bottom: 1px solid var(--color-border);
        margin-bottom: 28px;
        flex-wrap: wrap;
      }

      .profile-identity {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
      }

      /* Cercle photo sobre et épuré */
      .avatar-ring {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        padding: 3px;
        background: #FFFFFF;
        border: 2px solid var(--color-border);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .avatar-ring img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        display: block;
      }

      .profile-name h1 {
        font-family: var(--font-heading);
        font-weight: 700;
        font-size: 22px;
        color: var(--color-text);
        margin: 0 0 4px;
      }

      .profile-name .role {
        font-size: 13.5px;
        color: var(--color-text-secondary);
        display: flex;
        align-items: center;
        gap: 6px;
      }

      .profile-name .role i {
        color: var(--color-primary);
        font-size: 12px;
      }

      /* Bouton Modifier les infos */
      .btn-edit {
        background: var(--color-primary-light);
        color: var(--color-primary-dark);
        border: 1px solid rgba(0, 140, 69, 0.25);
        border-radius: var(--radius-sm);
        padding: 9px 18px;
        font-family: var(--font-heading);
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
      }

      .btn-edit:hover {
        background: var(--color-primary);
        color: #FFFFFF;
        border-color: var(--color-primary);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 140, 69, 0.25);
      }

      /* ===== BANDEAU INFOS RAPIDES ===== */
      .quick-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 32px;
      }

      .quick-item {
        display: flex;
        gap: 12px;
        align-items: center;
        background: var(--color-card-bg);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-sm);
        padding: 12px 14px;
      }

      .quick-item .ic {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--color-primary-light);
        color: var(--color-primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
      }

      .quick-item .label {
        font-size: 11px;
        font-weight: 600;
        color: var(--color-text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 2px;
      }

      .quick-item .value {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--color-text);
        word-break: break-word;
      }

      /* ===== SECTIONS DU DOSSIER ===== */
      .section {
        padding-bottom: 32px;
      }

      .section-label {
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: var(--font-heading);
        font-weight: 700;
        font-size: 15px;
        color: var(--color-text);
        margin-bottom: 18px;
        padding-bottom: 8px;
        border-bottom: 1px solid #F0F0F0;
      }

      .section-label i {
        color: var(--color-primary);
        font-size: 16px;
      }

      /* ===== TIMELINE (FORMATIONS & EXPÉRIENCES) ===== */
      .timeline {
        position: relative;
        padding-left: 20px;
      }

      .timeline::before {
        content: "";
        position: absolute;
        left: 4px;
        top: 8px;
        bottom: 8px;
        width: 2px;
        background: var(--color-border);
      }

      .tl-item {
        position: relative;
        margin-bottom: 16px;
      }

      .tl-item::before {
        content: "";
        position: absolute;
        left: -20px;
        top: 6px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #FFFFFF;
        border: 2.5px solid var(--color-primary);
      }

      .tl-card {
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-sm);
        padding: 14px 16px;
        transition: all 0.2s ease;
      }

      .tl-card:hover {
        border-color: #D1D5DB;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
      }

      .tl-card .title {
        font-family: var(--font-heading);
        font-weight: 600;
        font-size: 14.5px;
        color: var(--color-text);
        margin-bottom: 3px;
      }

      .tl-card .title .sub {
        font-weight: 400;
        color: var(--color-text-secondary);
        font-size: 13px;
      }

      .tl-card .meta {
        font-size: 12px;
        color: var(--color-primary-dark);
        font-weight: 600;
        margin-bottom: 6px;
      }

      .tl-card .desc {
        font-size: 13.5px;
        color: var(--color-text);
        margin-top: 4px;
      }

      .tl-card .file-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12.5px;
        margin-top: 10px;
        color: var(--color-primary);
        background: var(--color-primary-light);
        border: 1px solid rgba(0, 140, 69, 0.25);
        border-radius: var(--radius-sm);
        padding: 5px 12px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.15s ease;
      }

      .tl-card .file-link:hover {
        background: var(--color-primary);
        color: #FFFFFF;
      }

      .empty-note {
        font-size: 13.5px;
        color: var(--color-text-secondary);
        font-style: italic;
        padding-left: 4px;
      }

      /* ===== EMPLOI & CV ===== */
      .cv-summary {
        background: var(--color-card-bg);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-sm);
        padding: 16px 18px;
        margin-bottom: 20px;
      }

      .cv-summary .lbl {
        font-family: var(--font-heading);
        font-weight: 600;
        font-size: 12px;
        color: var(--color-primary-dark);
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
      }

      .cv-summary p {
        margin: 0;
        font-size: 13.5px;
        color: var(--color-text);
        line-height: 1.6;
      }

      .job-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
      }

      .job-card {
        border: 1px solid var(--color-border);
        background: #FFFFFF;
        border-radius: var(--radius-sm);
        padding: 16px;
        transition: all 0.2s ease;
      }

      .job-card:hover {
        border-color: #D1D5DB;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
      }

      .job-card .rank {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 700;
        color: var(--color-secondary-dark);
        background: rgba(255, 193, 7, 0.15);
        border: 1px solid rgba(217, 159, 0, 0.3);
        border-radius: 12px;
        padding: 2px 10px;
        margin-bottom: 10px;
      }

      .job-card .sector {
        font-size: 12px;
        color: var(--color-text-secondary);
        margin-bottom: 4px;
      }

      .job-card .job {
        font-family: var(--font-heading);
        font-weight: 600;
        font-size: 14.5px;
        color: var(--color-text);
      }

      /* =========================================================================
         RESPONSIVE DESIGN (ADAPTATION MOBILE & TABLETTE)
         ========================================================================= */

      /* Tablettes (< 860px) */
      @media (max-width: 860px) {
        .quick-grid {
          grid-template-columns: repeat(2, 1fr);
        }
      }

      /* Smartphones (< 576px) */
      @media (max-width: 576px) {
        main.wrap {
          margin: 14px auto 40px;
          padding: 0 10px;
        }

        .card-inner {
          padding: 20px 16px 12px;
        }

        .profile-head {
          flex-direction: column;
          align-items: center;
          text-align: center;
          gap: 14px;
          padding-bottom: 20px;
          margin-bottom: 20px;
        }

        .profile-identity {
          flex-direction: column;
          align-items: center;
          gap: 12px;
        }

        .avatar-ring {
          width: 86px;
          height: 86px;
        }

        .profile-name h1 {
          font-size: 19px;
        }

        .profile-name .role {
          justify-content: center;
          font-size: 13px;
        }

        .btn-edit {
          width: 100%;
          justify-content: center;
          padding: 10px 14px;
        }

        .quick-grid {
          grid-template-columns: 1fr;
          gap: 10px;
          margin-bottom: 24px;
        }

        .job-grid {
          grid-template-columns: 1fr;
          gap: 10px;
        }

        .timeline {
          padding-left: 16px;
        }

        .tl-item::before {
          left: -16px;
        }
      }
    </style>
  </head>
  <body id="top">

    <!-- Header Utilisateur Institutionnel -->
    @include('partials.user-header')

    <!-- Notification SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        @if(session('success'))
          Swal.fire({
            icon: 'success',
            title: 'Succès !',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
          });
        @endif
      });
    </script>

    <main class="wrap">

      <!-- Barre supérieure : Numéro d'inscription -->
      <div class="top-status-bar">
        <span class="insc-chip">
          <i class="fas fa-id-card"></i> Inscription N° {{ $userdata->utilisateur->id }}
        </span>
      </div>

      <!-- Carte du Profil Candidat -->
      <div class="profile-card">
        
        <!-- Jolie ligne d'accentuation supérieure (remplace le gros bloc vert) -->
        <div class="top-accent-line"></div>

        <div class="card-inner">

          <!-- En-tête : Photo + Identité + Bouton d'édition -->
          <div class="profile-head">
            <div class="profile-identity">
              <!-- Cercle photo sobre et épuré -->
              <div class="avatar-ring">
                <img id="user-photo" src="{{ asset($userdata->photo_profil ? $userdata->photo_profil : 'images/images.png') }}" alt="Photo de profil">
              </div>
              <div class="profile-name">
                <h1>{{ $userdata->utilisateur->firstname ?? '' }} {{ $userdata->utilisateur->lastname ?? '' }}</h1>
                <div class="role">
                  <i class="fas fa-envelope"></i> {{ $userdata->utilisateur->email ?? '' }}
                </div>
              </div>
            </div>

            <!-- Bouton Modifier mes infos -->
            <a href="{{ route('userdata.edit', ['id' => $userdata->id]) }}" class="btn-edit">
              <i class="fas fa-pen-to-square"></i>
              <span>Mettre à jour mes infos</span>
            </a>
          </div>

          <!-- Bandeau des informations rapides -->
          <div class="quick-grid">
            <div class="quick-item">
              <div class="ic"><i class="fas fa-calendar-alt"></i></div>
              <div>
                <div class="label">Date de naissance</div>
                <div class="value">{{ $userdata->datenaiss ?? 'Non renseignée' }}</div>
              </div>
            </div>
            <div class="quick-item">
              <div class="ic"><i class="fas fa-envelope"></i></div>
              <div>
                <div class="label">Email</div>
                <div class="value">{{ $userdata->utilisateur->email }}</div>
              </div>
            </div>
            <div class="quick-item">
              <div class="ic"><i class="fas fa-phone"></i></div>
              <div>
                <div class="label">Téléphone</div>
                <div class="value">{{ $userdata->telephone1 ?? 'Non renseigné' }}</div>
              </div>
            </div>
            <div class="quick-item">
              <div class="ic"><i class="fas fa-map-marker-alt"></i></div>
              <div>
                <div class="label">Résidence</div>
                <div class="value">{{ $userdata->lieuresidence ?? 'Sénégal' }}</div>
              </div>
            </div>
          </div>

          <!-- Section 1 : Formations et Diplômes -->
          <div class="section">
            <div class="section-label">
              <i class="fas fa-graduation-cap"></i>
              <span>Formations & Diplômes</span>
            </div>

            @php
              $formationsList = [];
              if (!empty($userdata->autresdiplomes)) {
                  $decodedForm = is_array($userdata->autresdiplomes)
                      ? $userdata->autresdiplomes
                      : json_decode($userdata->autresdiplomes, true);
                  if (is_array($decodedForm)) {
                      $formationsList = $decodedForm;
                  }
              }
              $academicMap = \App\Models\Academic::pluck('libelle', 'id')->toArray();
            @endphp

            <div class="timeline">
              @if(!empty($formationsList))
                @foreach($formationsList as $i => $form)
                  @php
                    $aid = $form['academic_id'] ?? null;
                    $levelName = ($aid === 'sansdiplome' || $aid === '20') ? 'Sans diplôme' : ($academicMap[$aid] ?? ($userdata->academic->libelle ?? 'Non renseigné'));
                    $fileForThisForm = $form['diplome_file'] ?? null;
                  @endphp
                  <div class="tl-item">
                    <div class="tl-card">
                      <div class="title">
                        {{ $levelName }}
                        @if(!empty($form['etablissementdiplome']))
                          <span class="sub">à {{ $form['etablissementdiplome'] }}</span>
                        @endif
                      </div>
                      @if(!empty($form['anneediplome']))
                        <div class="meta"><i class="far fa-calendar-check"></i> {{ $form['anneediplome'] }}</div>
                      @endif
                      @if(!empty($form['diplome']))
                        <div class="desc"><strong>Intitulé :</strong> {{ $form['diplome'] }}</div>
                      @endif
                      @if(!empty($form['specialite']))
                        <div class="desc"><strong>Spécialité :</strong> {{ $form['specialite'] }}</div>
                      @endif
                      @if($fileForThisForm)
                        <div>
                          <a href="{{ asset($fileForThisForm) }}" target="_blank" class="file-link">
                            <i class="fas fa-file-pdf"></i> {{ basename($fileForThisForm) }}
                          </a>
                        </div>
                      @endif
                    </div>
                  </div>
                @endforeach

              @elseif(!empty($userdata->academic_id) || !empty($userdata->diplome))
                <div class="tl-item">
                  <div class="tl-card">
                    <div class="title">
                      {{ $userdata->academic->libelle ?? 'Non renseigné' }}
                      @if(!empty($userdata->etablissementdiplome))
                        <span class="sub">à {{ $userdata->etablissementdiplome }}</span>
                      @endif
                    </div>
                    @if(!empty($userdata->anneediplome))
                      <div class="meta"><i class="far fa-calendar-check"></i> {{ $userdata->anneediplome }}</div>
                    @endif
                    @if(!empty($userdata->diplome))
                      <div class="desc"><strong>Intitulé :</strong> {{ $userdata->diplome }}</div>
                    @endif
                    @if(!empty($userdata->specialite))
                      <div class="desc"><strong>Spécialité :</strong> {{ $userdata->specialite }}</div>
                    @endif
                  </div>
                </div>
              @else
                <p class="empty-note">Aucune formation renseignée.</p>
              @endif
            </div>
          </div>

          <!-- Section 2 : Expérience professionnelle -->
          <div class="section">
            <div class="section-label">
              <i class="fas fa-briefcase"></i>
              <span>Expérience professionnelle</span>
            </div>

            @php
              $experiencesList = [];
              if (!empty($userdata->experiences)) {
                  $decoded = is_array($userdata->experiences)
                      ? $userdata->experiences
                      : json_decode($userdata->experiences, true);
                  if (is_array($decoded)) {
                      $experiencesList = $decoded;
                  }
              }
            @endphp

            <div class="timeline">
              @if(!empty($experiencesList))
                @foreach($experiencesList as $exp)
                  <div class="tl-item">
                    <div class="tl-card">
                      <div class="title">
                        {{ $exp['poste'] ?? $userdata->posteoccupe }}
                        @if(!empty($exp['employeur']))
                          <span class="sub">à {{ $exp['employeur'] }}</span>
                        @endif
                      </div>
                      @if(!empty($exp['years']))
                        <div class="meta"><i class="far fa-clock"></i> {{ $exp['years'] }} an(s) d'expérience</div>
                      @endif
                      @if(!empty($exp['description']))
                        <div class="desc">{{ $exp['description'] }}</div>
                      @endif
                    </div>
                  </div>
                @endforeach
              @elseif(!empty($userdata->posteoccupe) || !empty($userdata->employeur))
                <div class="tl-item">
                  <div class="tl-card">
                    <div class="title">
                      {{ $userdata->posteoccupe }}
                      @if(!empty($userdata->employeur))
                        <span class="sub">à {{ $userdata->employeur }}</span>
                      @endif
                    </div>
                    @if(!empty($userdata->nombreanneeexpe))
                      <div class="meta"><i class="far fa-clock"></i> {{ $userdata->nombreanneeexpe }} an(s) d'expérience</div>
                    @endif
                  </div>
                </div>
              @else
                <p class="empty-note">Aucune expérience professionnelle renseignée.</p>
              @endif
            </div>
          </div>

          <!-- Section 3 : Emplois souhaités & Résumé CV -->
          <div class="section" style="padding-bottom:12px;">
            <div class="section-label">
              <i class="fas fa-bullseye"></i>
              <span>Emplois ciblés & Profil</span>
            </div>

            @if(!empty($userdata->cv_summary))
              <div class="cv-summary">
                <div class="lbl"><i class="fas fa-align-left"></i> Résumé de votre profil</div>
                <p>{{ $userdata->cv_summary }}</p>
              </div>
            @endif

            <div class="job-grid">
              <div class="job-card">
                <span class="rank"><i class="fas fa-star"></i> 1er choix</span>
                <div class="sector">{{ $userdata->emploi1->secteur->libelle ?? 'Secteur non renseigné' }}</div>
                <div class="job">{{ $userdata->emploi1->libelle ?? 'Métier non renseigné' }}</div>
              </div>
              <div class="job-card">
                <span class="rank"><i class="fas fa-star-half-stroke"></i> 2e choix</span>
                <div class="sector">{{ $userdata->emploi2->secteur->libelle ?? 'Secteur non renseigné' }}</div>
                <div class="job">{{ $userdata->emploi2->libelle ?? 'Métier non renseigné' }}</div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </main>

    <footer class="pt-4 pb-4 text-muted text-center d-print-none"></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>