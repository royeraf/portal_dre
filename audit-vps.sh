#!/bin/bash
# ─────────────────────────────────────────────────────────────────────────────
# audit-vps.sh — Auditoría forense post-intrusión (SOLO LECTURA, no borra)
#
# Uso:
#   scp audit-vps.sh drehua5@drehuanuco.gob.pe:~/audit-vps.sh
#   ssh drehua5@drehuanuco.gob.pe 'bash ~/audit-vps.sh'
#
# Salida: ~/audit-report.txt (un único archivo para revisar)
# ─────────────────────────────────────────────────────────────────────────────

set -u
OUT="$HOME/audit-report.txt"
SEP='================================================================================'

# Reinicia el reporte
: > "$OUT"

log()     { echo "$@" | tee -a "$OUT" >/dev/null; }
section() { echo ""                  | tee -a "$OUT" >/dev/null;
            echo "$SEP"              | tee -a "$OUT" >/dev/null;
            echo "# $*"              | tee -a "$OUT" >/dev/null;
            echo "$SEP"              | tee -a "$OUT" >/dev/null; }
cmd()     { echo "\$ $*"             | tee -a "$OUT" >/dev/null;
            eval "$@" 2>&1           | tee -a "$OUT" >/dev/null;
            echo ""                  | tee -a "$OUT" >/dev/null; }

log "Auditoría iniciada: $(date -u '+%Y-%m-%d %H:%M:%S UTC')"
log "Host: $(hostname)  Usuario: $(whoami)  HOME: $HOME"

# ─────────────────────────────────────────────────────────────────────────────
section "1. SSH: llaves autorizadas y backups"
# ─────────────────────────────────────────────────────────────────────────────
cmd "ls -la $HOME/.ssh/"
for f in authorized_keys authorized_keys.bak authorized_keys.new authorized_keys2; do
    [ -f "$HOME/.ssh/$f" ] && { log "--- $HOME/.ssh/$f ---"; cmd "cat $HOME/.ssh/$f"; }
done

# ─────────────────────────────────────────────────────────────────────────────
section "2. Shell de login y persistencia"
# ─────────────────────────────────────────────────────────────────────────────
for f in .bashrc .bash_profile .profile .bash_logout .bash_login .zshrc .bashrc.clean .bashrc.infected.bak; do
    [ -f "$HOME/$f" ] && { log "--- $HOME/$f ---"; cmd "ls -la $HOME/$f"; cmd "cat $HOME/$f"; }
done
cmd "ls -la $HOME/.bash_history | head -5"
log "--- Últimas 80 líneas de .bash_history ---"
cmd "tail -80 $HOME/.bash_history"

# ─────────────────────────────────────────────────────────────────────────────
section "3. Cron jobs (usuario actual)"
# ─────────────────────────────────────────────────────────────────────────────
cmd "crontab -l"
cmd "ls -la $HOME/cron/ 2>/dev/null"

# ─────────────────────────────────────────────────────────────────────────────
section "4. Procesos activos de drehua5"
# ─────────────────────────────────────────────────────────────────────────────
cmd "ps -u \$(whoami) -o pid,ppid,etime,cmd"

# ─────────────────────────────────────────────────────────────────────────────
section "5. Webshells conocidos — PHP en carpetas anómalas"
# ─────────────────────────────────────────────────────────────────────────────
log "# PHP dentro de build/assets/ (NUNCA debería haber — Vite solo emite .js/.css)"
cmd "find $HOME -type f -name '*.php' -path '*/build/assets/*' 2>/dev/null"

log ""
log "# PHP dentro de img/, images/, uploads/ (jamás legítimo en esos paths)"
cmd "find $HOME -type f -name '*.php' \( -path '*/public/img/*' -o -path '*/public/images/*' -o -path '*/public/uploads/*' -o -path '*/img/noticias/*' -o -path '*/img/subsidios/*' \) 2>/dev/null"

log ""
log "# .htaccess en carpetas de assets/imágenes (sospechoso — puede reactivar PHP)"
cmd "find $HOME -type f -name '.htaccess' \( -path '*/build/assets/*' -o -path '*/public/img/*' -o -path '*/public/images/*' -o -path '*/public/uploads/*' -o -path '*/img/noticias/*' -o -path '*/database/migrations/*' -o -path '*/vendor/*' \) 2>/dev/null -exec sh -c 'echo; echo \"=== {} ===\"; cat \"{}\"' \;"

log ""
log "# PHP fuera de public/ en Laravel (también sospechoso)"
cmd "find $HOME/*.drehuanuco.gob.pe -maxdepth 3 -type f -name '*.php' ! -path '*/public/*' ! -path '*/vendor/*' ! -path '*/app/*' ! -path '*/config/*' ! -path '*/database/*' ! -path '*/routes/*' ! -path '*/resources/*' ! -path '*/bootstrap/*' ! -path '*/tests/*' 2>/dev/null | head -40"

