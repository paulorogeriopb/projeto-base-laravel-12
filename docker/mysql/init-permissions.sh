#!/bin/sh
set -e

echo "Corrigindo permissões de /var/lib/mysql dentro do container..."

chown -R mysql:mysql /var/lib/mysql
chmod -R 755 /var/lib/mysql

echo "Permissões corrigidas. Iniciando MySQL..."

# Chama o entrypoint original do MySQL
exec docker-entrypoint.sh mysqld
