# Verificación de conversación — 27/08/2026

## Cambios publicados

- El código compuesto de una publicación debe coincidir exactamente; no se sustituye por otro código. Se admiten ceros iniciales y separadores equivalentes, sin autocorregir números.
- Los seguimientos ordinales de noticias y convocatorias se resuelven contra el listado mostrado, no contra el orden de una nueva búsqueda. Si no se identifica la posición, se solicita el título.
- Noticias y comunicados se presentan en orden de fecha descendente.
- FUT utiliza el enlace administrable de `mainright`, con validación de URL y respaldo a documentos de gestión cuando no hay enlace válido.
- El historial admite respuestas de hasta 12 000 caracteres; la pregunta sigue limitada a 1 600.
- Una consulta inicial de plazo sin ficha específica solicita identificar la convocatoria.
- El navegador cancela la espera tras 90 segundos y recupera el texto para permitir reenvío manual. No reintenta automáticamente.

## Evidencia

- PHPUnit: 117 pruebas, 707 aserciones, sin fallos. Incluye siete pruebas nuevas en `ChatbotConversationRegressionTest`.
- Compilación Vite completada.
- Producción: CAS 999-2099 devuelve falta de coincidencia, sin citar otra convocatoria.
- Producción: FUT devuelve el mismo archivo de Google Drive enlazado en la portada.
- Producción: últimas noticias en orden 395, 394, 393 (10/08, 14/07, 01/07 de 2026).
- Producción: «Resúmeme la segunda noticia» devuelve contenido y enlace de la noticia 394.
- Producción: historial de más de 1 600 caracteres aceptado; consulta inicial de plazo solicita contexto.
- Portada HTTP 200; configuración PHP-FPM validada y servicio activo.

## Despliegue y recuperación

Se compararon los archivos locales contra producción antes de editar. El despliegue incluyó únicamente el controlador, el código JavaScript y su nuevo bundle. El manifiesto conserva el CSS anterior, sin incorporar cambios visuales ajenos a esta revisión. Los hashes desplegados coinciden con los locales.

Respaldo en el servidor: `/root/backups/chatbot-conversation-20260827/before.tgz`. Los bundles anteriores se conservaron.

## Límites

Estas pruebas no certifican todas las formas posibles de preguntar ni la exactitud de cada documento. No se simuló una interrupción real de red de 90 segundos en producción. Los ordinales no resueltos de otras categorías solicitan aclaración. El cambio de CloudPanel corresponde únicamente a la cuenta confirmada por el propietario; no se modificó SSH.
