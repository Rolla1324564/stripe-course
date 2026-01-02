#!/bin/sh
set -e

echo "Waiting for database to be ready..."
sleep 10

echo "Running migrations..."
php artisan migrate --force

echo "Seeding database with courses..."
php artisan db:seed --force

echo "Starting Laravel application on port 8080..."
php artisan serve --host=0.0.0.0 --port=8080
