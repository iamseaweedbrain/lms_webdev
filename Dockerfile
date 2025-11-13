# ============================================================
# 1️⃣ FRONTEND BUILD (React + Vite)
# ============================================================
FROM node:20-alpine AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm ci --no-audit --no-fund

# Copy only what's needed for the frontend build to keep layers small
COPY . .
RUN npm run build


# ============================================================
# 2️⃣ BACKEND (Laravel + PHP) - optimized for Render
# ============================================================
FROM php:8.2-fpm-alpine AS backend

# Install OS packages and PHP extensions required by Laravel
RUN apk add --no-cache \
    bash \
    git \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    icu-dev \
    tzdata \
 && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath intl gd

# Install Composer binary from the official composer image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first to leverage Docker layer caching
COPY composer.json composer.lock ./

# Install PHP dependencies without running scripts that may require runtime env vars
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts

# Copy application source
COPY . .

# Copy built frontend assets from Node build stage
COPY --from=frontend /app/public/build ./public/build

# Ensure writable directories for Laravel and set ownership
RUN mkdir -p storage bootstrap/cache \
 && chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

# Add an entrypoint script that will perform runtime tasks (caching, permissions) and start the app
COPY ./entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Expose a default port; Render provides $PORT at runtime so we respect it in the entrypoint
EXPOSE 8000

ENV PORT 8000

# Use the entrypoint which will exec the appropriate php serve command using $PORT
ENTRYPOINT ["/bin/sh", "-c", "/usr/local/bin/entrypoint.sh"]
