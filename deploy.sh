#!/bin/bash
# ── deploy.sh ────────────────────────────────────────────────────────────────
# La app corre desde ~/drehco/ (index.php de public_html apunta ahí)
# Los assets compilados van directo a ~/public_html/build/ via VITE_PUBLIC_DIR
# Uso: bash ~/drehco/deploy.sh
# ─────────────────────────────────────────────────────────────────────────────

REPO="$HOME/drehco"
WEB="$HOME/public_html"

fail() { echo "✖  Error: $1"; exit 1; }

echo "▸ Pulling latest changes..."
cd "$REPO" && git pull || fail "git pull falló"

echo "▸ Building assets..."
cd "$REPO" && bun run build || fail "bun build falló"
# Vite escribe directamente a ~/public_html/build/ via VITE_PUBLIC_DIR

echo "▸ Clearing Laravel caches..."
cd "$REPO" && php artisan view:clear && php artisan config:clear && php artisan route:clear \
    || fail "artisan cache clear falló"

echo "▸ Resetting OPcache..."
APP_URL=$(grep '^APP_URL=' "$REPO/.env" 2>/dev/null | head -1 | cut -d= -f2- | tr -d '"' | tr -d "'" | tr -d ' ')
APP_KEY=$(grep '^APP_KEY=' "$REPO/.env" 2>/dev/null | head -1 | cut -d= -f2- | tr -d '"' | tr -d "'" | tr -d ' ')
if [ -n "$APP_URL" ] && [ -n "$APP_KEY" ]; then
    TOKEN=$(echo -n "$APP_KEY" | sha256sum | cut -d' ' -f1)
    # Purgar cache de nginx para /_flush antes de llamarlo
    curl -sk -A "Mozilla/5.0" "${APP_URL}/purge/_flush/${TOKEN}" > /dev/null
    sleep 1
    RESULT=$(curl -s --max-time 10 -A "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36" "${APP_URL}/_flush/${TOKEN}" | tr -d ' \t\r\n')
    [ "$RESULT" = "OK" ] && echo "  OPcache reset OK" || echo "  OPcache reset falló (respuesta: $RESULT)"
else
    echo "  APP_URL o APP_KEY no encontrado en $REPO/.env"
fi

echo "▸ Limpiando caché de nginx..."
sudo rm -rf /var/nginx/cache/drehua5/* 2>/dev/null && echo "  Nginx cache limpiado" || echo "  Sin permisos para limpiar nginx cache (ejecutar manualmente)"
if [ -n "$APP_URL" ]; then
    for path in / /login /intranet /csrf-token \
                /mision /vision /nosotros /directorioweb \
                /convocatoriaweb /allnoticias /galeriaimagenes \
                /comunicadosall /documentosdegestionweb \
                /infraestructuraall /infraestructura-galeria /resoluciones /siagie /epr \
                /convivenciasinviolencia; do
        curl -sk -A "Mozilla/5.0" "${APP_URL}/purge${path}" > /dev/null
    done
    echo "  Nginx purge OK"
fi

echo ""
echo "✔  Deploy completado."
