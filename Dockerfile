FROM php:7.3.6-fpm-alpine3.9
RUN apk add bash mysql-client
RUN docker-php-ext-install pdo pdo_mysql
WORKDIR /var/www
RUN rm -rf /var/www/html
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN ln -s public html
COPY . /var/www/
RUN composer update
RUN composer install
EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]