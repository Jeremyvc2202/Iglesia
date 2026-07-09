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
    zip \
    unzip \
    git \
    bash

# Instalar extensiones PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd zip bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .
COPY --from=frontend-assets /app/public/build ./public/build

# Instalar Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader --no-interaction

# --- CÓDIGO NUEVO PARA PERMISOS ---
# Crear carpetas necesarias
RUN mkdir -p /var/www/html/storage/framework/sessions \
             /var/www/html/storage/framework/views \
             /var/www/html/storage/framework/cache \
             /var/www/html/storage/logs \
             /var/www/html/bootstrap/cache

# Asignar permisos totales (soluciona el Failed to open stream)
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
# ---------------------------------

COPY nginx.conf /etc/nginx/nginx.conf
RUN chmod +x entrypoint.sh

EXPOSE 10000
ENTRYPOINT ["/var/www/html/entrypoint.sh"]