#!/bin/bash

echo "Setting up Laravel AFK Game API..."

# Pull PHP 8.2 CLI image
docker pull php:8.2-cli

# Create a temporary container and install composer
docker run --rm -v $(pwd):/app -w /app php:8.2-cli bash -c "
    # Install system dependencies
    apt-get update && apt-get install -y git unzip curl

    # Install composer
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

    # Create Laravel project structure
    composer create-project laravel/laravel temp-laravel '10.*' --prefer-dist --no-scripts

    # Move files from temp-laravel to current directory
    cp -R temp-laravel/* . 2>/dev/null || true
    cp -R temp-laravel/.* . 2>/dev/null || true
    rm -rf temp-laravel

    echo 'Laravel installed successfully!'
"

# Copy environment file
if [ -f .env.example ]; then
    cp .env.example .env
fi

echo "Setup complete! Next steps:"
echo "1. Update .env file with your database credentials"
echo "2. Run: docker-compose up -d"
echo "3. Run: docker-compose exec app php artisan key:generate"
echo "4. Run: docker-compose exec app php artisan migrate"
