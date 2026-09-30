# Gunakan image resmi Nginx yang sudah dilengkapi dengan PHP-FPM
FROM richarvey/nginx-php-fpm:latest

RUN apt-get update && apt-get install -y \
    libpq-dev pdo pgsql \
    && docker-php-ext-install pdo_pgsql

# Salin semua file proyek PHP kamu ke folder web server Nginx
COPY . /var/www/html

# Atur environment agar Nginx menggunakan index.php sebagai file utama
ENV DOCUMENT_ROOT=/var/www/html
ENV INDEX_FILE=index.php

# Expose port 80 untuk lalu lintas HTTP
EXPOSE 80