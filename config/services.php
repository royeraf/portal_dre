<?php

return [

    'openai' => [
        'key' => env('OPENAI_API_KEY'),
        'chatbot_model' => env('OPENAI_CHATBOT_MODEL', 'gpt-5-nano'),
        'chatbot_prompt_cache_key' => env('OPENAI_CHATBOT_PROMPT_CACHE_KEY', 'dre-huanuco-chatbot-v1'),
        'chatbot_reasoning' => env('OPENAI_CHATBOT_REASONING', 'medium'),
        'ca_bundle' => env('OPENAI_CA_BUNDLE'),

        // Transcripción de PDFs escaneados. Se puede apagar para controlar el gasto:
        // sin esto, las normas publicadas como imagen quedan fuera del asistente.
        'ocr' => env('OPENAI_OCR', true),
        'ocr_model' => env('OPENAI_OCR_MODEL', 'gpt-5.6-luna'),

        // Techo de tokens por día para el chat público. El endpoint está abierto a
        // internet: sin un tope, un script puede agotar el presupuesto en una tarde.
        // Al superarlo el asistente sigue respondiendo, pero con enlaces en vez de IA.
        // 0 = sin límite (no recomendado en producción).
        'limite_diario_tokens' => (int) env('OPENAI_LIMITE_DIARIO_TOKENS', 500000),
    ],

    'local_pdf_ocr' => [
        'enabled' => env('LOCAL_PDF_OCR', false),
        'tesseract' => env('TESSERACT_BINARY', 'tesseract'),
        'pdftoppm' => env('PDFTOPPM_BINARY', 'pdftoppm'),
        'tessdata' => env('TESSDATA_PREFIX'),
        'languages' => env('TESSERACT_LANGUAGES', 'spa+eng'),
        'dpi' => (int) env('LOCAL_PDF_OCR_DPI', 180),
        'pdf_timeout' => (int) env('LOCAL_PDF_OCR_PDF_TIMEOUT', 900),
        'page_timeout' => (int) env('LOCAL_PDF_OCR_PAGE_TIMEOUT', 180),
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
