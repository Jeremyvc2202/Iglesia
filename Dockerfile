# =========================================================================
# ETAPA 1: Construcción del Frontend (Vite 8 + Tailwind v4)
# =========================================================================
FROM node:20-alpine AS frontend-assets

WORKDIR /app

# Copiar archivos de dependencias de Node
COPY package*.json ./

# Instalar módulos de Node
RUN npm ci

# Copiar el resto del proyecto para que Vite tenga acceso a las vistas y recursos
COPY . .

# CORRECCIÓN DE PERMISOS: Asegurar que Alpine le permita a Node ejecutar el binario de Vite
RUN chmod -R +x node_modules/.bin

# Compilar CSS y JS para producción usando Vite
RUN npm run build

# =========================================================================
# ETAPA 2: Entorno de Ejecución de la Aplicación (PHP + Nginx)
# =========================================================================
FROM php:8.3-fpm-alpine

# Instalar dependencias esenciales del sistema operativo Alpine
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

# Configurar e instalar extensiones de PHP críticas para Laravel y Base de Datos
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd zip bcmath

# Traer Composer oficial al contenedor
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar la estructura limpia del proyecto
COPY . .

# COPIAR LOS ASSETS YA COMPILADOS desde la Etapa 1 (Crucial para que funcione tu diseño)
COPY --from=frontend-assets /app/public/build ./public/build

# Instalar dependencias de Composer optimizadas para producción
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Asegurar permisos correctos para la escritura de cachés y subida de imágenes
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copiar configuraciones de servidores
COPY nginx.conf /etc/nginx/nginx.conf
RUN chmod +x entrypoint.sh

EXPOSE 10000

ENTRYPOINT ["/var/www/html/entrypoint.sh"]