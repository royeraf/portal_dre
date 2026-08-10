# Roles y responsabilidades `[COMPLETAR Y FIRMAR]`

| Rol | Persona/unidad | Responsabilidad | Evidencia |
|---|---|---|---|
| Dueño del servicio | `[DESIGNAR]` | Finalidad, alcance y riesgo aceptado | Resolución/memorando |
| Responsable funcional | `[DESIGNAR]` | Contenido, fuentes y calidad | Acta de aprobación |
| Responsable técnico | `[DESIGNAR]` | Operación, cambios y continuidad | Orden/funciones |
| Seguridad digital | `[DESIGNAR]` | Riesgos, accesos e incidentes | Designación SGSI |
| Protección de datos | `[CONFIRMAR]` | Información, derechos y EIPD | Designación/contacto |
| Aprobador de conocimiento | `[DESIGNAR]` | Vigencia y publicación de PDFs | Registro CMS |
| Auditor del chatbot | `[DESIGNAR]` | Muestreo y acciones correctivas | Informe mensual |
| Administrador de cuentas | `[DESIGNAR]` | Alta, baja y revisión de permisos | Bitácora de accesos |

## Roles técnicos disponibles

- `admin`: control total de los módulos de IA.
- `ai_manager`: carga, revisión, aprobación y retiro de conocimiento.
- `auditor`: lectura de consultas anonimizadas y métricas.
- `editor`: CMS general sin acceso a conocimiento IA ni conversaciones.

La asignación se realiza con `php artisan user:grant-role correo@entidad.gob.pe rol` y debe
respaldarse con autorización formal. Las cuentas compartidas están prohibidas.
