#!/bin/bash
# fix_symlinks.sh
# Ensures upload folders in ~/drehco/public_html/ are symlinks to ~/public_html/
# so files saved by Laravel are accessible by the web server.
# Also ensures ~/public_html/.user.ini is a symlink into ~/drehco/public/, so PHP
# ini overrides tracked in git (upload_max_filesize, post_max_size) go live on
# every "git pull" without a manual copy step.

DREHCO="$HOME/drehco/public_html"
DREHCO_PUBLIC="$HOME/drehco/public"
WEB="$HOME/public_html"

FOLDERS=(
    "archivos"
    "img/noticias"
    "img/comunicados"
    "img/default"
    "img/encargado_areas"
    "img/eventoimagenes"
    "img/imageneventos"
    "img/organigrama_areas"
    "img/post_noticias"
    "img/popup"
    "img/slider"
    "img/mainright"
    "img/directorio"
    "img/infraestructura"
)

for folder in "${FOLDERS[@]}"; do
    src="$DREHCO/$folder"
    dest="$WEB/$folder"

    mkdir -p "$dest"

    if [ -L "$src" ]; then
        echo "✔  $folder — ya es symlink, omitiendo"
        continue
    fi

    if [ -d "$src" ]; then
        echo "▸  $folder — copiando archivos y creando symlink..."
        cp -n "$src/"* "$dest/" 2>/dev/null
        rm -rf "$src"
    fi

    ln -s "$dest" "$src"
    echo "✔  $folder — symlink creado"
done

# Proteger cada carpeta contra ejecución de PHP
HTACCESS='<FilesMatch "\.php$">
    deny from all
</FilesMatch>'

echo ""
echo "▸ Aplicando .htaccess de seguridad..."
for folder in "${FOLDERS[@]}"; do
    dest="$WEB/$folder"
    echo "$HTACCESS" > "$dest/.htaccess"
    echo "✔  $folder/.htaccess"
done

echo ""
echo "▸ Enlazando .user.ini (límite de subida de 10 MB de Archivos)..."
USERINI_SRC="$DREHCO_PUBLIC/.user.ini"
USERINI_DEST="$WEB/.user.ini"
if [ ! -f "$USERINI_SRC" ]; then
    echo "  ⚠  $USERINI_SRC no existe — omitiendo (¿falta git pull?)"
elif [ -L "$USERINI_DEST" ]; then
    echo "  ✔  .user.ini — ya es symlink, omitiendo"
else
    if [ -f "$USERINI_DEST" ]; then
        mv "$USERINI_DEST" "$USERINI_DEST.bak"
        echo "  ▸  .user.ini existente respaldado como .user.ini.bak"
    fi
    ln -s "$USERINI_SRC" "$USERINI_DEST"
    echo "  ✔  .user.ini — symlink creado"
fi

echo ""
echo "Verificación final:"
for folder in "${FOLDERS[@]}"; do
    ls -la "$DREHCO/$folder" 2>/dev/null | grep -E "^l|^d|No existe"
done
ls -la "$USERINI_DEST" 2>/dev/null
