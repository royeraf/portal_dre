#!/bin/bash
# cleanup-vps.sh — Remediación priorizada basada en audit-report.txt
# Ejecutar como el usuario drehua5 (no root). Registra todo en ~/cleanup-report.txt
# Uso: bash cleanup-vps.sh         -> modo DRY-RUN (muestra qué haría)
#      bash cleanup-vps.sh --apply -> ejecuta destructivamente

set -u
APPLY=0
[ "${1:-}" = "--apply" ] && APPLY=1

LOG="$HOME/cleanup-report.txt"
: > "$LOG"
TS() { date '+%F %T'; }
log() { echo "[$(TS)] $*" | tee -a "$LOG"; }
run() {
  # run <descripcion> <comando...>
  local desc="$1"; shift
  log "== $desc =="
  log "  CMD: $*"
  if [ $APPLY -eq 1 ]; then
    eval "$@" 2>&1 | tee -a "$LOG"
    log "  RC: ${PIPESTATUS[0]}"
  else
    log "  (dry-run, no ejecutado)"
  fi
}
rm_if() {
  # rm_if <ruta>
  local p="$1"
  if [ -e "$p" ] || [ -L "$p" ]; then
    run "eliminar $p" "rm -rf -- '$p'"
  else
    log "-- ya no existe: $p"
  fi
}

log "###############################################"
log "# cleanup-vps.sh  modo=$([ $APPLY -eq 1 ] && echo APPLY || echo DRY-RUN)"
log "# host=$(hostname) user=$(whoami) fecha=$(TS)"
log "###############################################"

HOME_DREHUA=/home/drehua5

########################################
# 1) MATAR PROCESOS DEL ATACANTE
########################################
log ""
log "############ 1) PROCESOS SOSPECHOSOS ############"
run "pkill gsocket/LiteSpeeds/kworker disfrazado"   "pkill -U \$(id -u) -f '\\[LiteSpeeds\\]' ; pkill -U \$(id -u) -f '\\[kworker\\]' ; pkill -U \$(id -u) -f 'kontol' ; pkill -U \$(id -u) -f '/.cache/trash/kontol' ; pkill -U \$(id -u) -f '/.config/htop/core'"
run "listar procesos del usuario después de kill"   "ps -fU \$(whoami)"

########################################
# 2) SHELL RC FILES (.bashrc / .zshrc)
########################################
log ""
log "############ 2) LIMPIEZA SHELL RC ############"
# .bashrc: ya existe versión limpia
if [ -f "$HOME/.bashrc.clean" ]; then
  run "backup .bashrc actual"    "cp -a '$HOME/.bashrc' '$HOME/.bashrc.infected.\$(date +%s)'"
  run "aplicar .bashrc.clean"    "mv -f '$HOME/.bashrc.clean' '$HOME/.bashrc'"
else
  # fallback: strip lines con firmas
  run "backup .bashrc"           "cp -a '$HOME/.bashrc' '$HOME/.bashrc.infected.\$(date +%s)'"
  run "strip firmas de .bashrc"  "sed -i '/kontol-kernel/d; /core-kernel/d; /DO NOT REMOVE THIS LINE. SEED PRNG/d; /base64 -d|bash/d' '$HOME/.bashrc'"
fi

# .zshrc: construir versión limpia
if [ -f "$HOME/.zshrc" ]; then
  run "backup .zshrc"            "cp -a '$HOME/.zshrc' '$HOME/.zshrc.infected.\$(date +%s)'"
  run "strip firmas de .zshrc"   "sed -i '/kontol-kernel/d; /core-kernel/d; /DO NOT REMOVE THIS LINE. SEED PRNG/d; /base64 -d|bash/d' '$HOME/.zshrc'"
fi

# verificar que no queden líneas infectadas
run "grep residuos bash/zsh rc"  "grep -En 'kontol|SEED PRNG|base64 -d\\|bash' '$HOME/.bashrc' '$HOME/.zshrc' 2>/dev/null || echo OK_limpio"

