# Usa la imagen base de PHP 8.2 con FPM
FROM php:8.2-fpm

# Instala dependencias del sistema y extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    default-mysql-client \
    libpq-dev \
    libzip-dev \
    git \
    unzip \
    nano \
    && docker-php-ext-install pdo_mysql zip

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia el proyecto al contenedor
COPY . .

# Instala las dependencias de Composer
RUN composer install --no-scripts --no-interaction

# Crea el directorio var/log y asigna permisos
RUN mkdir -p /var/www/html/var/log \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html

# Cambia al usuario www-data para que PHP-FPM y los comandos se ejecuten como www-data
USER www-data