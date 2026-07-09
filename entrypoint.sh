#!/bin/sh

# Cambiar el marcador por el puerto dinámico de Render
sed -i "s/PORT_DINAMICO_RENDER/${PORT:-10000}/g" /etc/nginx/nginx.conf

# Limpiar y optimizar cachés de Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Arrancar servicios
php-fpm -D
nginx -g "daemon off;"