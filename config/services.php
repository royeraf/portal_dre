<?php

return [

    'openai' => [
        'key' => env('OPENAI_API_KEY'),
        'chatbot_model' => env('OPENAI_CHATBOT_MODEL', 'gpt-5-nano'),

        // Transcripción de PDFs escaneados. Se puede apagar para controlar el gasto:
        // sin esto, las normas publicadas como imagen quedan fuera del asistente.
        'ocr' => env('OPENAI_OCR', true),
        'ocr_model' => env('OPENAI_OCR_MODEL', 'gpt-5.6-luna'),

        // Techo de tokens por día para el chat público. El endpoint está abierto a
        // internet: sin un tope, un script puede agotar el presupuesto en una tarde.
        // Al superarlo el asistente sigue respondiendo, pero con enlaces en vez de IA.
        // 0 = sin límite.
        'limite_diario_tokens' => (int) env('OPENAI_LIMITE_DIARIO_TOKENS', 0),
    ],

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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];
