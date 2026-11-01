FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install \
        intl \
        mbstring \
        mysqli \
        pdo \
        pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chmod -R 775 writable

EXPOSE 8080

CMD php -S 0.0.0.0:${PORT:-8080} -t public
