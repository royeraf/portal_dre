<?php

return [
    'clamav' => [
        'binary' => env('CLAMAV_BINARY'),
        'required' => (bool) env('CLAMAV_REQUIRED', false),
        'timeout_seconds' => max(10, (int) env('CLAMAV_TIMEOUT_SECONDS', 90)),
    ],
];
