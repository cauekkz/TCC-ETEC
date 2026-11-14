FROM php:8.2-apache

RUN docker-php-ext-install pdo_mysql \
 && a2enmod rewrite headers \
 && sed -ri 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf \
 && { echo 'upload_max_filesize=50M'; echo 'post_max_size=60M'; echo 'date.timezone=America/Sao_Paulo'; } > /usr/local/etc/php/conf.d/etecconnect.ini

WORKDIR /var/www/html
