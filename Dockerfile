FROM php:8.4-fpm

ARG user=projetos
ARG uid=1000

# Cria grupo e usuário com UID e GID específicos
RUN groupadd -g $uid $user \
    && useradd -m -u $uid -g $uid -G www-data,root -s /bin/bash $user \
    && mkdir -p /home/$user/.composer \
    && chown -R $user:$user /home/$user

# Instala dependências do sistema necessárias
RUN apt-get update && apt-get install -y \
    git curl nano procps lsof net-tools libpng-dev libonig-dev libxml2-dev zip unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copia configuração PHP customizada e script de start
COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Instala Node.js 20.x
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala extensões PHP necessárias
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# Copia o composer oficial para dentro do container PHP
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala e habilita a extensão Redis via PECL
RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

WORKDIR /var/www

USER root

# Copia todo o código antes para garantir autoload correto
COPY . .

# Instala dependências PHP
RUN composer install --no-interaction --no-progress --prefer-dist --optimize-autoloader

# Instala dependências Node.js
RUN npm install

# Ajusta permissões para o usuário criado
RUN chown -R $user:$user /var/www

# Configura git safe directory para evitar problemas de permissões
RUN git config --global --add safe.directory /var/www

# Volta a usar o usuário não-root para segurança
USER $user

EXPOSE 8080 5173

ENTRYPOINT ["/usr/local/bin/start.sh"]
