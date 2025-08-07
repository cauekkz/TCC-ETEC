FROM php:8.2-apache
LABEL maintainer="ich"
WORKDIR /app
COPY . /var/www/html/
RUN a2enmod rewrite
