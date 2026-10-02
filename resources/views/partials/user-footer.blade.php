<footer class="pgde-user-footer">
    <p class="pgde-user-footer__copy">© {{ date('Y') }} MFPTRSP — DSI. Tous droits réservés.</p>
</footer>

<style>
    .pgde-user-footer,
    .pgde-user-footer * { box-sizing: border-box; }

    .pgde-user-footer {
        width: 100%;
        margin-top: auto;
        background: #f2f2f2;
        border-top: 1px solid #e5e7eb;
        font: 13px/1.5 'DM Sans', Arial, sans-serif;
    }

    /* Même largeur et mêmes marges que le header */
    .pgde-user-footer__copy {
        max-width: 1200px;
        margin: 0 auto;
        padding: 10px clamp(14px, 2vw, 20px);
        color: #6c757d;
        font-size: 12px;
        text-align: center;
    }

    @media print {
        .pgde-user-footer { display: none !important; }
    }
</style>
