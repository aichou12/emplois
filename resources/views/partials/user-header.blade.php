@php
  $headerUser = $utilisateurConnecte ?? ($userdata->utilisateur ?? auth()->user());
@endphp

<header class="resume-header d-print-none">
  <div class="container-fluid px-3 px-lg-5">
    <div class="resume-header__inner">
      <div class="resume-header__institution">
        <img src="{{ asset('images/dss.png') }}" alt="Sceau de la République du Sénégal" class="resume-header__seal">
        <div>
          <div class="resume-header__country">République du Sénégal</div>
          <div class="resume-header__motto">Un peuple, un but, une foi</div>
        </div>
      </div>

      <div class="resume-header__title">
        <div class="resume-header__eyebrow">Espace candidat</div>
        <div>Plateforme de gestion des demandes d'emploi</div>
      </div>

      <div class="resume-header__account">
        <img src="{{ asset('images/mfp.png') }}" alt="Ministère de la Fonction publique" class="resume-header__ministry">
        @if($headerUser)
          <div class="dropdown">
            <button class="resume-header__user dropdown-toggle" type="button" id="userHeaderMenu" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user-circle me-2"></i>
              <span>{{ $headerUser->firstname }} {{ $headerUser->lastname }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userHeaderMenu">
              <li><a href="{{ route('password.edit') }}" class="dropdown-item"><i class="fas fa-key me-2"></i>Modifier le mot de passe</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a href="{{ route('logout') }}" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</a></li>
            </ul>
          </div>
        @endif
      </div>
    </div>
  </div>
</header>

<style>
  :root {
    --color-primary: #008c45;
    --color-primary-dark: #006b35;
    --color-secondary: #ffc107;
    --color-text: #1d1d1b;
    --color-text-secondary: #575a7b;
    --color-white: #ffffff;
    --color-border: #e5e5e5;
    --radius-sm: 4px;
  }

  .resume-header {
    background: var(--color-white);
    border-bottom: 1px solid var(--color-border);
    box-shadow: 0 3px 14px rgba(0, 140, 69, 0.12);
  }

  .resume-header__inner {
    min-height: 106px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
  }

  .resume-header__institution,
  .resume-header__account {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 0;
  }

  .resume-header__institution {
    flex: 1 1 28%;
  }

  .resume-header__account {
    flex: 1 1 28%;
    justify-content: flex-end;
  }

  .resume-header__seal {
    width: 52px;
    height: 52px;
    object-fit: contain;
  }

  .resume-header__ministry {
    width: 74px;
    height: 64px;
    object-fit: contain;
  }

  .resume-header__country,
  .resume-header__title {
    color: var(--color-text);
    font-weight: 700;
  }

  .resume-header__country {
    font-size: 0.95rem;
  }

  .resume-header__motto,
  .resume-header__eyebrow {
    color: var(--color-text-secondary);
    font-size: 0.72rem;
    letter-spacing: 0.04em;
  }

  .resume-header__title {
    flex: 1 1 44%;
    text-align: center;
    font-size: clamp(1rem, 1.8vw, 1.45rem);
    overflow-wrap: anywhere;
  }

  .resume-header__eyebrow {
    color: var(--color-primary);
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 4px;
  }

  .resume-header__user {
    display: flex;
    align-items: center;
    max-width: min(220px, 100%);
    min-width: 0;
    width: 100%;
    border: 1px solid var(--color-primary-dark);
    border-radius: var(--radius-sm);
    background: var(--color-primary);
    color: var(--color-white);
    padding: 9px 12px;
    font-weight: 500;
    text-align: left;
    white-space: normal;
    transition: background-color 0.2s ease, border-color 0.2s ease;
  }

  .resume-header__user:hover,
  .resume-header__user:focus {
    background: var(--color-primary-dark);
    border-color: var(--color-primary-dark);
    color: var(--color-white);
    box-shadow: 0 0 0 0.2rem rgba(0, 140, 69, 0.2);
  }

  .resume-header .dropdown-menu {
    border-color: var(--color-border);
  }

  .resume-header .dropdown-item:hover,
  .resume-header .dropdown-item:focus,
  .resume-header .dropdown-item:active {
    background: rgba(0, 140, 69, 0.12);
    color: var(--color-primary-dark);
  }

  .resume-header__user span {
    min-width: 0;
    overflow-wrap: anywhere;
    word-break: break-word;
  }

  @media (max-width: 991.98px) {
    .resume-header__inner {
      min-height: 0;
      padding: 14px 0 16px;
      flex-wrap: wrap;
      justify-content: center;
    }

    .resume-header__institution,
    .resume-header__account {
      flex: 1 1 48%;
    }

    .resume-header__account {
      justify-content: flex-end;
    }

    .resume-header__title {
      order: 3;
      flex-basis: 100%;
    }

    .resume-header__ministry {
      display: none;
    }
  }

  @media (max-width: 575.98px) {
    .resume-header__inner {
      display: grid;
      grid-template-columns: 1fr;
      gap: 12px;
      text-align: center;
    }

    .resume-header__institution,
    .resume-header__account {
      width: 100%;
      justify-content: center;
    }

    .resume-header__institution { order: 1; }
    .resume-header__title {
      order: 2;
      width: 100%;
      line-height: 1.35;
    }
    .resume-header__account { order: 3; }
    .resume-header__user { width: 100%; }
  }
</style>
