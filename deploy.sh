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
# Nota: Vite escribe directamente a ~/public_html/build/ via VITE_PUBLIC_DIR

echo "▸ Syncing app code..."
rsync -a --delete "$REPO/app/"        "$WEB/app/"
rsync -a --delete "$REPO/bootstrap/"  "$WEB/bootstrap/"
rsync -a --delete "$REPO/config/"     "$WEB/config/"
rsync -a --delete "$REPO/database/"   "$WEB/database/"
rsync -a --delete "$REPO/resources/"  "$WEB/resources/"
rsync -a --delete "$REPO/routes/"     "$WEB/routes/"
[ -d "$REPO/lang/" ] && rsync -a --delete "$REPO/lang/" "$WEB/lang/"

echo "▸ Clearing caches..."
cd "$WEB" && php artisan view:clear && php artisan config:clear && php artisan route:clear \
    || fail "artisan cache clear falló"

echo ""
echo "✔  Deploy completado."
