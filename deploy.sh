#!/bin/bash
# ── deploy.sh ────────────────────────────────────────────────────────────────
# Despliega ~/drehco → ~/public_html
# Uso: bash ~/drehco/deploy.sh
# ─────────────────────────────────────────────────────────────────────────────

REPO="$HOME/drehco"
WEB="$HOME/public_html"

fail() { echo "✖  Error: $1"; exit 1; }

echo "▸ Pulling latest changes..."
cd "$REPO" && git pull || fail "git pull falló"

echo "▸ Building assets..."
cd "$REPO" && bun run build || fail "bun build falló"

echo "▸ Syncing app code..."
rsync -a --delete "$REPO/app/"        "$WEB/app/"
rsync -a --delete "$REPO/bootstrap/"  "$WEB/bootstrap/"
rsync -a --delete "$REPO/config/"     "$WEB/config/"
rsync -a --delete "$REPO/database/"   "$WEB/database/"
rsync -a --delete "$REPO/resources/"  "$WEB/resources/"
rsync -a --delete "$REPO/routes/"     "$WEB/routes/"
[ -d "$REPO/lang/" ] && rsync -a --delete "$REPO/lang/" "$WEB/lang/"

echo "▸ Syncing public assets (htaccess, etc.)..."
rsync -a --exclude="index.php" "$REPO/public/" "$WEB/"

echo "▸ Clearing Laravel caches..."
cd "$WEB" && php artisan view:clear && php artisan config:clear && php artisan route:clear \
    || fail "artisan cache clear falló"

echo "▸ Resetting OPcache..."
APP_URL=$(grep '^APP_URL=' "$WEB/.env" "$REPO/.env" 2>/dev/null | head -1 | cut -d= -f2- | tr -d '"' | tr -d "'" | tr -d ' ')
if [ -n "$APP_URL" ]; then
    TOKEN=$(head -c 16 /dev/urandom | base64 | tr -dc 'a-zA-Z0-9' | head -c 16)
    SCRIPT="$WEB/opc_${TOKEN}.php"
    echo "<?php opcache_reset(); echo 'OK'; @unlink(__FILE__);" > "$SCRIPT"
    RESULT=$(curl -s --max-time 10 "${APP_URL}/opc_${TOKEN}.php")
    rm -f "$SCRIPT" 2>/dev/null
    [ "$RESULT" = "OK" ] && echo "  OPcache reset OK" || echo "  OPcache reset no disponible (continuando)"
else
    echo "  APP_URL no encontrado en .env, saltando OPcache reset"
fi

echo ""
echo "✔  Deploy completado."
