# Matriz resumida de riesgos

Escala: probabilidad e impacto de 1 a 5. El riesgo residual debe ser validado por la entidad.

| Riesgo | P | I | Controles aplicados | Pendiente | Residual |
|---|---:|---:|---|---|---:|
| Respuesta incorrecta | 3 | 4 | RAG, fuentes aprobadas, esquema estricto, no mostrar enlaces irrelevantes | Muestreo mensual | 2x4 |
| Exposición de datos personales | 3 | 5 | Aviso, redacción, hash, retención y borrado | Contrato y EIPD aprobada | 2x5 |
| Prompt injection | 3 | 4 | Separación instrucciones/datos, prompt defensivo, fuentes publicadas | Pruebas periódicas | 2x4 |
| PDF malicioso | 2 | 5 | Validación estructural/activa y ClamAV opcional | ClamAV obligatorio en producción | 1x5 |
| Acceso indebido al CMS/log | 3 | 5 | Roles y gates | MFA/SSO y revisión trimestral de cuentas | 2x5 |
| Abuso/coste de API | 4 | 3 | Rate limit y presupuesto diario | Alertas de consumo | 2x3 |
| Dependencia del proveedor | 3 | 4 | Respuesta local de respaldo | Plan de salida y SLA | 2x4 |
| Servicio desactualizado | 4 | 4 | Laravel 9 / PHP 8.1 por requisito de compatibilidad; avisos de seguridad aceptados, no corregidos | Revisar avisos y planificar migración a una plataforma mantenida | 4x4 |
| Barrera de accesibilidad | 3 | 4 | Foco, teclado, contraste, reduced motion | Pruebas WCAG con usuarios | 2x4 |

## Criterio de aceptación

Ningún riesgo con impacto 5 debe aceptarse sin responsable, fecha, evidencia del control y
aprobación formal. Incidentes reales obligan a recalcular la matriz.
