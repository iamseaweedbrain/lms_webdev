# 1. Use the official PHP image with FPM
FROM php:8.2-fpm

# 2. Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    curl \
    && docker-php-ext-install pdo pdo_mysql zip

# 3. Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4. Set working directory
WORKDIR /var/www/html

# 5. Copy project files
COPY . .

# 6. Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# 7. Set up Laravel key and cache config
RUN php artisan key:generate
RUN php artisan config:cache

# 8. Expose port (Laravel's default)
EXPOSE 8000

# 9. Start Laravel server
CMD php artisan serve --host=0.0.0.0 --port=8000