# ─────────────────────────────────────────────────────────────────────────────
section "6. Firmas de webshells en contenido PHP"
# ─────────────────────────────────────────────────────────────────────────────
PATRONES='is_fn_usable|assert\(\$_|eval\(\$_|eval\(base64_decode|eval\(gzinflate|eval\(str_rot13|preg_replace.*\/e|GS-NETCAT|gsocket|FilesMan|WSO [0-9]|c99shell|r57shell|LEVIATHAN|haxor|NAGATOTO|togel|slot ?gacor|Imunify.*License'

log "# Archivos .php con firmas conocidas (excluyendo vendor legítimo)"
cmd "grep -rlE \"$PATRONES\" --include='*.php' $HOME/*.drehuanuco.gob.pe $HOME/public_html 2>/dev/null | grep -vE '/vendor/(symfony|laravel|composer|nesbot|monolog|psr|phpunit|ramsey|guzzle|doctrine|league|nunomaduro|spatie|tijsverkoyen|brick|carbon|dragonmantank|egulias|fakerphp|filp|fruitcake|graham-campbell|laminas|lcobucci|nette|nikic|opis|phpseclib|phpstan|predis|pusher|ramsey|sebastian|swiftmailer|theseer|tinify|tweetnacl|twig|vlucas|voku|webmozart|ziptools)/' | head -80"

