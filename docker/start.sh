#!/bin/sh
set -e

export PORT="${PORT:-10000}"

php artisan migrate --force
php artisan db:seed --force
php artisan storage:link --force
php artisan config:cache
php artisan route:cache

envsubst '${PORT}' < /etc/nginx/sites-available/default.template > /etc/nginx/sites-available/default

php-fpm -D
nginx -g 'daemon off;'
