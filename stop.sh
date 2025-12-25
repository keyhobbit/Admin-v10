#!/bin/bash

# Stop all Docker containers

cd "$(dirname "$0")/docker"

echo "🛑 Stopping Docker containers..."
sudo docker compose -f docker-compose-local.yml down

echo "✅ All containers stopped"