log ""
log "# Primeros 200 bytes de cada coincidencia (para clasificar rápido)"
MATCHES=$(grep -rlE "$PATRONES" --include='*.php' $HOME/*.drehuanuco.gob.pe $HOME/public_html 2>/dev/null | grep -vE '/vendor/(symfony|laravel|composer|nesbot|monolog|psr|phpunit|ramsey|guzzle|doctrine|league|nunomaduro|spatie|tijsverkoyen|brick|carbon|dragonmantank|egulias|fakerphp|filp|fruitcake|graham-campbell|laminas|lcobucci|nette|nikic|opis|phpseclib|phpstan|predis|pusher|ramsey|sebastian|swiftmailer|theseer|tinify|tweetnacl|twig|vlucas|voku|webmozart|ziptools)/' | head -40)
for f in $MATCHES; do
    log "--- $f ($(stat -c '%s bytes, mtime=%y' "$f" 2>/dev/null)) ---"
    head -c 400 "$f" 2>/dev/null | tee -a "$OUT" >/dev/null
    echo "" | tee -a "$OUT" >/dev/null
done

# ─────────────────────────────────────────────────────────────────────────────
section "7. Directorios con nombres sospechosos (típicos del atacante)"
# ─────────────────────────────────────────────────────────────────────────────
log "# Nombres con typosquat: Composser, Ascorts, Reguller, LEVIATHAN, haxor, Ascorddddd, additionalddddd, dasboard, pasges, beesmart"
cmd "find $HOME -type d \( -iname 'Composser' -o -iname 'Ascorts' -o -iname 'Reguller' -o -iname 'LEVIATHAN' -o -iname 'haxor*' -o -iname '*ddddd' -o -iname 'dasboard' -o -iname 'pasges' -o -iname 'beesmart' -o -iname 'caphca' -o -iname 'Builde' -o -iname 'Ascorddddd' -o -iname 'additionalddddd' -o -iname 'regionhuanuco' \) 2>/dev/null"

log ""
log "# Directorios con permisos 000 o 700 sin ejecutar (típico de archivos ocultos del atacante)"
cmd "find $HOME -type d \( -perm 000 -o -perm 100 -o -perm 200 -o -perm 300 \) 2>/dev/null | head -60"

# ─────────────────────────────────────────────────────────────────────────────
section "8. Archivos PHP modificados en los últimos 3 días (excluyendo ruido conocido)"
# ─────────────────────────────────────────────────────────────────────────────
cmd "find $HOME -type f -name '*.php' -mtime -3 ! -path '*/vendor/*' ! -path '*/node_modules/*' ! -path '*/storage/framework/*' ! -path '*/.cache/*' ! -path '*/drehco/.git/*' ! -path '*/bootstrap/cache/*' 2>/dev/null"

log ""
log "# Archivos (cualquier tipo) modificados hoy, fuera de logs/cache/stats"
cmd "find $HOME -type f -mtime -1 ! -path '*/storage/framework/*' ! -path '*/.cache/*' ! -path '*/vendor/*' ! -path '*/node_modules/*' ! -path '*/tmp/webalizer/*' ! -path '*/tmp/awstats/*' ! -path '*/logs/*' ! -path '*/.npm/*' ! -path '*/.cpanel/*' ! -path '*/drehco/.git/*' 2>/dev/null | head -100"

# ─────────────────────────────────────────────────────────────────────────────
section "9. Archivos grandes o archivos-comprimidos expuestos en public_html"
# ─────────────────────────────────────────────────────────────────────────────
cmd "ls -lah $HOME/public_html/ | grep -vE '^d' | head -60"
cmd "find $HOME/public_html -maxdepth 2 -type f \( -name '*.tar' -o -name '*.zip' -o -name '*.gz' -o -name '*.sql' -o -name '.env*' -o -name '*.bak' -o -name '*.backup' \) 2>/dev/null"
cmd "find $HOME/*.drehuanuco.gob.pe -maxdepth 3 -type f \( -name '*.tar' -o -name '*.zip' -o -name '*.sql' -o -name '.env*' -o -name '*.bak' \) 2>/dev/null | head -40"

# ─────────────────────────────────────────────────────────────────────────────
section "10. Atributos inmutables (chattr +i) — típica persistencia de atacante"
# ─────────────────────────────────────────────────────────────────────────────
cmd "lsattr -R $HOME/public_html 2>/dev/null | grep -E '^[-]*i[-]*' | head -40"
cmd "lsattr -R $HOME/drehco 2>/dev/null | grep -E '^[-]*i[-]*' | head -20"
for d in $HOME/*.drehuanuco.gob.pe; do
    [ -d "$d" ] && lsattr -R "$d" 2>/dev/null | grep -E '^[-]*i[-]*' | head -5
done | tee -a "$OUT" >/dev/null

# ─────────────────────────────────────────────────────────────────────────────
section "11. /tmp y archivos temporales sospechosos"
# ─────────────────────────────────────────────────────────────────────────────
cmd "ls -la /tmp/ 2>/dev/null | head -60"
cmd "ls -la $HOME/tmp/ 2>/dev/null | head -60"
cmd "find /tmp -maxdepth 2 -type f \( -name '*.php' -o -name '*.sh' -o -name '*.py' -o -name '*.pl' \) 2>/dev/null"

# ─────────────────────────────────────────────────────────────────────────────
section "12. Conteo rápido por subdominio — PHP totales y modificados hoy"
# ─────────────────────────────────────────────────────────────────────────────
for d in $HOME/*.drehuanuco.gob.pe $HOME/public_html $HOME/drehco; do
    [ -d "$d" ] || continue
    total=$(find "$d" -type f -name '*.php' 2>/dev/null | wc -l)
    recent=$(find "$d" -type f -name '*.php' -mtime -3 ! -path '*/vendor/*' ! -path '*/.git/*' 2>/dev/null | wc -l)
    log "$(basename "$d"): total_php=$total  mod_ultimos_3d=$recent"
done

# ─────────────────────────────────────────────────────────────────────────────
section "13. .htaccess raros en todo el árbol"
# ─────────────────────────────────────────────────────────────────────────────
log "# .htaccess que contengan 'AddType', 'AddHandler', 'php_value', 'RewriteRule' hacia .php sospechoso, o php_flag"
cmd "grep -rlE 'AddType.*php|AddHandler.*php|SetHandler.*php|php_value auto_prepend|php_flag engine' --include='.htaccess' $HOME/*.drehuanuco.gob.pe $HOME/public_html 2>/dev/null"

# ─────────────────────────────────────────────────────────────────────────────
section "14. Logs de error PHP — posibles rastros de explotación"
# ─────────────────────────────────────────────────────────────────────────────
cmd "ls -la $HOME/logs/*.php.error.log 2>/dev/null"
for lg in $HOME/logs/*.php.error.log; do
    [ -f "$lg" ] || continue
    log "--- Últimas 30 líneas de $(basename "$lg") ---"
    tail -30 "$lg" 2>/dev/null | tee -a "$OUT" >/dev/null
done

# ─────────────────────────────────────────────────────────────────────────────
section "15. RESUMEN — lo más crítico en una sola vista"
# ─────────────────────────────────────────────────────────────────────────────
log "# PHP en build/assets (todos son webshells):"
find $HOME -type f -name '*.php' -path '*/build/assets/*' 2>/dev/null | tee -a "$OUT" >/dev/null

log ""
log "# PHP en img/images/uploads (todos son webshells):"
find $HOME -type f -name '*.php' \( -path '*/public/img/*' -o -path '*/public/images/*' -o -path '*/public/uploads/*' \) 2>/dev/null | tee -a "$OUT" >/dev/null

log ""
log "# .htaccess sospechosos:"
find $HOME -type f -name '.htaccess' \( -path '*/build/assets/*' -o -path '*/public/img/*' -o -path '*/public/images/*' -o -path '*/database/migrations/*' \) 2>/dev/null | tee -a "$OUT" >/dev/null

log ""
log "# Directorios con nombres de atacante:"
find $HOME -type d \( -iname 'LEVIATHAN' -o -iname 'haxor*' -o -iname '*ddddd' -o -iname 'Composser' -o -iname 'Ascorts' \) 2>/dev/null | tee -a "$OUT" >/dev/null

log ""
log "Auditoría terminada: $(date -u '+%Y-%m-%d %H:%M:%S UTC')"
log "Reporte completo: $OUT"
log ""
echo ""
echo "✔ Reporte generado en: $OUT"
echo "  Tamaño: $(du -h "$OUT" | cut -f1)"
echo "  Descárgalo con: scp drehua5@drehuanuco.gob.pe:$OUT ."
