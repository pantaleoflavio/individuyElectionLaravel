# Usa PHP 8.2 con FPM
FROM php:8.2-fpm

# Installiamo le estensioni PHP necessarie
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    curl \
    mariadb-client \
    && docker-php-ext-install pdo pdo_mysql zip

# Installiamo Composer manualmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Impostiamo la directory di lavoro
WORKDIR /var/www/html

# Impostiamo i permessi corretti per Laravel
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

EXPOSE 9000
