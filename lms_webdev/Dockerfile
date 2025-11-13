# 1️⃣ Use base PHP image
FROM php:8.2-cli

# 2️⃣ Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 3️⃣ Copy Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4️⃣ Set working directory
WORKDIR /var/www/html

# 5️⃣ Copy composer files first for layer caching
COPY composer.json composer.lock ./

# 6️⃣ Install PHP dependencies (no interaction)
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader --no-interaction --no-progress \
    && php -r "copy('.env.example', '.env');" || true \
    && php artisan key:generate || true


# 7️⃣ Copy rest of app
COPY . .

# 8️⃣ Expose port for Laravel serve
EXPOSE 8000

# 9️⃣ Start Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
