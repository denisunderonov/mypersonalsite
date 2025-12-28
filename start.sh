#!/bin/bash

# Parse DATABASE_URL if it exists
if [ -n "$DATABASE_URL" ]; then
    # Extract components from postgresql://user:pass@host:port/db
    DB_USER=$(echo $DATABASE_URL | sed -E 's|postgresql://([^:]+):.*|\1|')
    DB_PASS=$(echo $DATABASE_URL | sed -E 's|postgresql://[^:]+:([^@]+)@.*|\1|')
    DB_HOST=$(echo $DATABASE_URL | sed -E 's|postgresql://[^@]+@([^:]+):.*|\1|')
    DB_PORT=$(echo $DATABASE_URL | sed -E 's|postgresql://[^:]+:[^@]+@[^:]+:([0-9]+)/.*|\1|')
    DB_NAME=$(echo $DATABASE_URL | sed -E 's|.*/([^/]+)$|\1|')
    
    export DB_HOST=$DB_HOST
    export DB_PORT=$DB_PORT
    export DB_DATABASE=$DB_NAME
    export DB_USERNAME=$DB_USER
    export DB_PASSWORD=$DB_PASS
    
    echo "Database configured: $DB_HOST:$DB_PORT/$DB_NAME"
fi

# Run migrations
php artisan migrate --force

# Start server
php artisan serve --host=0.0.0.0 --port=$PORT
