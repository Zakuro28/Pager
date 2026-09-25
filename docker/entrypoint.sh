#!/bin/sh
# Container start-up for Render (or any Docker host).
set -e

cd /var/www/html

# Listen on the port the host gives us (Render sets $PORT, default 10000).
PORT="${PORT:-10000}"
sed -ri "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Render's generateValue gives a plain base64 string; Laravel expects the "base64:" prefix.
if [ -n "$APP_KEY" ] && [ "${APP_KEY#base64:}" = "$APP_KEY" ]; then
    export APP_KEY="base64:${APP_KEY}"
fi

# Use Render's public URL when APP_URL isn't set explicitly (used in email links).
if [ -z "$APP_URL" ] && [ -n "$RENDER_EXTERNAL_URL" ]; then
    export APP_URL="$RENDER_EXTERNAL_URL"
fi

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# Optional: create/promote the first admin from environment variables.
if [ -n "$ADMIN_EMAIL" ] && [ -n "$ADMIN_PASSWORD" ]; then
    php artisan pager:create-admin "$ADMIN_EMAIL" --name="Admin" --password="$ADMIN_PASSWORD" --no-interaction \
        || echo "WARNING: could not create the admin account (check ADMIN_EMAIL / ADMIN_PASSWORD, min 8 characters)."
fi

chown -R www-data:www-data storage bootstrap/cache

exec "$@"
