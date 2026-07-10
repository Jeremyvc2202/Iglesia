#!/bin/sh

# Cambiar el marcador por el puerto dinámico de Render
sed -i "s/PORT_DINAMICO_RENDER/${PORT:-10000}/g" /etc/nginx/nginx.conf

# Intentamos limpiar caché solo si la app está lista, 
# pero no dejamos que un error aquí detenga el servidor
php artisan config:clear || true
php artisan view:clear || true

# Arrancar servicios
# PHP-FPM en primer plano para ver errores en los logs de Render
php-fpm -D
nginx -g "daemon off;"