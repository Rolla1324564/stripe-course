#!/bin/bash

echo "🚀 Starting application on Render..."

# Ensure database directory exists
mkdir -p database
touch database/database.sqlite

# Run any pending migrations (just in case)
php artisan migrate --force

# Start the PHP server
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
