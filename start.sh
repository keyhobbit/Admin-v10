#!/bin/bash

# Quick Start Script for Local Development
# This script sets up the project for first-time use

set -e

echo "🚀 Starting AFK Game CMS Setup..."
echo ""

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo "❌ Docker is not running. Please start Docker and try again."
    exit 1
fi

echo "✅ Docker is running"

# Navigate to docker directory
cd "$(dirname "$0")/docker"

echo ""
echo "📦 Starting Docker containers..."
sudo docker compose -f docker-compose-local.yml up -d

echo ""
echo "⏳ Waiting for services to be ready..."
sleep 10

# Check if .env exists
if [ ! -f ../source_code/.env ]; then
    echo ""
    echo "📝 Creating .env file..."
    cp ../source_code/.env.example ../source_code/.env
    
    echo ""
    echo "🔑 Generating application key..."
    sudo docker compose -f docker-compose-local.yml exec -T app php artisan key:generate
fi

# Check if vendor directory exists
if [ ! -d ../source_code/vendor ]; then
    echo ""
    echo "📚 Installing Composer dependencies..."
    sudo docker compose -f docker-compose-local.yml exec -T app composer install
fi

# Check if migrations have been run
echo ""
echo "🗄️  Setting up database..."
sudo docker compose -f docker-compose-local.yml exec -T app php artisan migrate --seed || true

echo ""
echo "🔗 Creating storage link..."
sudo docker compose -f docker-compose-local.yml exec -T app php artisan storage:link || true

echo ""
echo "🎉 Setup complete!"
echo ""
echo "Access your application at:"
echo "  - Frontend: http://localhost:9000"
echo "  - Admin Panel: http://localhost:9000/admin/login"
echo "  - Blog: http://localhost:9000/blogs"
echo ""
echo "Default Admin Credentials:"
echo "  - Email: superadmin@example.com"
echo "  - Password: superadmin123"
echo ""
echo "Useful commands:"
echo "  - View logs: cd docker && sudo docker compose -f docker-compose-local.yml logs -f"
echo "  - Stop: cd docker && sudo docker compose -f docker-compose-local.yml down"
echo "  - Restart: cd docker && sudo docker compose -f docker-compose-local.yml restart"
echo ""
