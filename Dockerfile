FROM php:7-apache

COPY config/000-default.conf /etc/apache2/sites-available/
COPY src /var/www/

RUN rm -rf /var/www/html

RUN a2enmod headers

WORKDIR /var/www

HEALTHCHECK --interval=30s --timeout=3s CMD curl http://localhost/

EXPOSE 80
