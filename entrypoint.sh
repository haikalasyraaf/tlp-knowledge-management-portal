#!/bin/bash

# Wait for PostgreSQL to be ready
echo "Waiting for PostgreSQL..."
until pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USERNAME" > /dev/null 2>&1; do
  sleep 2
done

echo "PostgreSQL is ready, running migrations..."
php artisan migrate --force

# Start Apache
apache2-foreground
