<?php

namespace App\Services;

class KnowledgeTextSanitizer
{
    public function sanitize(string $text): string
    {
        // Los documentos públicos pueden contener DNI de postulantes. El número no es
        // necesario para orientar al ciudadano y no debe pasar al índice del chatbot.
        return preg_replace('/(?<!\d)\d{8}(?!\d)/u', '[DNI protegido]', $text) ?? $text;
    }
}
