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
USER="${FTP_USER:-if0_42296674}"
REMOTE_DIR="${FTP_REMOTE_DIR:-htdocs}"
PASS_FILE="$HOME/.turbo-ftp-pass"

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
