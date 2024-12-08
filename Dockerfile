FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . /var/www/html
WORKDIR /var/www/html

# Assuming vendor folder doesn't exist on host yet, run composer install in container
RUN composer install --no-interaction --optimize-autoloader

CMD ["php-fpm"]
