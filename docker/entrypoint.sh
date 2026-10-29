#!/bin/sh
set -e

# Render memberikan port lewat variabel PORT
PORT="${PORT:-80}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

cd /var/www/html

php artisan config:clear

# Jalankan migrasi setiap start (aman, hanya menjalankan migrasi baru)
php artisan migrate --force

# Seeder hanya jika RUN_SEED=true (cukup sekali saja, lalu hapus variabelnya)
if [ "$RUN_SEED" = "true" ]; then
    php artisan db:seed --force
fi

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec apache2-foreground
