<?php

namespace App\Support;

final class PersonalDataRedactor
{
    public static function redact(string $text): string
    {
        if (! config('chatbot.redact_personal_data', true)) {
            return $text;
        }

        $patterns = [
            '/\b[A-Z0-9._%+\-]+@[A-Z0-9.\-]+\.[A-Z]{2,}\b/iu' => '[CORREO OMITIDO]',
            '/(?<!\d)9\d{8}(?!\d)/u' => '[TELÉFONO OMITIDO]',
            '/\b(?:dni|documento(?:\s+de\s+identidad)?)\s*(?:n[.º°o]*\s*)?[:#-]?\s*\d{8}\b/iu' => '[DNI OMITIDO]',
            '/(?<!\d)\d{8}(?!\d)/u' => '[DATO NUMÉRICO OMITIDO]',
            '/\b(?:contraseña|clave|password)\s*[:=]\s*\S+/iu' => '[CREDENCIAL OMITIDA]',
        ];

        return preg_replace(array_keys($patterns), array_values($patterns), $text) ?? $text;
    }

    /** @param array<int, array{role: string, content: string}> $history */
    public static function history(array $history): array
    {
        return array_map(static function (array $item): array {
            $item['content'] = self::redact((string) ($item['content'] ?? ''));

            return $item;
        }, $history);
    }
}
