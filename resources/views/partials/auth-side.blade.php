{{-- Colonne d'accompagnement des pages d'authentification : parcours + application mobile.
     Variable optionnelle : $authSideStep (1, 2 ou 3) pour surligner l'étape en cours. --}}
          <aside class="login-video-card" aria-labelledby="login-journey-title">
              <div class="login-journey">
                  <h2 id="login-journey-title" class="login-journey-title">Votre parcours en bref</h2>
                  <p class="login-journey-intro">Trois étapes pour déposer votre demande.</p>
                  <ol class="login-journey-list">
                      <li class="login-journey-step @if (($authSideStep ?? null) === 1) is-current @endif" @if (($authSideStep ?? null) === 1) aria-current="step" @endif>
                          <span class="journey-icon" aria-hidden="true"><i class="fas fa-user-plus"></i></span>
                          <span class="journey-text"><strong>Créez votre compte</strong><span>Activation par e-mail</span></span>
                      </li>
                      <li class="login-journey-step">
                          <span class="journey-icon" aria-hidden="true"><i class="fas fa-pen-to-square"></i></span>
                          <span class="journey-text"><strong>Renseignez votre profil</strong><span>Formations, expériences, emplois visés</span></span>
                      </li>
                      <li class="login-journey-step">
                          <span class="journey-icon" aria-hidden="true"><i class="fas fa-clipboard-check"></i></span>
                          <span class="journey-text"><strong>Vérifiez votre dossier</strong><span>Modifiable à tout moment</span></span>
                      </li>
                  </ol>
              </div>

              <!-- Application mobile : badges des stores (pages /app/android et /app/ios) -->
              <div class="login-app">
                  <div class="login-app-head">
                      <h3><i class="fas fa-mobile-screen-button" aria-hidden="true"></i> Application mobile</h3>
                      <span class="soon-badge">Bientôt</span>
                  </div>
                  <p>Bientôt disponible sur Play Store et App Store.</p>
                  <div class="login-app-stores">
                      <a href="{{ route('mobile.app', 'android') }}" class="store-badge" title="Application Android — Google Play">
                          <i class="fab fa-google-play" aria-hidden="true"></i>
                          <span><small>Bientôt sur</small>Google Play</span>
                      </a>
                      <a href="{{ route('mobile.app', 'ios') }}" class="store-badge" title="Application iPhone — App Store">
                          <i class="fab fa-apple" aria-hidden="true"></i>
                          <span><small>Bientôt sur</small>App Store</span>
                      </a>
                  </div>
              </div>

              <!-- Lien vers le guide : comment créer son compte et se connecter -->
              <a href="{{ route('guide') }}#etapes" class="login-guide-link">
                  <i class="fas fa-book-open" aria-hidden="true"></i>
                  <span><strong>Comment se connecter ?</strong> Consultez le guide du candidat</span>
                  <i class="fas fa-arrow-right login-guide-arrow" aria-hidden="true"></i>
              </a>
          </aside>

<style>
        /* Colonne droite : parcours en haut, application mobile tout en bas */
        .login-video-card {
            min-width: 0;
            align-self: stretch;
            display: flex;
            flex-direction: column;
            gap: 16px;
            padding: 24px 24px;
            background: var(--color-white);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
        }

        .login-journey-title {
            margin: 0 0 4px;
            color: var(--color-text);
            font-family: var(--font-heading);
            font-size: 17px;
            font-weight: 600;
        }

        .login-journey-intro {
            margin: 0 0 18px;
            color: var(--color-text-secondary);
            font-size: 13px;
        }

        /* Timeline horizontale : 3 colonnes, tuile en haut, pointillés entre les tuiles */
        .login-journey-list {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .login-journey-step {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            text-align: center;
        }

        .login-journey-step:not(:last-child)::after {
            content: "";
            position: absolute;
            top: 21px;
            left: calc(50% + 30px);
            right: calc(-50% + 25px);
            border-top: 2px dashed #cfe5d8;
        }

        /* Tuiles d'icône vertes (charte) */
        .journey-icon {
            position: relative;
            z-index: 1;
            display: grid;
            place-items: center;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #EBF7F0;
            color: var(--color-primary);
            font-size: 17px;
            transition: background .15s ease, color .15s ease, transform .15s ease;
        }

        .login-journey-step:hover .journey-icon {
            background: var(--color-primary);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .journey-text { display: flex; flex-direction: column; gap: 2px; min-width: 0; }

        .journey-text strong {
            color: var(--color-text);
            font-family: var(--font-heading);
            font-size: 13px;
            font-weight: 600;
            line-height: 1.3;
        }

        .journey-text span {
            color: var(--color-text-secondary);
            font-size: 12px;
            line-height: 1.4;
        }

        /* ===== Application mobile (bientôt disponible) ===== */
        .login-app {
            margin-top: auto;
            padding: 18px;
            border-radius: var(--radius-md);
            background: #F6F8F7;
            border: 1px solid #e8ece9;
        }

        .login-app-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 4px;
        }

        .login-app-head h3 {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            font-family: var(--font-heading);
            font-size: 14px;
            font-weight: 600;
        }

        .login-app-head h3 i { color: var(--color-primary); }

        .soon-badge {
            flex-shrink: 0;
            padding: 3px 9px;
            border-radius: 999px;
            background: #FFF6D6;
            color: #8A6300;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .login-app > p {
            margin: 0 0 14px;
            color: var(--color-text-secondary);
            font-size: 12.5px;
        }

        .login-app-stores {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        /* Badges façon stores : fond foncé, logo + nom du store */
        .store-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 48px;
            padding: 6px 12px;
            border-radius: 10px;
            background: #282B2D;
            color: #ffffff;
            text-decoration: none;
            transition: background .15s ease, transform .12s ease;
        }

        .store-badge:hover,
        .store-badge:focus-visible { background: #000000; color: #ffffff; }
        .store-badge:active { transform: translateY(1px); }
        .store-badge:focus-visible { outline: 3px solid rgba(0, 132, 63, .35); outline-offset: 2px; }

        .store-badge i { flex-shrink: 0; font-size: 22px; }

        .store-badge span {
            display: flex;
            flex-direction: column;
            font-family: var(--font-heading);
            font-size: 14px;
            font-weight: 600;
            line-height: 1.15;
            white-space: nowrap;
        }

        .store-badge small {
            font-family: var(--font-body);
            font-size: 10.5px;
            font-weight: 500;
            opacity: .8;
        }

        /* Lien vers le guide du candidat, en bas de la colonne */
        .login-guide-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            color: var(--color-text);
            font-size: 13px;
            text-decoration: none;
            transition: border-color .15s ease, background .15s ease;
        }

        .login-guide-link > i:first-child { color: var(--color-primary); font-size: 15px; }
        .login-guide-link strong { color: var(--color-primary-dark); font-weight: 600; }
        .login-guide-arrow { margin-left: auto; color: var(--color-text-secondary); font-size: 12px; transition: transform .15s ease; }
        .login-guide-link:hover { border-color: var(--color-primary); background: #F7FAF8; }
        .login-guide-link:hover .login-guide-arrow { transform: translateX(3px); color: var(--color-primary); }
        .login-guide-link:focus-visible { outline: 3px solid rgba(0, 132, 63, .35); outline-offset: 2px; }

        /* Étape en cours (ex. page d'inscription) */
        .login-journey-step.is-current .journey-icon {
            background: var(--color-primary);
            color: #ffffff;
            box-shadow: 0 0 0 4px #EBF7F0;
        }

        .login-journey-step.is-current .journey-text strong { color: var(--color-primary-dark); }

        @media (max-width: 992px) {
            .login-video-card {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .login-video-card {
                gap: 16px;
                padding: 16px;
                border-radius: var(--radius-md);
            }

            .login-journey-title { font-size: 16px; }
            .journey-icon { width: 38px; height: 38px; font-size: 15px; border-radius: 10px; }
            .login-journey-step:not(:last-child)::after { top: 18px; left: calc(50% + 26px); right: calc(-50% + 22px); }
            .journey-text strong { font-size: 12px; }
            .journey-text span { font-size: 11px; }
            .store-badge { min-height: 44px; gap: 8px; }
            .store-badge i { font-size: 19px; }
            .store-badge span { font-size: 13px; }
        }

        @media (max-width: 360px) {
            .login-video-card { padding: 14px; }
        }
</style>
