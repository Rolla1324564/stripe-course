#!/bin/bash
set -e

echo "🔧 Starting Render build process..."

# Install dependencies
echo "📦 Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev

# Generate APP_KEY if needed
echo "🔑 Setting up APP_KEY..."
php artisan key:generate --force

# Create database directory and file
echo "📁 Creating database directory..."
mkdir -p database
touch database/database.sqlite

# Run migrations
echo "🗄️ Running migrations..."
php artisan migrate:refresh --force --seed

# Install Node dependencies
echo "🟢 Installing NPM dependencies..."
npm install

# Build assets
echo "🎨 Building assets..."
npm run build

echo "✅ Build completed successfully!"
