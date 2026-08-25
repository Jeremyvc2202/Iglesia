#!/bin/sh
set -e

# Puerto dinámico (Render, Railway o el que se defina en docker run -p)
sed -i "s/PORT_DINAMICO_RENDER/${PORT:-10000}/g" /etc/nginx/nginx.conf

# Asegurar la base de datos SQLite
mkdir -p /var/www/html/database
if [ ! -f /var/www/html/database/database.sqlite ]; then
    touch /var/www/html/database/database.sqlite
fi
chown www-data:www-data /var/www/html/database/database.sqlite

# Enlace público de storage (imágenes)
php artisan storage:link || true

# Ejecutar migraciones pendientes
php artisan migrate --force

# Cachear configuración para mejor rendimiento
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Arrancar servicios
php-fpm -D
nginx -g "daemon off;"
