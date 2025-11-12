FROM php:8.2-fpm

# System dependencies
RUN apt-get update && apt-get install -y \
    git zip unzip libzip-dev curl \
    && docker-php-ext-install pdo pdo_mysql zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Node.js & npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

WORKDIR /var/www/html
COPY . /var/www/html

# PHP deps
RUN composer install --optimize-autoloader --no-dev

# Node deps & build
RUN npm install
RUN npm run build

# Laravel setup
RUN php artisan key:generate
RUN php artisan config:cache

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
