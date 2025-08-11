# Estágio 1: Instalar dependências do Composer
FROM composer:2 as vendor
WORKDIR /app
COPY database/ /app/database/
COPY composer.json /app/
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --prefer-dist --ignore-platform-reqs

# Estágio 2: Construir assets de frontend
FROM node:18 as frontend
WORKDIR /app
COPY package.json package-lock.json /app/
RUN npm install
COPY . /app
RUN npm run build

# Estágio 3: Imagem final de produção
FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# Instalar dependências do sistema e extensões do PHP
RUN apk --no-cache add nginx supervisor curl libxml2-dev libzip-dev icu-dev freetype-dev libpng-dev libjpeg-turbo-dev gd
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_mysql zip intl exif gd

# Limpar cache do apk
RUN rm -rf /var/cache/apk/*

# Copiar código da aplicação
COPY . /var/www/html

# Copiar dependências e assets construídos
COPY --from=vendor /app/vendor/ /var/www/html/vendor/
COPY --from=frontend /app/public/build/ /var/www/html/public/build/

# Definir permissões
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expor porta 80
EXPOSE 80

# Copiar configurações (serão criadas a seguir)
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Iniciar Supervisor
ENTRYPOINT ["/usr/local/bin/start.sh"]
