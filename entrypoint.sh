# microservicioscondocker/entrypoint.sh
#!/bin/bash
set -e

# Función para esperar a que MySQL esté listo
wait_for_mysql() {
  echo "⏳ Esperando a que MySQL esté disponible en ${DB_HOST}:${DB_PORT}..."
  until mysqladmin ping -h "${DB_HOST}" -P "${DB_PORT}" --silent; do
    sleep 1
  done
  echo "✅ MySQL listo"
}

# 0. Cargar variables de entorno de Laravel (si hace falta)
export $(grep -v '^#' /app/.env | xargs)

# 1. Esperar a que la base de datos esté lista
wait_for_mysql

# 2. Generar APP_KEY si aún no existe
if ! grep -q '^APP_KEY=' /app/.env || [ -z "$(grep '^APP_KEY=' /app/.env | cut -d '=' -f2)" ]; then
  echo "🔑 Generando APP_KEY..."
  php artisan key:generate --ansi
fi

# 3. Ejecutar migraciones pendientes
echo "🗄️  Ejecutando migraciones..."
php artisan migrate --force

# 4. Opcional: optimizar cachés (config, rutas, vistas)
echo "⚡ Optimizando caché de Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Lanzar el servidor (proceso principal de Bitnami)
echo "🚀 Iniciando servidor Laravel (Bitnami)..."
exec /opt/bitnami/scripts/laravel/run.sh

