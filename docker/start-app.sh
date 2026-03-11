#!/usr/bin/env sh
set -e

echo "Starting app bootstrap..."

git config --global --add safe.directory /var/www/html || true

php artisan optimize:clear
php artisan package:discover --ansi
php artisan migrate --force

if [ ! -f storage/.seeded ]; then
  php artisan db:seed
  touch storage/.seeded
fi

php artisan app:calculate-all-ranking-averages

exec php-fpm -F