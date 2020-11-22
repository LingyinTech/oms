FROM php:7-fpm  
RUN docker-php-ext-install pdo pdo_mysql mbstring 
RUN mkdir -p /data/www/myapp 
RUN ls ../
COPY ../ /data/www/myapp 
WORKDIR /data/www/myapp