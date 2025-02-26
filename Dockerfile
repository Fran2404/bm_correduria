# Usa la imagen base de PHP 8.2 con FPM
FROM php:8.2-fpm

# Instala dependencias del sistema y extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    default-mysql-client\
    libpq-dev \
    && docker-php-ext-install pdo_mysql

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia el proyecto al contenedor
COPY . .

# Instala las dependencias de Composer
RUN composer install --no-scripts --no-interaction

# Permisos (ajusta según tu usuario local)
RUN chown -R www-data:www-data /var/www/html