<footer class="pgde-user-footer">
    <div class="pgde-user-footer__container">
        <nav class="pgde-user-footer__links" aria-label="Liens institutionnels">
            <a href="https://www.fonctionpublique.gouv.sn/" target="_blank" rel="noopener noreferrer">Ministère de la Fonction publique</a>
            <span aria-hidden="true">|</span>
            <a href="https://presidence.sn" target="_blank" rel="noopener noreferrer">Le Président de la République</a>
            <span aria-hidden="true">|</span>
            <a href="https://primature.sn/" target="_blank" rel="noopener noreferrer">Gouvernement du Sénégal</a>
        </nav>
        <p class="pgde-user-footer__copy">© {{ date('Y') }} Ministère de la Fonction Publique, du Travail et de la Réforme du Service Public — Tous droits réservés.</p>
    </div>
</footer>

<style>
    .pgde-user-footer { width:100%; margin-top:auto; padding:18px 20px; border-top:1px solid #e5e5e5; background:#ECEEEC; color:#575A7B; text-align:center; font:12.5px/1.5 'DM Sans',Arial,sans-serif; }
    .pgde-user-footer__container { width:min(100%,1200px); margin:0 auto; }
    .pgde-user-footer__links { display:flex; flex-wrap:wrap; justify-content:center; gap:8px 12px; margin-bottom:6px; }
    .pgde-user-footer__links a { color:#008C45; font-weight:500; text-decoration:none; transition:color .15s ease; }
    .pgde-user-footer__links a:hover, .pgde-user-footer__links a:focus { color:#006B35; text-decoration:underline; }
    .pgde-user-footer__copy { margin:0; color:#64748B; font-size:11.5px; }
    @media (max-width:576px) {
        .pgde-user-footer { padding:15px 14px; }
        .pgde-user-footer__links { flex-direction:column; gap:5px; }
        .pgde-user-footer__links span { display:none; }
    }
</style>
