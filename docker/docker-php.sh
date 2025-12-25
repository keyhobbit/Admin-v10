#!/bin/bash

# Helper script to run Laravel commands via Docker
docker run --rm \
  --network="host" \
  -v $(pwd):/app \
  -w /app \
  php:8.2-cli \
  php "$@"
