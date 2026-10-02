<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <title>{{ $campaignSubject }}</title>
</head>
<body style="margin:0;padding:0;background-color:#f1f5f2;font-family:Arial,Helvetica,sans-serif;color:#26352c;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#f1f5f2;">
        <tr><td align="center" style="padding:32px 14px;">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:620px;background-color:#ffffff;border:1px solid #e3e9e4;border-radius:14px;overflow:hidden;">
                <tr><td align="center" style="padding:14px 24px 12px;background-color:#075c36;">
                    <img src="cid:logo-pgde@pgde" width="66" height="39" alt="Logo PGDE" style="display:block;width:66px;height:39px;margin:0 auto 6px;border:0;object-fit:contain;">
                    <p style="margin:0;color:#ffffff;font-size:11px;line-height:1.35;letter-spacing:1.2px;font-weight:bold;">PLATEFORME PGDE</p>
                    <p style="margin:2px 0 0;color:#d8eee1;font-size:11px;line-height:1.35;">Gestion des demandes d’emploi</p>
                </td></tr>
                <tr><td style="padding:34px 36px 30px;">
                    <p style="margin:0 0 8px;color:#008c45;font-size:12px;font-weight:bold;letter-spacing:.5px;">INFORMATION AUX CANDIDATS</p>
                    <h1 style="margin:0 0 20px;color:#202923;font-size:24px;line-height:1.3;">{{ $campaignSubject }}</h1>
                    <div style="color:#4b5b50;font-size:15px;line-height:1.75;">{!! nl2br(e($campaignBody)) !!}</div>
                </td></tr>
                <tr><td align="center" style="padding:19px 24px;border-top:1px solid #e8eee9;background-color:#fafcfb;">
                    <img src="cid:logo-mfp@pgde" width="42" height="42" alt="Ministère de la Fonction Publique" style="display:block;width:42px;height:42px;margin:0 auto 8px;object-fit:contain;">
                    <p style="margin:0;color:#607067;font-size:11px;line-height:1.6;">Ministère de la Fonction Publique, du Travail<br>et de la Réforme du Service Public</p>
                    <p style="margin:8px 0 0;color:#849087;font-size:10px;line-height:1.5;">Message d’information envoyé par la plateforme PGDE.</p>
                </td></tr>
            </table>
        </td></tr>
    </table>
</body>
</html>
