# Base image
FROM php:7.4.14-apache-buster

COPY . /var/www/html

RUN mkdir -p /var/www/html/public/storage

RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html
RUN chmod -R 775 /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/public/storage
RUN chmod -R 775 /var/www/html/storage
RUN mkdir -p /var/www/html/storage/logs

RUN apt-get update && apt-get install -y \
        unzip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        graphviz \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-source delete

RUN a2enmod rewrite
RUN a2enmod ssl
RUN service apache2 restart

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install \
        --ignore-platform-reqs \
        --no-interaction \
        --no-plugins \
        --no-scripts \
        --prefer-dist \
        --no-dev

RUN composer dump-autoload

RUN apt-get install --assume-yes mariadb-client-10.3

RUN php artisan config:clear \
&& php artisan view:clear \ 
&& php artisan route:clear \
&& php artisan cache:clear \
&& php artisan config:cache \
&& php artisan storage:link



#Local node js
# Install Node (with NPM), and Yarn (via package manager for Debian)
# https://nodejs.org/en/download/package-manager/#debian-and-ubuntu-based-linux-distributions

RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get update \
 && apt-get install -y nodejs \
 && npm install -g yarn \
 && apt-get -y install sudo \
 && apt-get -y install nano \
 && sudo apt-get install -y libgbm-dev

RUN npm install && npm run prod

# custom files
COPY utilities/build-files/00-default.conf /etc/apache2/sites-available/000-default.conf
COPY utilities/build-files/index.php /var/www/html/index.php
COPY utilities/build-files/public_index.php /var/www/html/public/index.php
COPY utilities/build-files/.htaccess /var/www/html/.htaccess

# ssh
ENV SSH_PASSWD "root:Docker!"
RUN apt-get install -y --no-install-recommends dialog \
    && apt-get install -y --no-install-recommends openssh-server \
    && echo "$SSH_PASSWD" | chpasswd 

COPY utilities/build-files/sshd_config /etc/ssh/
COPY utilities/build-files/init_container.sh /usr/local/bin/

RUN chmod u+x /usr/local/bin/init_container.sh
RUN chmod 644 /var/www/html/.htaccess

ENV PORT 80
ENV SSH_PORT 2222

EXPOSE 80 2222
EXPOSE 443 
EXPOSE 8080
