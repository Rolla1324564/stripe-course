FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    postgresql-client \
    git \
    curl \
    unzip \
    npm \
    supervisor \
    && docker-php-ext-install pdo pdo_pgsql

# Set working directory
WORKDIR /var/www/html

# Copy composer files
COPY composer.json composer.lock ./

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev --no-scripts

# Copy application files
COPY . .

# Run Laravel setup
RUN php artisan config:cache && \
    php artisan route:cache

# Copy Nginx configuration
COPY nginx.conf /etc/nginx/nginx.conf

# Install Node dependencies and build assets
RUN npm install && npm run build

# Create necessary directories
RUN mkdir -p storage/logs && \
    chmod -R 775 storage bootstrap/cache

# Copy supervisor configuration
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose port
EXPOSE 8080

# Start supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
