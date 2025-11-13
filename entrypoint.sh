#!/bin/sh
set -e

# If an APP_KEY is present, it's safe to cache config/routes/views.
# We run these at container start so environment variables (like DB creds)
# are available. If any command fails we don't want to crash the container,
# so we allow failures on cache commands and continue.
if [ -n "${APP_KEY}" ]; then
  echo "APP_KEY detected — warming caches"
  php artisan config:clear || true
  php artisan config:cache || true
  php artisan route:cache || true
  php artisan view:cache || true
fi

# Ensure storage and cache are writable by the web user
mkdir -p storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache || true
chmod -R 775 storage bootstrap/cache || true

echo "Starting Laravel using PORT=${PORT:-8000}"
# Exec the serve command so signals are forwarded correctly
exec php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
