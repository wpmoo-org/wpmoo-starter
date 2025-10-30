#!/usr/bin/env bash
set -euo pipefail

# Run WP Plugin Check against the currently installed plugin slug.
# Does not install, copy, or delete any files.

ROOT_DIR=$(cd "$(dirname "$0")/.." && pwd)
ENV_FILE="$ROOT_DIR/.env.local"

if [ ! -f "$ENV_FILE" ]; then
  echo "(plugin-check-only) .env.local not found; skipping"
  exit 0
fi

set -a && . "$ENV_FILE" && set +a

WP_CLI_BIN=${WP_CLI_BIN:-wp}
WP_PATH=${WP_PATH:-}
PLUGIN_SLUG=${PLUGIN_SLUG:-wpmoo-starter}
LOCAL_STRICT=${LOCAL_STRICT:-1}

if [ -z "$WP_PATH" ] || [ ! -d "$WP_PATH" ]; then
  echo "(plugin-check-only) WP_PATH not set or invalid; skipping"
  exit 0
fi

if ! "$WP_CLI_BIN" --path="$WP_PATH" core is-installed >/dev/null 2>&1; then
  echo "(plugin-check-only) WP-CLI cannot access WordPress at WP_PATH; skipping"
  exit 0
fi

FORMAT="json"; [ "$LOCAL_STRICT" = "1" ] && FORMAT="strict-json"

echo "(plugin-check-only) Checking installed plugin: $PLUGIN_SLUG"
TMP_OUT="$(mktemp)"
set +e
"$WP_CLI_BIN" --path="$WP_PATH" plugin check "$PLUGIN_SLUG" --format="$FORMAT" --ignore-codes=trademarked_term >"$TMP_OUT" 2>&1
STATUS=$?
set -e

# Pretty print
php "$ROOT_DIR/scripts/plugin-check-pretty.php" "$TMP_OUT" "$PLUGIN_SLUG" || cat "$TMP_OUT"
rm -f "$TMP_OUT"

if [ "$LOCAL_STRICT" = "1" ] && [ $STATUS -ne 0 ]; then
  echo "(plugin-check-only) Plugin Check failed (strict mode)"
  exit $STATUS
fi

echo "(plugin-check-only) OK"
exit 0
