#!/bin/bash
# fix_symlinks.sh
# Ensures upload folders in ~/drehco/public_html/ are symlinks to ~/public_html/
# so files saved by Laravel are accessible by the web server.

DREHCO="$HOME/drehco/public_html"
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
echo "Verificación final:"
for folder in "${FOLDERS[@]}"; do
    ls -la "$DREHCO/$folder" 2>/dev/null | grep -E "^l|^d|No existe"
done
