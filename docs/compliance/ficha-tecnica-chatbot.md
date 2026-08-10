# Ficha técnica del Asistente DRE

Estado: `[VALIDAR Y APROBAR]`

| Campo | Descripción |
|---|---|
| Titular del servicio | Dirección Regional de Educación Huánuco |
| Finalidad | Orientación sobre información pública del portal institucional |
| Población usuaria | Ciudadanía y personal que consulta el portal |
| Modelo configurable | `OPENAI_CHATBOT_MODEL` |
| Proveedor | OpenAI, sujeto a evaluación y contrato institucional |
| Arquitectura | Portal Laravel + base local + API externa para generación/embeddings/OCR |
| Datos de entrada | Consulta, hasta 20 mensajes, ruta/título de página, fuentes recuperadas |
| Datos excluidos | Datos sensibles, credenciales, expedientes privados, decisiones individuales |
| Salida | Texto de orientación y hasta tres fuentes directamente relacionadas |
| Retención local | 90 días por defecto, anonimizada y configurable |
| Retención de estado API | `store=false` en Responses API |
| OCR | Archivo temporal con expiración de 1 hora y eliminación explícita |
| Supervisión | Aprobación humana de fuentes + revisión de consultas restringida |
| Limitaciones | Puede errar; no sustituye publicación oficial ni decisión administrativa |
| Métricas | Error, latencia, tokens, cobertura, fuentes y consultas no resueltas |
| Revisión | Trimestral y ante cambios significativos |

## Flujo

1. Se valida y minimiza la consulta.
2. La búsqueda local selecciona información potencialmente relevante.
3. Solo las fuentes publicadas se entregan al modelo.
4. El modelo devuelve estado, respuesta y fuentes en esquema JSON estricto.
5. El servidor descarta enlaces si el estado no es completamente respaldado.
6. Se registra una versión minimizada para auditoría, si esa función está habilitada.
