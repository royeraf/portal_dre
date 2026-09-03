<?php

return [
    /*
    | Los registros sirven para detectar respuestas incorrectas, pero pueden contener
    | datos escritos libremente por ciudadanos. Se anonimizan y se eliminan por plazo.
    */
    'retention_days' => max(1, (int) env('CHATBOT_RETENTION_DAYS', 90)),
    'store_transcripts' => (bool) env('CHATBOT_STORE_TRANSCRIPTS', true),
    'redact_personal_data' => (bool) env('CHATBOT_REDACT_PERSONAL_DATA', true),

    'provider_name' => env('CHATBOT_AI_PROVIDER_NAME', 'OpenAI'),

    // Los archivos usados para OCR también se borran explícitamente al terminar.
    // Esta expiración es una salvaguarda adicional si la eliminación inmediata falla.
    'ocr_file_expiry_seconds' => min(
        2592000,
        max(3600, (int) env('OPENAI_OCR_FILE_EXPIRY_SECONDS', 3600))
    ),
];
