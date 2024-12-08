FROM php:8.2-fpm
LABEL authors="momo"

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libzip-dev libpq-dev zip unzip git curl && \
    docker-php-ext-install zip pdo_mysql pdo_pgsql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY . .

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

EXPOSE 9000

CMD ["php-fpm"]
