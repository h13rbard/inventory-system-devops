FROM php:7.4-fpm

# Instalar nginx y dependencias
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    zip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mysqli \
        gd \
        zip \
        mbstring \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN mkdir -p /var/lib/php/sessions && \
    chown -R www-data:www-data /var/lib/php/sessions

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Composer cache layer
COPY composer.json composer.lock* ./

RUN composer install --no-dev --optimize-autoloader

# Copiar proyecto
COPY . .

# Config nginx
COPY docker/production/default.conf /etc/nginx/sites-available/default

# Permisos
RUN mkdir -p \
    application/cache \
    application/logs \
    public/images \
    && chown -R www-data:www-data /var/www \
    && chmod -R 775 application/cache \
    && chmod -R 775 application/logs \
    && chmod -R 775 public/images

EXPOSE 80

CMD ["sh", "-c", "nginx && php-fpm -F"]

