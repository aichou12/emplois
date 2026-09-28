<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <title>Réinitialisation du mot de passe PGDE</title>
</head>
<body style="margin:0; padding:0; background-color:#f1f5f2; font-family:Arial,Helvetica,sans-serif; color:#26352c;">
    <div style="display:none; max-height:0; overflow:hidden; opacity:0; color:transparent;">Réinitialisez votre mot de passe PGDE à l’aide du lien sécurisé.</div>
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#f1f5f2;">
        <tr>
            <td align="center" style="padding:32px 14px;">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:620px; background-color:#ffffff; border:1px solid #e3e9e4; border-radius:14px; overflow:hidden;">
                    <tr>
                        <td align="center" style="padding:14px 24px 12px; background-color:#075c36;">
                            <img src="cid:logo-pgde@pgde" width="50" height="50" alt="Logo PGDE" style="display:block; width:50px; height:50px; margin:0 auto 6px; object-fit:contain;">
                            <p style="margin:0; color:#ffffff; font-size:11px; line-height:1.35; letter-spacing:1.2px; font-weight:bold;">PLATEFORME PGDE</p>
                            <p style="margin:2px 0 0; color:#d8eee1; font-size:11px; line-height:1.35;">Gestion des demandes d’emploi</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:34px 36px 28px;">
                            <p style="margin:0 0 8px; color:#008c45; font-size:13px; font-weight:bold; letter-spacing:.5px;">SÉCURITÉ DU COMPTE</p>
                            <h1 style="margin:0 0 18px; color:#202923; font-size:25px; line-height:1.3;">Réinitialisez votre mot de passe</h1>
                            <p style="margin:0 0 14px; color:#4b5b50; font-size:15px; line-height:1.7;">Bonjour,</p>
                            <p style="margin:0 0 24px; color:#4b5b50; font-size:15px; line-height:1.7;">Nous avons reçu une demande de réinitialisation du mot de passe associé à votre compte PGDE. Cliquez sur le bouton ci-dessous pour choisir un nouveau mot de passe.</p>
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin:0 auto 24px;">
                                <tr>
                                    <td align="center" bgcolor="#008c45" style="border-radius:7px;">
                                        <a href="{{ $resetUrl }}" target="_blank" style="display:inline-block; padding:14px 25px; border:1px solid #008c45; border-radius:7px; color:#ffffff; font-size:14px; line-height:1.2; font-weight:bold; text-decoration:none;">Choisir un nouveau mot de passe</a>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin:0 0 8px; color:#5c6a61; font-size:13px; line-height:1.6;">Ce lien est valable pendant <strong>15 minutes</strong> et ne peut être utilisé qu’une seule fois.</p>
                            <p style="margin:0 0 8px; color:#5c6a61; font-size:13px; line-height:1.6;">Si le bouton ne fonctionne pas, copiez ce lien dans votre navigateur :</p>
                            <p style="margin:0 0 24px; overflow-wrap:anywhere; font-size:12px; line-height:1.6;"><a href="{{ $resetUrl }}" style="color:#087640;">{{ $resetUrl }}</a></p>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td style="padding:15px 16px; border-left:3px solid #e2ad18; background-color:#fff9e8; color:#64552c; font-size:12px; line-height:1.6;">Si vous n’êtes pas à l’origine de cette demande, ignorez ce message. Votre mot de passe restera inchangé. Ne partagez ce lien avec personne.</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:19px 24px; border-top:1px solid #e8eee9; background-color:#fafcfb;">
                            <img src="cid:logo-mfp@pgde" width="42" height="42" alt="Ministère de la Fonction Publique" style="display:block; width:42px; height:42px; margin:0 auto 8px; object-fit:contain;">
                            <p style="margin:0; color:#607067; font-size:11px; line-height:1.6;">Ministère de la Fonction Publique, du Travail<br>et de la Réforme du Service Public</p>
                            <p style="margin:8px 0 0; color:#849087; font-size:10px; line-height:1.5;">Cet e-mail automatique concerne la sécurité de votre compte PGDE.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
