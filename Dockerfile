FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
	supervisor \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    unzip \
  && rm -rf /var/lib/apt/lists/*

# Configure PHP extensions
RUN docker-php-ext-configure zip && \
    docker-php-ext-install -j$(nproc) zip pdo_mysql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www \
	&& useradd -u 1000 -ms /bin/bash -g www www

# Install application dependencies
COPY composer.json ./
RUN composer install --no-dev --optimize-autoloader

USER www

# Copy application code
COPY . .

USER root

# Configure supervisord
COPY ./.docker/supervisord/nginx.conf /etc/supervisor/conf.d/supervisord.conf
COPY ./.docker/php.ini.production /usr/local/etc/php/conf.d/app.ini

# Configure nginx
COPY ./.docker/nginx.conf /etc/nginx/sites-enabled/default

# Expose port 80 and start nginx
EXPOSE 80

# Let supervisord start nginx & php-fpm
ENTRYPOINT ["/bin/bash", "/var/www/html/.docker/start.sh"]

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]