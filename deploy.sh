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
if [ -n "$APP_URL" ]; then
    TOKEN=$(openssl rand -hex 8)
    SCRIPT="$WEB/opc_${TOKEN}.php"
    echo "<?php opcache_reset(); echo 'OK'; @unlink(__FILE__);" > "$SCRIPT"
    RESULT=$(curl -s --max-time 10 "${APP_URL}/opc_${TOKEN}.php")
    rm -f "$SCRIPT" 2>/dev/null
    [ "$RESULT" = "OK" ] && echo "  OPcache reset OK" || echo "  OPcache reset falló (respuesta: $RESULT)"
else
    echo "  APP_URL no encontrado en $REPO/.env"
fi

echo ""
echo "✔  Deploy completado."