########################################
# 3) authorized_keys: dejar SOLO llave legítima
########################################
log ""
log "############ 3) authorized_keys ############"
SSH_DIR="$HOME/.ssh"
AK="$SSH_DIR/authorized_keys"
LEGIT_KEY='ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAINzn2PSnLV5Nd7xxgvXDBSjOUaIfG3jMDkbOG2wmDYD/ royer@royeraf'

if [ -d "$SSH_DIR" ]; then
  run "snapshot .ssh"           "ls -la '$SSH_DIR' && cat '$AK' 2>/dev/null"
  run "backup authorized_keys"  "cp -a '$AK' '$AK.pre_clean.\$(date +%s)' 2>/dev/null || true"
  run "escribir solo llave legítima" "printf '%s\\n' \"$LEGIT_KEY\" > '$AK' && chmod 600 '$AK'"
  rm_if "$SSH_DIR/authorized_keys.bak"
  rm_if "$SSH_DIR/authorized_keys.new"
  run "verificar authorized_keys final" "cat '$AK'"
fi

########################################
# 4) QUITAR chattr +i DE index.php
########################################
log ""
log "############ 4) chattr -i ############"
run "quitar inmutable index.php"   "chattr -i '$HOME_DREHUA/public_html/index.php' 2>&1 || echo 'chattr requiere root: pedir a soporte cPanel'"
run "lsattr index.php"             "lsattr '$HOME_DREHUA/public_html/index.php' 2>&1 || true"

########################################
# 5) ELIMINAR WEBSHELLS ACTIVAS
########################################
log ""
log "############ 5) WEBSHELLS ############"
WEBSHELLS=(
  "$HOME_DREHUA/datos.drehuanuco.gob.pe/public/build/assets/index.php"
  "$HOME_DREHUA/datos.drehuanuco.gob.pe/public/system/index.php"
  "$HOME_DREHUA/datos.drehuanuco.gob.pe/public/system/program.php"
  "$HOME_DREHUA/datos.drehuanuco.gob.pe/public/system/list.txt"
  "$HOME_DREHUA/datos.drehuanuco.gob.pe/public/system/.htaccess"
  "$HOME_DREHUA/datos.drehuanuco.gob.pe/public/system/sitemap.xml"
  "$HOME_DREHUA/visitas.drehuanuco.gob.pe/public/images/index.php"
  "$HOME_DREHUA/visitas.drehuanuco.gob.pe/public/images/logo_principal.php"
  "$HOME_DREHUA/visitas.drehuanuco.gob.pe/public/uploads/images/2020-1280-08/Content/G8dmk.php"
  "$HOME_DREHUA/enlinea.drehuanuco.gob.pe/public/img/logominedu/defaults.php"
  "$HOME_DREHUA/enlinea.drehuanuco.gob.pe/public/img/logominedu/index.php"
  "$HOME_DREHUA/public_html/convocatoriaweb/index.php"
  "$HOME_DREHUA/atencionmesadepartes.drehuanuco.gob.pe/public/vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Calculation/Financial/CashFlow/Constant/Periodic/index.php"
  "$HOME_DREHUA/atencionmesadepartes.drehuanuco.gob.pe/public/ass.php"
  "$HOME_DREHUA/auladgp.drehuanuco.gob.pe/backup/moodle2/tests/fixtures/ALFA_DATA/alfacgiapi/lastp-hidden.php"
)
for f in "${WEBSHELLS[@]}"; do rm_if "$f"; done

# si existe el dir completo ALFA_DATA, mandarlo a la basura
rm_if "$HOME_DREHUA/auladgp.drehuanuco.gob.pe/backup/moodle2/tests/fixtures/ALFA_DATA"

