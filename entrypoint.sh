#!/bin/sh
set -e

echo "Waiting for database to be ready..."
sleep 10

echo "Running migrations..."
php artisan migrate --force

echo "Starting application..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
