# --- Build stage (composer deps) ---
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader

# --- Runtime stage (PHP + Apache) ---
FROM php:8.2-apache

# System deps + PHP extensions (adjust DB extension if needed)
RUN apt-get update && apt-get install -y \
    libzip-dev unzip \
 && docker-php-ext-install pdo pdo_mysql zip \
 && a2enmod rewrite \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copy app source
COPY . /var/www/html

# Copy vendor from build stage
COPY --from=vendor /app/vendor /var/www/html/vendor

# Apache: point DocumentRoot to /public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
 && sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
 && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Render provides PORT env var
EXPOSE 80
CMD ["apache2-foreground"]
