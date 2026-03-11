# Usa PHP 8.2 con FPM
FROM php:8.2-fpm

# Impostiamo la directory di lavoro
WORKDIR /var/www/html

# Installiamo le estensioni PHP necessarie
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpq-dev \
    postgresql-client \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    unzip \
    git \
    curl \
    mariadb-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql pgsql zip gd \
    && rm -rf /var/lib/apt/lists/*

# Installiamo Composer manualmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiamo solo i file necessari per Composer (evita di ricreare la cache ad ogni build)
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Ora copiamo tutto il progetto
COPY . .

# Impostiamo i permessi corretti per Laravel
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Creiamo le cartelle necessarie per Laravel e impostiamo i permessi
RUN mkdir -p storage/framework/{sessions,cache,views} && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

RUN git config --global --add safe.directory /var/www/html

# Installa le dipendenze di Composer
RUN composer install --optimize-autoloader

EXPOSE 9000
