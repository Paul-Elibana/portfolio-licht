#!/bin/sh
set -e

# Remplace le port nginx avec $PORT fourni par Railway (défaut 8080)
PORT=${PORT:-8080}
sed -i "s/listen 8080;/listen ${PORT};/" /etc/nginx/nginx.conf

php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan optimize

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
