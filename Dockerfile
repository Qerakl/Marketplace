# Используем образ PHP
FROM php:8.3.15-fpm

# Устанавливаем нужные пакеты
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    nodejs \
    npm \
    git \
    curl \
    gnupg \
    cron \
    supervisor \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Создаем рабочую директорию
WORKDIR /var/www/html

# Копируем файлы проекта
COPY . /var/www/html

# Настроим права доступа
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

