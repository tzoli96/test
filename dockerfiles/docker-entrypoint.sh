#!/bin/sh

# Navigate to the working directory
cd /var/www/html

# Rename .env.example to .env if .env does not already exist
if [ ! -f .env ]; then
  cp .env.example .env
fi

# Run the artisan migrate command
php artisan migrate --force

# Run the artisan seed command to seed the database

# Call the default command
exec "$@"