########################################
# 6) .htaccess BACKDOORS
########################################
log ""
log "############ 6) .htaccess backdoors ############"
HTACCESS_BACKDOORS=(
  "$HOME_DREHUA/visitas.drehuanuco.gob.pe/public/images/.htaccess"
  "$HOME_DREHUA/enlinea.drehuanuco.gob.pe/public/img/logominedu/.htaccess"
  "$HOME_DREHUA/enlinea.drehuanuco.gob.pe/public/vendor/js/fullcalendar/lib/cupertino/images/.htaccess"
  "$HOME_DREHUA/datos.drehuanuco.gob.pe/public/build/assets/.htaccess"
  "$HOME_DREHUA/public_html/database/migrations/simbio/.htaccess"
  "$HOME_DREHUA/public_html/digital/vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Shared/Escher/DggContainer/BstoreContainer/.htaccess"
  "$HOME_DREHUA/public_html/digital/vendor/hamcrest/hamcrest-php/tests/Hamcrest/Text/api/.htaccess"
  "$HOME_DREHUA/public_html/digital/vendor/swiftmailer/swiftmailer/lib/classes/Swift/Transport/Esmtp/Auth/.htaccess"
)
for f in "${HTACCESS_BACKDOORS[@]}"; do
  if [ -f "$f" ]; then
    run "mostrar contenido antes de borrar $f" "cat '$f'"
    rm_if "$f"
  fi
done

########################################
# 7) DIRECTORIOS TIPOSQUAT DEL ATACANTE
########################################
log ""
log "############ 7) directorios typosquat ############"
TYPOSQUAT=(
  "$HOME_DREHUA/convocatoria.drehuanuco.gob.pe/public/ubigeo/peru_2016_departamentos/2016/caphca"
  "$HOME_DREHUA/convocatoria.drehuanuco.gob.pe/storage/app/public/formaciones_pdf/Ascorts"
  "$HOME_DREHUA/.trash/public/auth/additionalddddd"
  "$HOME_DREHUA/.trash/public/vendor/maennchen/zipstream-php/guides/Symfony/Ascorddddd"
  "$HOME_DREHUA/.trash/PhpSpreadsheet/Calculation/Financial/CashFlow/Constant/Periodic/LEVIATHAN"
  "$HOME_DREHUA/enlinea.drehuanuco.gob.pe/public/vendor/fontawesome-free/webfonts/solid-900/Reguller"
  "$HOME_DREHUA/public_html/siadpro2024/public/favicons/Composser"
  "$HOME_DREHUA/public_html/lang/en/pasges/beesmart"
  "$HOME_DREHUA/public_html/lang/en/pasges"
  "$HOME_DREHUA/bienvenidos.drehuanuco.gob.pe/regionhuanuco/asset/dasboard"
  "$HOME_DREHUA/menuinfo.drehuanuco.gob.pe/js/Ascorts"
  "$HOME_DREHUA/constancias.drehuanuco.gob.pe/vendor/fakerphp/faker/src/Faker/Container/ContainerBuilder/Builde"
)
for d in "${TYPOSQUAT[@]}"; do rm_if "$d"; done

########################################
# 8) ARCHIVOS EXPUESTOS (backups/env/sql/zip)
########################################
log ""
log "############ 8) backups y credenciales expuestos ############"
EXPOSED=(
  "$HOME_DREHUA/public_html/.BACKUP17042026.tar"
  "$HOME_DREHUA/public_html/.backup17042026.tar"
  "$HOME_DREHUA/public_html/gestion/.env"
  "$HOME_DREHUA/public_html/digital/.env"
  "$HOME_DREHUA/public_html/siadpro2024/.env"
  "$HOME_DREHUA/public_html/edusalud/.env"
  "$HOME_DREHUA/public_html/edusalud2023/.env"
  "$HOME_DREHUA/public_html/prevaed/admin.zip"
  "$HOME_DREHUA/public_html/prevaed/drehuan1_prevaed (2).sql"
  "$HOME_DREHUA/public_html/plantillas/eduglobal.zip"
  "$HOME_DREHUA/public_html/siadpro2024/drehua5_SIADPRO2024.sql"
  "$HOME_DREHUA/public_html/siadpro2024/dbsiadpro.sql"
  "$HOME_DREHUA/public_html/edusalud/.vscode.zip"
  "$HOME_DREHUA/enlinea.drehuanuco.gob.pe/drehua5_certificados14042026.sql"
  "$HOME_DREHUA/visitas.drehuanuco.gob.pe/drehco5_VISITAS.sql"
)
for f in "${EXPOSED[@]}"; do rm_if "$f"; done

