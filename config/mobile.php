<?php

return [
    // Liens des stores de l'application mobile PGDE.
    // Vides tant que l'application n'est pas publiée : les QR codes mènent alors à la page « Bientôt disponible ».
    'android' => env('MOBILE_APP_ANDROID_URL', ''),
    'ios' => env('MOBILE_APP_IOS_URL', ''),
];
