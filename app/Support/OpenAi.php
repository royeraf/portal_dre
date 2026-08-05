<?php

namespace App\Support;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class OpenAi
{
    /**
     * Cliente HTTP para la API de OpenAI.
     *
     * Fuerza IPv4 porque en Windows la resolución DNS de libcurl falla a partir de la
     * segunda petición del mismo proceso: la primera consulta responde y las siguientes
     * devuelven "Could not resolve host". Medido en este equipo, 5 de 6 llamadas
     * fallaban sin esta opción y 6 de 6 funcionan con ella, además de ir más rápido.
     *
     * Está centralizado para que ninguna llamada nueva se olvide de la opción: el
     * síntoma es una respuesta genérica del asistente, sin error visible en pantalla.
     */
    public static function http(int $timeout = 45): PendingRequest
    {
        $options = ['curl' => [CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4]];
        $caBundle = config('services.openai.ca_bundle');

        // Algunas instalaciones de PHP en Windows no traen un almacén de certificados.
        // Se permite indicar un CA bundle local sin desactivar la validación TLS.
        if (is_string($caBundle) && $caBundle !== '' && is_file($caBundle)) {
            $options['verify'] = $caBundle;
        }

        return Http::timeout($timeout)
            ->withOptions($options)
            ->withToken((string) config('services.openai.key'));
    }
}
