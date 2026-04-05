#!/bin/bash
# ── deploy.sh ────────────────────────────────────────────────────────────────
# Despliega ~/drehco → ~/public_html
# Uso: bash ~/drehco/deploy.sh
# ─────────────────────────────────────────────────────────────────────────────
set -e

REPO="$HOME/drehco"
WEB="$HOME/public_html"

echo "▸ Pulling latest changes..."
cd "$REPO" && git pull

echo "▸ Building assets..."
cd "$REPO" && bun run build

echo "▸ Syncing app code..."
rsync -a --delete "$REPO/app/"        "$WEB/app/"
rsync -a --delete "$REPO/bootstrap/"  "$WEB/bootstrap/"
rsync -a --delete "$REPO/config/"     "$WEB/config/"
rsync -a --delete "$REPO/database/"   "$WEB/database/"
rsync -a --delete "$REPO/lang/"       "$WEB/lang/"       2>/dev/null || true
rsync -a --delete "$REPO/resources/"  "$WEB/resources/"
rsync -a --delete "$REPO/routes/"     "$WEB/routes/"

echo "▸ Syncing built assets..."
rsync -a --delete "$REPO/public/build/"  "$WEB/build/"

echo "▸ Syncing composer dependencies (only if changed)..."
if ! diff -q "$REPO/composer.json" "$WEB/composer.json" > /dev/null 2>&1; then
    cp "$REPO/composer.json" "$WEB/composer.json"
    cp "$REPO/composer.lock" "$WEB/composer.lock"
    cd "$WEB" && composer install --no-dev --optimize-autoloader --no-interaction
else
    echo "  composer.json unchanged, skipping"
fi

echo "▸ Clearing caches..."
cd "$WEB" && php artisan view:clear && php artisan config:clear && php artisan route:clear

echo ""
echo "✔  Deploy completado."
