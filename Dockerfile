# =========================================================================
# ETAPA 1: Construcción del Frontend
# =========================================================================
FROM node:20-alpine AS frontend-assets

WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN chmod -R +x node_modules/.bin
RUN npm run build

# =========================================================================
# ETAPA 2: Entorno de Ejecución (PHP + Nginx)
# =========================================================================
FROM php:8.3-fpm-alpine

# Instalar dependencias
RUN apk add --no-cache \
    nginx \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    libpq-dev \
    curl-dev \
    zip \
    unzip \
    git \
    bash

# Instalar extensiones PHP (incluyendo soporte para PostgreSQL)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql pdo_pgsql gd zip bcmath curl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Producción: debug desactivado (se puede activar con docker run -e APP_DEBUG=true)
ENV APP_DEBUG=false \
    APP_ENV=production

COPY . .
# Copiar configuración de PHP personalizada para aumentar límites de subida
COPY php.ini /usr/local/etc/php/conf.d/php.ini

COPY --from=frontend-assets /app/public/build ./public/build

# Instalar Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader --no-interaction

# --- CÓDIGO PARA PERMISOS ---
# Crear carpetas necesarias
RUN mkdir -p /var/www/html/storage/framework/sessions \
              /var/www/html/storage/framework/views \
              /var/www/html/storage/framework/cache \
              /var/www/html/storage/app/public \
              /var/www/html/storage/logs \
              /var/www/html/bootstrap/cache \
              /var/www/html/database

# Asignar permisos (storage, cache y database para SQLite)
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
# ---------------------------------

COPY nginx.conf /etc/nginx/nginx.conf
RUN chmod +x entrypoint.sh
RUN echo "clear_env = no" >> /usr/local/etc/php-fpm.d/www.conf

EXPOSE 10000
ENTRYPOINT ["/var/www/html/entrypoint.sh"]