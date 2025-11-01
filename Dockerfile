# Usa PHP 8.2 con CLI (suficiente para Laravel)
FROM php:8.2-cli

# Instala dependencias del sistema y extensiones requeridas por Laravel y spatie/laravel-backup
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev zip curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instala Composer globalmente desde la imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Define el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Copia los archivos del proyecto Laravel al contenedor
COPY . .

# Instala dependencias PHP (sin scripts automáticos ni dependencias dev)
RUN composer install --optimize-autoloader --no-interaction --no-scripts --no-dev

# Limpia y prepara el caché de Laravel (ignora si falla por falta de .env)
RUN php artisan config:clear || true

# Expone un puerto (Railway usará su propio puerto dinámico)
EXPOSE 8080

# Comando de inicio: Laravel escuchando en el puerto que Railway asigna
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
