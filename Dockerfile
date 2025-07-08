# microservicioscondocker/Dockerfile
FROM bitnami/laravel:latest

# Copiar el script de arranque al contenedor
COPY entrypoint.sh /entrypoint.sh

# Dar permisos de ejecución
RUN chmod +x /entrypoint.sh

# Ajustar el entrypoint
ENTRYPOINT ["/entrypoint.sh"]
