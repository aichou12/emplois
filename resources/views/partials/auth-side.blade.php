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
                  <p>Bientôt disponible sur Android et iOS.</p>
                  <div class="login-app-stores">
                      <a href="{{ route('mobile.app', 'android') }}" class="store-badge is-android" title="Application Android — Google Play">
                          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18.4395 5.5586c-.675 1.1664-1.352 2.3318-2.0274 3.498-.0366-.0155-.0742-.0286-.1113-.043-1.8249-.6957-3.484-.8-4.42-.787-1.8551.0185-3.3544.4643-4.2597.8203-.084-.1494-1.7526-3.021-2.0215-3.4864a1.1451 1.1451 0 0 0-.1406-.1914c-.3312-.364-.9054-.4859-1.379-.203-.475.282-.7136.9361-.3886 1.5019 1.9466 3.3696-.0966-.2158 1.9473 3.3593.0172.031-.4946.2642-1.3926 1.0177C2.8987 12.176.452 14.772 0 18.9902h24c-.119-1.1108-.3686-2.099-.7461-3.0683-.7438-1.9118-1.8435-3.2928-2.7402-4.1836a12.1048 12.1048 0 0 0-2.1309-1.6875c.6594-1.122 1.312-2.2559 1.9649-3.3848.2077-.3615.1886-.7956-.0079-1.1191a1.1001 1.1001 0 0 0-.8515-.5332c-.5225-.0536-.9392.3128-1.0488.5449zm-.0391 8.461c.3944.5926.324 1.3306-.1563 1.6503-.4799.3197-1.188.0985-1.582-.4941-.3944-.5927-.324-1.3307.1563-1.6504.4727-.315 1.1812-.1086 1.582.4941zM7.207 13.5273c.4803.3197.5506 1.0577.1563 1.6504-.394.5926-1.1038.8138-1.584.4941-.48-.3197-.5503-1.0577-.1563-1.6504.4008-.6021 1.1087-.8106 1.584-.4941z"/></svg>
                          <span><small>Bientôt sur</small>Android</span>
                      </a>
                      <a href="{{ route('mobile.app', 'ios') }}" class="store-badge is-ios" title="Application iPhone — App Store">
                          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12.152 6.896c-.948 0-2.415-1.078-3.96-1.04-2.04.027-3.91 1.183-4.961 3.014-2.117 3.675-.546 9.103 1.519 12.09 1.013 1.454 2.208 3.09 3.792 3.039 1.52-.065 2.09-.987 3.935-.987 1.831 0 2.35.987 3.96.948 1.637-.026 2.676-1.48 3.676-2.948 1.156-1.688 1.636-3.325 1.662-3.415-.039-.013-3.182-1.221-3.22-4.857-.026-3.04 2.48-4.494 2.597-4.559-1.429-2.09-3.623-2.324-4.39-2.376-2-.156-3.675 1.09-4.61 1.09zM15.53 3.83c.843-1.012 1.4-2.427 1.245-3.83-1.207.052-2.662.805-3.532 1.818-.78.896-1.454 2.338-1.273 3.714 1.338.104 2.715-.688 3.559-1.701"/></svg>
                          <span><small>Bientôt sur</small>iOS</span>
                      </a>
                  </div>
              </div>

              <!-- Lien vers le guide : comment créer son compte et se connecter -->
              <a href="{{ route('guide') }}#etapes" class="login-guide-link">
                  <i class="fas fa-book-open" aria-hidden="true"></i>
                  <span><strong>Comment se connecter ?</strong> </span>
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

        /* Badges clairs : fond blanc, logo officiel dans sa couleur de marque */
        .store-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-height: 50px;
            padding: 6px 12px;
            border: 1px solid var(--color-border);
            border-radius: 10px;
            background: #ffffff;
            color: var(--color-text);
            text-decoration: none;
            transition: border-color .15s ease, box-shadow .15s ease, transform .12s ease;
        }

        .store-badge:hover,
        .store-badge:focus-visible {
            border-color: #cfd6d1;
            box-shadow: 0 4px 12px rgba(40, 43, 45, .08);
            color: var(--color-text);
        }

        .store-badge:active { transform: translateY(1px); }
        .store-badge:focus-visible { outline: 3px solid rgba(0, 132, 63, .35); outline-offset: 2px; }

        .store-badge svg { flex-shrink: 0; width: 24px; height: 24px; }
        .store-badge.is-android svg { fill: #3DDC84; }   /* vert officiel Android */
        .store-badge.is-ios svg { fill: #000000; }        /* noir officiel Apple */

        .store-badge span {
            display: flex;
            flex-direction: column;
            font-family: var(--font-heading);
            font-size: 15px;
            font-weight: 600;
            line-height: 1.15;
            white-space: nowrap;
        }

        .store-badge small {
            color: var(--color-text-secondary);
            font-family: var(--font-body);
            font-size: 10.5px;
            font-weight: 500;
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
            .store-badge svg { width: 21px; height: 21px; }
            .store-badge span { font-size: 13px; }
        }

        @media (max-width: 360px) {
            .login-video-card { padding: 14px; }
        }
</style>
