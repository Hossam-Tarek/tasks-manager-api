#!/bin/sh
# Specifies this script should be executed using the Bourne shell
# Ensures script compatibility across different Linux distributions

# Enables "fail-fast" behavior
# If any command fails (returns non-zero exit status), the script immediately exits
# Preventing half-initialized containers from running
set -e

cd /var/www/html

# Set proper permissions for Laravel directories
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

php artisan migrate --force

# Replace this shell script with whatever command was passed to the container, and make it PID 1
exec "$@"
