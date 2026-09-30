# Gunakan image resmi Nginx yang sudah dilengkapi dengan PHP-FPM
FROM richarvey/nginx-php-fpm:latest

# Salin semua file proyek PHP kamu ke folder web server Nginx
COPY . /var/www/html

# Atur environment agar Nginx menggunakan index.php sebagai file utama
ENV DOCUMENT_ROOT=/var/www/html
ENV INDEX_FILE=index.php

# Expose port 80 untuk lalu lintas HTTP
EXPOSE 80