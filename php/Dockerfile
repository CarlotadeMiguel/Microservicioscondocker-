FROM php:8.2-apache

# Instalar dependencias necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpq-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli zip

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Instalar Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar la app de Laravel (opcional, si no usas volumen)
# COPY ../laravel-app /var/www/html

# Asignar permisos (importante para Laravel)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
