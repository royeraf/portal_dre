# Evaluación de impacto en protección de datos `[BORRADOR]`

## Necesidad y proporcionalidad

La finalidad es orientar sobre contenido público. No es necesario identificar al ciudadano.
Por ello el servicio no solicita autenticación, no guarda IP, usa un identificador aleatorio
con hash, limita el historial, oculta patrones comunes de datos y permite borrar el hilo.

## Inventario de tratamiento

| Dato | Origen | Uso | Destino | Conservación |
|---|---|---|---|---|
| Consulta minimizada | Ciudadano | Responder y buscar | Servidor / proveedor IA | Hasta 90 días local |
| Historial, máximo 20 | Navegador | Contexto | Proveedor IA durante solicitud | Pestaña del navegador |
| Página actual | Navegador | Resolver referencias | Proveedor IA | Solicitud |
| Fuentes públicas | Portal/CMS | Fundamentar | Proveedor IA | Según publicación |
| Hash de conversación | Navegador | Borrado y auditoría | Servidor | Hasta 90 días |
| PDF para OCR | CMS | Extraer texto | Proveedor IA | 1 hora como salvaguarda |

## Riesgos y medidas

- Ingreso accidental de DNI/teléfono/correo: aviso visible, redacción y registro minimizado.
- Transferencia a proveedor: contrato, revisión de región/retención y `store=false`.
- Reidentificación por texto libre: acceso restringido, retención corta y prohibición de uso secundario.
- Datos personales en PDFs: revisión humana antes de publicar y retiro inmediato.
- Respuesta falsa con efectos: fuentes oficiales, esquema estricto, advertencia y supervisión.
- Acceso indebido a logs: rol auditor, sesiones cifradas, HTTPS y trazabilidad `[AMPLIAR]`.

## Decisiones pendientes

- `[VALIDAR LEGAL]` Base jurídica aplicable y deber de información completo.
- `[VALIDAR]` Necesidad de inscripción/actualización del banco de datos.
- `[FORMALIZAR]` Encargo, transferencias, subencargados y atención de derechos con proveedores.
- `[APROBAR]` Riesgo residual y responsable que lo acepta.