# .env en raíz de subdominios: mover fuera de la raíz pública
log ""
log "-- .env en raíces de subdominios (mover a ~/envs_rescued/) --"
SUBDOMS=(constancias convocatoria datos documentos enlinea resoluciones reunion visitas)
if [ $APPLY -eq 1 ]; then mkdir -p "$HOME/envs_rescued"; fi
for s in "${SUBDOMS[@]}"; do
  f="$HOME_DREHUA/${s}.drehuanuco.gob.pe/.env"
  if [ -f "$f" ]; then
    run "mover $f → ~/envs_rescued/${s}.env" "mv '$f' '$HOME/envs_rescued/${s}.env'"
  fi
done

########################################
# 9) /tmp sospechosos (confirmar con usuario antes si no los reconoce)
########################################
log ""
log "############ 9) /tmp sospechosos ############"
TMPFILES=(/tmp/test_login.sh /tmp/tl.php /tmp/tl.sh)
for f in "${TMPFILES[@]}"; do
  if [ -f "$f" ]; then
    run "preview $f" "head -20 '$f'"
    rm_if "$f"
  fi
done

# sesión PHP del atacante activa reportada
rm_if "$HOME_DREHUA/tmp/sess_1e02e03dfd90dad70116912611c95c2d"

########################################
# 10) VERIFICACIONES FINALES
########################################
log ""
log "############ 10) VERIFICACIONES POST-LIMPIEZA ############"
run "PHP en build/assets (debería vacío)"  "find $HOME_DREHUA -path '*/build/assets/*.php' 2>/dev/null"
run "PHP en img/images/uploads (debería vacío)" "find $HOME_DREHUA \\( -path '*/img/*' -o -path '*/images/*' -o -path '*/uploads/*' \\) -name '*.php' 2>/dev/null"
run "firmas en rc files"                    "grep -lE 'kontol|SEED PRNG|base64 -d\\|bash' $HOME/.bashrc $HOME/.zshrc 2>/dev/null || echo OK"
run "authorized_keys final"                 "cat '$HOME/.ssh/authorized_keys' 2>/dev/null"
run "procesos del usuario"                  "ps -fU \$(whoami)"

log ""
log "###############################################"
log "# FIN cleanup  modo=$([ $APPLY -eq 1 ] && echo APPLY || echo DRY-RUN)"
log "# Reporte: $LOG"
log "###############################################"

cat <<'POST'

=============================================================
 SIGUIENTE PASO MANUAL (OBLIGATORIO — no lo hace este script):
=============================================================
  1. Rotar contraseñas en cPanel:
       - contraseña principal cPanel
       - todos los usuarios FTP
       - todos los usuarios MySQL (drehua5_* …)
  2. Rotar APP_KEY de cada Laravel:
       cd ~/drehco && php artisan key:generate
       (repetir en cada subdominio que sea Laravel)
  3. Revisar .env restaurados en ~/envs_rescued/ y poner
     credenciales nuevas antes de reusarlos.
  4. Si chattr -i falló: abrir ticket en cPanel/soporte para
     que root quite el flag de /home/drehua5/public_html/index.php
  5. Volver a correr ~/audit-vps.sh y verificar que el
     reporte salga limpio.
=============================================================
POST
