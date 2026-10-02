Activation de votre compte PGDE

Bonjour,

@if(!empty($isPreview)) E-mail de test : le lien renvoie vers la page de connexion. @endif

{{ $mailIntro }}

{{ $verificationUrl }}

Ce lien est valable pendant 60 minutes et ne peut être utilisé qu’une seule fois.

Si vous n’êtes pas à l’origine de cette inscription, ignorez ce message. Votre compte ne sera pas activé sans confirmation de l’adresse e-mail.

{{ $mailSignature }}
