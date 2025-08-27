#!/bin/sh
# Specifies this script should be executed using the Bourne shell
# Ensures script compatibility across different Linux distributions

# Enables "fail-fast" behavior
# If any command fails (returns non-zero exit status), the script immediately exits
# Preventing half-initialized containers from running
set -e

cd /var/www/html

# Check if composer.json exists
if [ ! -f "composer.json" ]; then
    exit 1
fi

# Install dependencies
composer install --no-interaction --optimize-autoloader --no-scripts
composer install --no-interaction --optimize-autoloader

# Verify vendor/autoload.php exists
if [ ! -f "vendor/autoload.php" ]; then
    exit 1
fi

# Set permissions
mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Generate app key if needed
if [ -f ".env" ] && (! grep -q "^APP_KEY=" .env || grep -q "^APP_KEY=$" .env); then
    php artisan key:generate --no-interaction
fi

# Run migrations
php artisan migrate --force

# Replace this shell script with whatever command was passed to the container, and make it PID 1
exec "$@"
