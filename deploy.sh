#!/usr/bin/env bash
#
# Upload the site to InfinityFree over FTP.
#
#   ./deploy.sh
#
# The password is never passed on the command line (it would land in your shell
# history and in `ps`). It comes from, in order:
#
#   1. $FTP_PASS, if you exported it
#   2. ~/.turbo-ftp-pass, if that file exists  (chmod 600 it)
#   3. a hidden prompt
#
# sql/ is deliberately never uploaded: it is only needed for the phpMyAdmin
# import, and seed.sql contains the admin password hash.

set -euo pipefail

# ftpupload.net, not the web server's IP - 185.27.134.128 has no FTP on port 21.
HOST="${FTP_HOST:-ftpupload.net}"
REMOTE_DIR="${FTP_REMOTE_DIR:-htdocs}"
PASS_FILE="$HOME/.turbo-ftp-pass"

# Deliberately no default account. This machine has more than one InfinityFree
# site, and a wrong default would upload Turbo Company over a different
# project's htdocs.
if [ -z "${FTP_USER:-}" ]; then
    echo "Set FTP_USER to this site's InfinityFree account, e.g." >&2
    echo "  FTP_USER=if0_00000000 ./deploy.sh" >&2
    exit 2
fi
USER="$FTP_USER"

if [ -n "${FTP_PASS:-}" ]; then
    PASS="$FTP_PASS"
elif [ -f "$PASS_FILE" ]; then
    PASS="$(cat "$PASS_FILE")"
else
    read -rsp "FTP password for $USER: " PASS
    echo
fi

cd "$(dirname "$0")"

echo "Uploading to ftp://$HOST/$REMOTE_DIR as $USER"
echo

# Refuse to upload into someone else's site. Anything already in htdocs that
# isn't ours or one of InfinityFree's own placeholder files means this is the
# wrong account, and uploading would overwrite same-named files (admin/,
# script.js and index.php collide with most PHP projects).
if [ "${FORCE:-0}" != "1" ]; then
    ours=" .htaccess admin contact.php images includes index.php install.php register.php script.js sql style.css "
    theirs=" . .. .override index2.html "
    strangers=""

    while IFS= read -r entry; do
        name="${entry##*/}"
        [ -z "$name" ] && continue
        # InfinityFree drops instructional files in an empty htdocs; ignore them.
        case "$name" in
            *"files for your website"*|*"DO NOT UPLOAD"*) continue ;;
        esac
        case "$ours$theirs" in
            *" $name "*) ;;
            *) strangers="$strangers  $name"$'\n' ;;
        esac
    done < <(curl -sS --connect-timeout 20 -u "$USER:$PASS" --list-only "ftp://$HOST/$REMOTE_DIR/" || true)

    if [ -n "$strangers" ]; then
        echo "Refusing to upload: $REMOTE_DIR already contains another project." >&2
        echo "$strangers" >&2
        echo "Check FTP_USER is the right account. Re-run with FORCE=1 to upload anyway." >&2
        exit 3
    fi
fi

uploaded=0
failed=0

# -print0/read -d '' so a space in a filename can't split an argument.
while IFS= read -r -d '' file; do
    rel="${file#./}"

    # --ftp-create-dirs makes images/, includes/ and admin/ on the way in.
    if curl -sS --ftp-create-dirs --connect-timeout 20 --max-time 120 \
            -u "$USER:$PASS" -T "$file" "ftp://$HOST/$REMOTE_DIR/$rel"; then
        printf '  ok    %s\n' "$rel"
        uploaded=$((uploaded + 1))
    else
        printf '  FAIL  %s\n' "$rel"
        failed=$((failed + 1))
    fi
done < <(
    find . -type f \
        -not -path './.git/*' \
        -not -path './sql/*' \
        -not -name 'README.md' \
        -not -name 'deploy.sh' \
        -not -name 'install.php' \
        -not -name '.DS_Store' \
        -print0
)

echo
echo "$uploaded uploaded, $failed failed"

if [ "$failed" -gt 0 ]; then
    exit 1
fi

cat <<'NEXT'

Still to do in the control panel:
  1. phpMyAdmin -> select the database -> Import sql/schema.sql, then sql/seed.sql
  2. Edit includes/config.php on the server with your MySQL host/name/user/password
  3. Log in at /admin/login.php and change the admin password
NEXT
