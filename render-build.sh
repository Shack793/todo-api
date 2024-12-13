#!/usr/bin/env bash
# exit on error
set -o errexit

# Install PHP dependencies
composer install --no-dev --optimize-autoloader --no-interaction

# Generate app key if not set
php artisan key:generate --force

# Clear and cache config
php artisan config:clear
php artisan config:cache

# Run migrations
php artisan migrate --force

# Generate Swagger documentation
php artisan l5-swagger:generate

# Optimize the application
php artisan optimize
