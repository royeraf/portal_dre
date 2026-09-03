# Chatbot DRE Huánuco: arquitectura y operación

## Objetivo

El chatbot ayuda a encontrar información pública de la DRE Huánuco sin inventar datos. Responde con información estructurada del portal, publicaciones y documentos administrados desde el CMS. Cuando no puede verificar un dato, lo indica y evita enlazar una publicación parecida como si fuera la solicitada.

## Cómo funciona una consulta

1. La API valida el mensaje, el historial, el identificador anónimo de conversación y el contexto de página.
2. Las solicitudes sensibles, la navegación, los datos institucionales y los códigos exactos se resuelven de manera determinista.
3. Se buscan fuentes en noticias, comunicados, convocatorias, directorio, SIAGIE, documentos de gestión y base documental de IA.
4. La recuperación documental combina coincidencia literal y similitud semántica mediante Reciprocal Rank Fusion (RRF).
5. El modelo recibe únicamente el historial necesario y las fuentes seleccionadas. Su salida estructurada debe identificar las fuentes utilizadas.
6. Si la respuesta no está respaldada, el sistema usa una respuesta local segura o reconoce que no encontró información.
7. Se guarda una auditoría sin datos personales directos y el ciudadano puede valorar la utilidad de la respuesta.

## Componentes principales

- `app/Http/Controllers/ChatbotController.php`: orquestación, recuperación, respuestas deterministas, validación de fuentes, límites y auditoría.
- `resources/views/components/dre-chatbot.blade.php`: estructura accesible del panel flotante.
- `resources/js/app.js`: conversación, persistencia en la pestaña, tiempos de espera, enlaces y valoración.
- `resources/css/app.css`: presentación adaptable del widget.
- `app/Http/Controllers/KnowledgeDocumentController.php`: administración de la base documental.
- `app/Services/Pdf*` y `KnowledgeTextSanitizer.php`: validación, extracción, OCR y limpieza del contenido.
- `app/Console/Commands/ImportKnowledgeDirectory.php`: incorporación automática de documentos publicados en el portal.
- `app/Console/Commands/EvaluateChatbot.php`: pruebas conversacionales reproducibles contra una instalación real.
- `resources/chatbot/evals.json`: conjunto de regresión de producción.

## CMS y documentos

Las cargas de convocatorias, documentos de gestión y archivos generales utilizan `PortalDocumentStorage`. Los archivos se validan por tamaño, tipo real y estructura; el nombre público lo genera el servidor. Los documentos referenciados por el portal pueden importarse automáticamente a la base de conocimiento cada diez minutos.

Los archivos subidos son contenido dinámico y no se versionan en Git. Solo se conserva `public/archivos/.htaccess`, que impide ejecutar contenido dentro del directorio de documentos.

## Configuración

### Compatibilidad solicitada

Esta rama utiliza Laravel 9.52 y exclusivamente PHP 8.1.x (`~8.1.0`). Composer resuelve
las dependencias tomando PHP 8.1.0 como plataforma mínima; las pruebas utilizan
PHPUnit 9.6. Instalar siempre con el `composer.lock` de esta rama.

Laravel 9 es una versión sin soporte de seguridad. Por autorización expresa del
responsable se configuró una excepción de Composer únicamente para
`laravel/framework` en `config.policy.advisories.ignore`. Esta excepción permite
resolver las dependencias, pero no corrige las vulnerabilidades. Los demás
paquetes mantienen el bloqueo de avisos de seguridad. Revisar el riesgo antes de
desplegar y planificar una actualización a una versión mantenida.

Después de cambiar de rama, ejecutar `composer install`, limpiar las cachés con
`php artisan optimize:clear` y ejecutar las pruebas antes de aplicar migraciones.
Esta adaptación en Git no cambia automáticamente el servidor publicado.

Verificación de esta adaptación: PHP 8.1.34, Laravel 9.52.22 y PHPUnit 9.6.36;
129 pruebas aprobadas y 816 aserciones. SQLite se habilitó para las pruebas en
memoria. Se añadió Doctrine DBAL 3 para las migraciones con modificación de
columnas. La clave fija de `phpunit.xml` es exclusivamente de pruebas, nunca
debe utilizarse como clave del entorno publicado.

Variables relevantes, documentadas también en `.env.example`:

- `OPENAI_API_KEY`: credencial del proveedor; nunca debe incorporarse al repositorio.
- `OPENAI_CHATBOT_MODEL`: modelo de respuesta.
- `OPENAI_CHATBOT_REASONING`: esfuerzo de razonamiento.
- `OPENAI_CHATBOT_PROMPT_CACHE_KEY`: clave estable para reutilizar el prefijo del prompt.
- `OPENAI_LIMITE_DIARIO_TOKENS`: límite diario del chatbot; `0` lo desactiva.
- `OPENAI_OCR`: habilita la transcripción remota de PDF cuando sea necesaria.
- `LOCAL_PDF_OCR`: habilita el respaldo local con Tesseract y Poppler.

Después de configurar el entorno se deben ejecutar las migraciones y mantener activo el programador de Laravel:

```bash
php artisan migrate --force
php artisan schedule:work
```

En producción es preferible invocar `php artisan schedule:run` cada minuto mediante cron o el programador del panel.

## Verificación

Suite completa:

```bash
php artisan test
```

Evaluación contra el sitio publicado:

```bash
php artisan chatbot:evaluate --url=https://chatbot.imefactura.app
```

La evaluación comprueba, entre otros casos, códigos CAS existentes e inexistentes, enlace directo al FUT, noticias en orden cronológico, referencias ordinales, errores ortográficos, ubicación y horario, y ataques de instrucciones. La propia herramienta elimina sus registros de prueba.

## Seguridad y privacidad

- No se almacenan la IP ni el agente del navegador como identificadores del proveedor.
- Los datos personales reconocibles se redactan antes de generar embeddings.
- Las URLs se validan antes de mostrarse.
- Las operaciones destructivas del CMS usan métodos HTTP con protección CSRF.
- Los PDF se inspeccionan antes de procesarlos y se publican con nombres controlados por el servidor.
- Una respuesta declarada como respaldada debe citar una fuente recuperada válida.

## Alcance de calidad

El resultado “100%” significa que pasa el conjunto de pruebas reproducible vigente. No significa que una cantidad finita de pruebas cubra cualquier frase imaginable. Las valoraciones negativas y las consultas reales deben convertirse periódicamente en nuevos casos de regresión antes de modificar la lógica.
