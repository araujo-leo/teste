FROM shinsenter/phpfpm-nginx:php7.4-alpine

# Install composer dependencies
COPY composer.json composer.lock /var/www/html/
RUN composer install --optimize-autoloader --working-dir=/var/www/html