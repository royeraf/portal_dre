# Optimización y evaluación del chatbot — 28/08/2026

## Base técnica

- La recuperación documental conserva búsqueda semántica y literal, fusionadas mediante RRF. Microsoft documenta que la búsqueda híbrida combina la precisión léxica para códigos, fechas y nombres con la capacidad semántica para paráfrasis: https://learn.microsoft.com/en-us/azure/search/hybrid-search-overview
- OpenAI recomienda medir éxito, evidencia, tokens, latencia y coste en tareas representativas, y no considerar una reducción de recursos como mejora si baja la calidad: https://developers.openai.com/api/docs/guides/latest-model
- Responses API ofrece `prompt_cache_key`, salidas estructuradas, `safety_identifier` y límites de salida: https://developers.openai.com/api/reference/cli/resources/responses/methods/create

## Cambios publicados

- Caché de embeddings de consulta durante 24 horas para no vectorizar repetidamente la misma pregunta.
- Redacción de datos personales antes de enviar texto al endpoint de embeddings.
- `prompt_cache_key` estable y `safety_identifier` anónimo basado únicamente en la conversación aleatoria.
- Rechazo de respuestas declaradas como respaldadas cuando no señalan una fuente válida.
- Corrección acotada de errores de intención, sin modificar números, códigos ni nombres oficiales.
- Resolución determinista de ubicación y horario combinados, sin llamada al modelo.
- Nuevas variantes de inyección bloqueadas antes del modelo.
- Columna de origen de auditoría ampliada y registro defensivo: un fallo del log no puede tumbar una respuesta válida.
- Propietario del archivo de log corregido en producción.
- Comando `php artisan chatbot:evaluate` con once casos conversacionales y limpieza automática de sus trazas.
- Matriz adicional de paráfrasis para códigos con separadores y ceros, FUT, ordinales, datos de contacto e intentos de inyección.
- Los códigos compuestos se recuperan por identidad numérica aunque cambien los ceros de relleno o los espacios.
- Las posiciones numéricas del listado anterior se resuelven antes de la navegación hacia una sección general.

## Evidencia

- PHPUnit: 129 pruebas, 817 aserciones, sin fallos.
- Matriz de robustez: 6 familias, 88 aserciones, sin fallos.
- Evaluación previa al despliegue: 5/7.
- Evaluación posterior al despliegue: 7/7.
- Evaluación ampliada posterior al segundo despliegue: 11/11.
- Página pública HTTP 200, configuración PHP-FPM válida y servicio activo.
- Dos ejecuciones reales de una consulta sobre el ROF respondieron HTTP 200. La latencia total varió por generación del modelo; no se atribuye una reducción no demostrada a la caché.

## Alcance

El resultado 11/11 cubre la regresión ampliada actual. Ninguna suite finita demuestra todas las preguntas posibles; por eso debe seguir creciendo con consultas reales, especialmente las marcadas con valoración negativa en el panel de auditoría.
