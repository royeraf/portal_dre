# Expediente de cumplimiento del Asistente DRE

Estado: **implementación técnica realizada / aprobación institucional pendiente**.

Este directorio reúne la evidencia mínima para revisar el chatbot frente a Gobierno Digital,
IA, protección de datos, seguridad y accesibilidad. Los textos marcados `[POR APROBAR]` o
`[DESIGNAR]` requieren resolución, memorando, contrato, acta o validación de la autoridad
competente; el repositorio no sustituye esos actos.

## Controles implementados en el sistema

- Las llamadas a Responses API usan `store=false`.
- Los PDFs temporales de OCR expiran a la hora y se intenta eliminarlos al terminar.
- Los datos personales comunes de la consulta se ocultan antes del envío y del registro.
- El historial local se limita a 20 mensajes y puede borrarse desde “Reiniciar conversación”.
- Los registros anonimizados se purgan diariamente al superar 90 días.
- El conocimiento nuevo queda como borrador hasta ser aprobado por un responsable.
- Los módulos de conocimiento y auditoría tienen permisos diferentes.
- Se validan cabecera, cifrado, contenido activo y, cuando se configura, antivirus en PDFs.
- Se aplican encabezados de seguridad, CORS limitado y sesiones cifradas.
- El framework fue actualizado de Laravel 9 a Laravel 13.24 con PHP 8.3.
- El diálogo tiene modalidad, foco contenido, cierre con Escape, anuncios accesibles y respeto
  por `prefers-reduced-motion`.

## Pendientes que requieren acción institucional

1. `[POR APROBAR]` Política de uso responsable de IA y aviso integral de privacidad.
2. `[DESIGNAR]` Responsable funcional, responsable técnico, auditor de calidad, responsable
   de seguridad y contacto de protección de datos.
3. `[FORMALIZAR]` Registro y evaluación contractual de OpenAI y demás encargados.
4. `[VALIDAR]` Base jurídica, flujo de derechos ARCO y eventual inscripción/actualización del
   banco de datos personales ante la autoridad competente.
5. `[EJECUTAR]` Evaluación de impacto, pruebas de accesibilidad con usuarios y simulacro de
   incidentes antes de producción.
6. `[CONFIGURAR]` HTTPS, variables de producción, antivirus obligatorio, copias de seguridad,
   monitoreo, alertas de presupuesto y cron del servidor.

## Referencias normativas

- Decreto Legislativo N.° 1412, Ley de Gobierno Digital.
- D.S. N.° 029-2021-PCM y modificatorias.
- Ley N.° 31814 y D.S. N.° 115-2025-PCM.
- Ley N.° 29733 y D.S. N.° 016-2024-JUS.
- RSGTD N.° 003-2023-PCM/SGTD.
- RSGTD N.° 001-2025-PCM/SGTD, accesibilidad de servicios y plataformas digitales.
- D.S. N.° 126-2025-PCM, Marco de Confianza Digital.
- NTP/ISO/IEC 27001, cuando corresponda al alcance del SGSI de la entidad.

La interpretación legal final debe ser validada por Asesoría Jurídica, Seguridad Digital y el
responsable de protección de datos de la DRE Huánuco.
