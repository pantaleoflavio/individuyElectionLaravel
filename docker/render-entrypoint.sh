#!/usr/bin/env sh
set -e

echo "Starting Render app bootstrap..."

git config --global --add safe.directory /var/www/html || true

php artisan optimize:clear
php artisan package:discover --ansi
php artisan migrate --force

if [ -n "${SUPERADMIN_EMAIL:-}" ]; then
  echo "Ensuring superadmin for ${SUPERADMIN_EMAIL}..."
  php artisan app:set-super-admin
else
  echo "SUPERADMIN_EMAIL not set, skipping superadmin promotion."
fi

php artisan app:calculate-all-ranking-averages || true

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"