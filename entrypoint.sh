# microservicioscondocker/entrypoint.sh
#!/bin/bash
set -e

# 1. Generar APP_KEY si aún no existe
if [ ! -f /app/.env ] || ! grep -q APP_KEY= /app/.env; then
  php artisan key:generate --ansi
fi

# 2. Limpiar caché de configuración y rutas
php artisan optimize:clear

# 3. Ejecutar migraciones (opcional)
php artisan migrate --force

# 4. Lanzar el proceso por defecto de Bitnami (inicio de servidor)
exec /opt/bitnami/scripts/laravel/run.sh
