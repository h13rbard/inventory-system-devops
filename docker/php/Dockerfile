FROM php:7.4-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mysqli \
        gd \
        zip

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www

# Copiar proyecto
COPY composer.json composer.lock ./
RUN composer install
COPY . .

# Permisos
RUN chown -R www-data:www-data /var/www
RUN mkdir -p /var/www/application/cache \
    && mkdir -p /var/www/application/logs \
    && mkdir -p /var/www/public/images \
    && chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/application/cache \
    && chmod -R 775 /var/www/application/logs \
    && chmod -R 775 /var/www/public/images

EXPOSE 9000

CMD ["php-fpm"]
