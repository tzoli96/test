#!/bin/sh

# Navigate to the working directory
cd /var/www/html

# Rename .env.example to .env if .env does not already exist
if [ ! -f .env ]; then
  cp .env.example .env
fi

# Rename database.sqlite.sample to database.sqlite if it does not already exist
if [ ! -f database/database.sqlite ]; then
  mv database/database.sqlite.sample database/database.sqlite
fi

# Run the artisan migrate command
php artisan migrate --force

# Run the artisan seed command to seed the database
php artisan db:seed --force

# Call the default command
exec "$@"
