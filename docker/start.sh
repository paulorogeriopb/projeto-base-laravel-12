#!/bin/bash
set -e

trap "kill 0" SIGINT SIGTERM EXIT

# Atualiza dependências do Composer e gera a key do Laravel
echo "Rodando composer update..."
composer update --no-interaction --no-progress

echo "Gerando a aplicação key..."
php artisan key:generate --force

if [ "$APP_ENV" = "production" ]; then
    echo "Building assets for production..."
    npm run build
    echo "Starting php-fpm..."
    exec php-fpm
else
    echo "Starting vite in dev mode and php-fpm..."
    npm run dev > /proc/1/fd/1 2>/proc/1/fd/2 &
    exec php-fpm
fi
