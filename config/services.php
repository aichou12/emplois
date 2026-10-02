<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    // Serveur d'actions Rasa : jeton partagé et liste blanche d'IP optionnelle (séparées par des virgules).
    'chatbot' => [
        'token' => env('CHATBOT_API_TOKEN'),
        'allowed_ips' => env('CHATBOT_ALLOWED_IPS', ''),
    ],

    // Serveur Rasa (machine séparée) relayé par POST /api/v1/chatbot/messages.
    'rasa' => [
        'url' => env('RASA_URL', 'http://127.0.0.1:5005'),
        'timeout' => (int) env('RASA_TIMEOUT', 30),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
