# --- Build stage: PHP dependencies ---
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
# --no-scripts: the app code isn't here yet, so Laravel's post-install scripts can't run in this stage.
RUN composer install --no-dev --prefer-dist --no-interaction --no-scripts --no-progress --optimize-autoloader

# --- Runtime stage: PHP + Apache ---
FROM php:8.2-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
        libzip-dev libpq-dev unzip \
 && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip \
 && a2enmod rewrite \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY . /var/www/html
COPY --from=vendor /app/vendor /var/www/html/vendor

# Serve from /public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
 && sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Rebuild the package manifest for production (dev packages are not installed)
RUN mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
 && php artisan package:discover --ansi \
 && chown -R www-data:www-data storage bootstrap/cache \
 && chmod +x docker/entrypoint.sh

# Render sets $PORT (default 10000); docker/entrypoint.sh points Apache at it.
EXPOSE 10000
ENTRYPOINT ["/var/www/html/docker/entrypoint.sh"]
CMD ["apache2-foreground"]
