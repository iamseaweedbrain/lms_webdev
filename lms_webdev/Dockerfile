# Use PHP CLI base image
FROM php:8.2-cli

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libsodium-dev \
    libpq-dev \
    default-mysql-client \
    default-libmysqlclient-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js & npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Install Node dependencies and build front-end assets
RUN npm install
RUN npm run build

# Laravel setup
RUN php artisan key:generate
RUN php artisan config:cache

# Expose Laravel port
EXPOSE 8000

# Start Laravel server
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
