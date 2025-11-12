FROM php:8.3-fpm

# Dependências do Laravel e build
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev zip unzip git \
    libsqlite3-dev $PHPIZE_DEPS \
 && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd \
 && docker-php-ext-install pdo_sqlite sqlite3 \
 # PCOV para coverage
 && pecl install pcov \
 && docker-php-ext-enable pcov \
 && echo "pcov.enabled=1" > /usr/local/etc/php/conf.d/pcov.ini \
 && echo "pcov.directory=/var/www/html" >> /usr/local/etc/php/conf.d/pcov.ini \
 && echo "pcov.exclude=~(vendor|storage|bootstrap)~" >> /usr/local/etc/php/conf.d/pcov.ini \
 # limpeza dos deps de build (mantém a extensão compilada)
 && apt-get purge -y --auto-remove $PHPIZE_DEPS \
 && rm -rf /var/lib/apt/lists/* /tmp/pear

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html