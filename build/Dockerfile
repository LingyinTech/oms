FROM php:7-fpm  
RUN apt-get update \
	&& apt-get install -y libzip-dev zlib1g-dev libpng-dev \
	&& rm -rf /var/lib/apt/lists/* \
	&& docker-php-ext-install pdo_mysql mbstring zip json \
	&& mkdir -p /data/www/myapp \
	&& ls ../

COPY ../ /data/www/myapp 
WORKDIR /data/www/myapp