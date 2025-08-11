#!/bin/sh

# Exit on any error
set -e

# Run Laravel optimizations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
# The --force flag is important in production to avoid prompts
php artisan migrate --force

# Start supervisord
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
