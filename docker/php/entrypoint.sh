#!/bin/sh
# Specifies this script should be executed using the Bourne shell
# Ensures script compatibility across different Linux distributions

# Enables "fail-fast" behavior
# If any command fails (returns non-zero exit status), the script immediately exits
# Preventing half-initialized containers from running
set -e

cd /var/www/html

php artisan migrate --force

# Replace this shell script with whatever command was passed to the container, and make it PID 1
exec "$@"
