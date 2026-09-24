FROM php:8.3-apache

RUN docker-php-ext-install pdo_pgsql pgsql \
    && a2enmod rewrite

COPY public/ /var/www/html/

# Render uses PORT=10000 by default for web services.
RUN sed -i 's/^Listen 80$/Listen 10000/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:10000>/' /etc/apache2/sites-available/000-default.conf

EXPOSE 10000

CMD ["apache2-foreground"]
