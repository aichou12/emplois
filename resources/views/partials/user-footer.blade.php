<footer class="pgde-user-footer">
    <!-- Ligne tricolore, en écho à celle du header -->
    <div class="pgde-user-footer__tricolor" aria-hidden="true"></div>

    <div class="pgde-user-footer__container">
        <div class="pgde-user-footer__identity">
            <img src="{{ asset('images/logo_from_site_mfp.png') }}" alt="" class="pgde-user-footer__logo">
            <div>
                <p class="pgde-user-footer__name">Plateforme de Gestion des Demandes d'Emploi</p>
                <p class="pgde-user-footer__ministry">Ministère de la Fonction Publique, du Travail et de la Réforme du Service public</p>
            </div>
        </div>

        <nav class="pgde-user-footer__links" aria-label="Liens institutionnels">
            <a href="https://www.fonctionpublique.gouv.sn/" target="_blank" rel="noopener noreferrer">Ministère de la Fonction publique</a>
            <a href="https://presidence.sn" target="_blank" rel="noopener noreferrer">Présidence de la République</a>
            <a href="https://primature.sn/" target="_blank" rel="noopener noreferrer">Gouvernement du Sénégal</a>
        </nav>
    </div>

    <div class="pgde-user-footer__bottom">
        <p class="pgde-user-footer__copy">© {{ date('Y') }} République du Sénégal — Ministère de la Fonction Publique, du Travail et de la Réforme du Service public. Tous droits réservés.</p>
    </div>
</footer>

<style>
    .pgde-user-footer {
        width: 100%;
        margin-top: auto;
        background: #ffffff;
        color: #33443a;
        font: 13px/1.5 'DM Sans', Arial, sans-serif;
        border-top: 1px solid #e5e7eb;
    }

    .pgde-user-footer__tricolor {
        height: 4px;
        background: linear-gradient(90deg, #008C45 0 33.33%, #FDEF42 33.33% 66.66%, #E31B23 66.66% 100%);
    }

    /* Même largeur et mêmes marges que le header */
    .pgde-user-footer__container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px 32px;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px clamp(14px, 2vw, 20px);
    }

    .pgde-user-footer__identity {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .pgde-user-footer__logo {
        width: auto;
        height: 42px;
        flex-shrink: 0;
    }

    .pgde-user-footer__name {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
        font-weight: 700;
        color: #008C45;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    .pgde-user-footer__ministry {
        margin: 2px 0 0;
        font-size: 12px;
        color: #5b6b62;
    }

    .pgde-user-footer__links {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 22px;
    }

    .pgde-user-footer__links a {
        color: #33443a;
        font-weight: 600;
        text-decoration: none;
        transition: color .15s ease;
    }

    .pgde-user-footer__links a:hover,
    .pgde-user-footer__links a:focus-visible {
        color: #008C45;
        text-decoration: underline;
        text-underline-offset: 3px;
    }

    .pgde-user-footer__bottom {
        background: #f2f2f2;
    }

    .pgde-user-footer__copy {
        max-width: 1200px;
        margin: 0 auto;
        padding: 10px clamp(14px, 2vw, 20px);
        color: #5b6b62;
        font-size: 11.5px;
    }

    @media (max-width: 680px) {
        .pgde-user-footer__container { flex-direction: column; align-items: flex-start; }
        .pgde-user-footer__links { flex-direction: column; gap: 6px; }
        .pgde-user-footer__logo { height: 36px; }
    }

    @media print {
        .pgde-user-footer { display: none !important; }
    }
</style>
