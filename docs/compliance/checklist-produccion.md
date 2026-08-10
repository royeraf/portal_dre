# Checklist de salida a producción

## Gobierno y legal

- [ ] Política de IA y aviso de privacidad aprobados y publicados.
- [ ] Responsables designados y matriz RACI firmada.
- [ ] Evaluación de impacto y base jurídica aprobadas.
- [ ] Contrato/condiciones del proveedor, subencargados y transferencias revisados.
- [ ] Inventario de activos, tratamiento y proveedores actualizado.

## Configuración

- [ ] `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://...`.
- [ ] HTTPS válido, HSTS comprobado y redirección HTTP→HTTPS.
- [ ] `SESSION_SECURE_COOKIE=true`, `SESSION_ENCRYPT=true`.
- [ ] `CORS_ALLOWED_ORIGINS` contiene solo dominios autorizados.
- [ ] API key exclusiva de producción, privilegio mínimo, custodia y rotación definida.
- [ ] `OPENAI_LIMITE_DIARIO_TOKENS` y alertas de consumo configurados.
- [ ] `CLAMAV_BINARY` válido y `CLAMAV_REQUIRED=true`.
- [ ] Cron ejecuta `php artisan schedule:run` cada minuto.
- [ ] Backups cifrados, restauración probada y retención aprobada.

## Aplicación

- [ ] Framework en versión con soporte y `composer audit` limpio.
- [ ] `npm audit` revisado y activos compilados.
- [ ] Migraciones aplicadas y roles asignados por persona.
- [ ] Registros previos a la política purgados o justificados.
- [ ] PDFs heredados revisados y aprobados por responsable.
- [ ] Pruebas automatizadas, seguridad, carga y recuperación aprobadas.

## Accesibilidad y calidad

- [ ] WCAG 2.2 AA: teclado, lector de pantalla, contraste, zoom 200/400 %, reflow 320 px.
- [ ] Safari iOS, Chrome Android, Edge y Firefox probados.
- [ ] Matriz de consultas peruanas reales, seguimientos y cambios de tema aprobada.
- [ ] Enlaces y datos de alto impacto verificados contra su publicación oficial.
- [ ] Canal de reporte y procedimiento de incidentes visible para operadores.
