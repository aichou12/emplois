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

              <!-- Application mobile : les QR codes pointent vers /app/android et /app/ios -->
              <div class="login-app">
                  <div class="login-app-head">
                      <h3><i class="fas fa-mobile-screen-button" aria-hidden="true"></i> Application mobile</h3>
                      <span class="soon-badge">Bientôt</span>
                  </div>
                  <p>Bientôt disponible sur Play Store et App Store. Scannez le QR code de votre téléphone.</p>
                  <div class="login-app-stores">
                      <a href="{{ route('mobile.app', 'android') }}" class="app-store" title="Application Android — Play Store">
                          <span class="app-qr" data-qr="{{ route('mobile.app', 'android') }}" role="img" aria-label="QR code Play Store"></span>
                          <span class="app-store-label"><i class="fab fa-google-play" aria-hidden="true"></i> Play Store</span>
                      </a>
                      <a href="{{ route('mobile.app', 'ios') }}" class="app-store" title="Application iPhone — App Store">
                          <span class="app-qr" data-qr="{{ route('mobile.app', 'ios') }}" role="img" aria-label="QR code App Store"></span>
                          <span class="app-store-label"><i class="fab fa-apple" aria-hidden="true"></i> App Store</span>
                      </a>
                  </div>
              </div>
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
            gap: 12px;
        }

        .app-store {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding: 12px 10px 10px;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            background: var(--color-white);
            color: var(--color-text);
            text-decoration: none;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .app-store:hover,
        .app-store:focus-visible {
            border-color: #cfd6d1;
            box-shadow: 0 4px 12px rgba(20, 30, 24, .08);
        }

        .app-qr {
            width: 80px;
            height: 80px;
        }

        .app-qr img,
        .app-qr canvas {
            display: block;
            width: 100%;
            height: 100%;
        }

        .app-store-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            font-weight: 600;
        }

        .app-store-label .fa-google-play { color: #01875F; }
        .app-store-label .fa-apple { color: #1D1D1B; font-size: 14px; }

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
            /* Sur téléphone on ne scanne pas son propre écran : QR masqués */
            .app-qr { display: none; }
            .app-store { flex-direction: row; justify-content: center; padding: 10px; }
        }

        @media (max-width: 360px) {
            .login-video-card { padding: 14px; }
        }
</style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        // QR codes de l'application mobile
        document.querySelectorAll('.app-qr[data-qr]').forEach(qrBox => {
            if (typeof QRCode === 'undefined') return;
            new QRCode(qrBox, {
                text: qrBox.dataset.qr,
                width: 184,
                height: 184,
                colorDark: '#1D1D1B',
                colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.M,
            });
            qrBox.removeAttribute('title');
        });
    </script>
