#!/bin/sh
set -e

# Remplace le port nginx avec $PORT fourni par Railway (défaut 8080)
PORT=${PORT:-8080}
sed -i "s/listen 8080;/listen ${PORT};/" /etc/nginx/nginx.conf

# Initialiser la structure du storage (volume persistant Railway ou local)
mkdir -p storage/app/public/profile-photos
mkdir -p storage/app/public/projects
mkdir -p storage/app/public/assets
mkdir -p storage/logs
mkdir -p bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

php artisan migrate --force
php artisan db:seed --force
php artisan storage:link --force
php artisan optimize

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
