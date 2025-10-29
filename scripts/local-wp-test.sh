#!/usr/bin/env bash
set -euo pipefail

# Local WordPress smoke test for pre-commit.
# Requires a .env.local file with WP_PATH (and optional WP_URL, WP_CLI_BIN, PLUGIN_SLUG).

ROOT_DIR=$(cd "$(dirname "$0")/.." && pwd)
ENV_FILE="$ROOT_DIR/.env.local"

if [ ! -f "$ENV_FILE" ]; then
  echo "(local-wp-test) .env.local not found; skipping local WP smoke test"
  exit 0
fi

# shellcheck disable=SC2046
set -a && . "$ENV_FILE" && set +a

WP_CLI_BIN=${WP_CLI_BIN:-wp}
PLUGIN_SLUG=${PLUGIN_SLUG:-wpmoo-starter}

if [ -z "${WP_PATH:-}" ] || [ ! -d "$WP_PATH" ]; then
  echo "(local-wp-test) WP_PATH is not set or not a directory; skipping"
  exit 0
fi

echo "(local-wp-test) Using WP at: $WP_PATH"
if ! "$WP_CLI_BIN" --path="$WP_PATH" core is-installed >/dev/null 2>&1; then
  echo "(local-wp-test) WP-CLI cannot access WordPress at WP_PATH; skipping"
  exit 0
fi

echo "(local-wp-test) Building deployable package (zip)"
ZIP_PATH="$ROOT_DIR/../dist/${PLUGIN_SLUG}.zip"
php "$ROOT_DIR/vendor/bin/moo" deploy --wp --zip || {
  echo "(local-wp-test) moo deploy failed"; exit 1;
}

if [ ! -f "$ZIP_PATH" ]; then
  echo "(local-wp-test) Expected zip not found at $ZIP_PATH"; exit 1;
fi

echo "(local-wp-test) Installing plugin from zip and activating"
"$WP_CLI_BIN" --path="$WP_PATH" plugin install "$ZIP_PATH" --force --activate --quiet || {
  echo "(local-wp-test) Failed to install/activate plugin"; exit 1;
}

echo "(local-wp-test) Verifying activation"
if ! "$WP_CLI_BIN" --path="$WP_PATH" plugin is-active "$PLUGIN_SLUG" >/dev/null 2>&1; then
  echo "(local-wp-test) Plugin is not active after install"; exit 1;
fi

# Optional: run Plugin Check locally if available
if "$WP_CLI_BIN" --path="$WP_PATH" plugin is-installed plugin-check >/dev/null 2>&1; then
  echo "(local-wp-test) Running Plugin Check (plugin-check installed)"
  set +e
  "$WP_CLI_BIN" --path="$WP_PATH" plugin check "$PLUGIN_SLUG" --format=summary
  STATUS=$?
  set -e
  if [ "${LOCAL_STRICT:-0}" = "1" ] && [ $STATUS -ne 0 ]; then
    echo "(local-wp-test) Plugin Check failed (strict mode)"; exit $STATUS;
  fi
else
  echo "(local-wp-test) Plugin Check plugin not installed; skipping lint step"
fi

echo "(local-wp-test) OK — local WP smoke test passed"
exit 0

