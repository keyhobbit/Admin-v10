#!/bin/bash

# AFK Game API - Test Runner Script
# Quick commands for running tests

echo "╔════════════════════════════════════════════╗"
echo "║     AFK Game API - Test Commands          ║"
echo "╚════════════════════════════════════════════╝"
echo ""

show_help() {
    echo "Usage: ./run-tests.sh [option]"
    echo ""
    echo "Options:"
    echo "  all              Run all tests (default)"
    echo "  auth             Run authentication tests only"
    echo "  unit             Run unit tests only"
    echo "  feature          Run feature tests only"
    echo "  user             Run user model tests"
    echo "  coverage         Run tests with coverage report"
    echo "  compact          Run tests with compact output"
    echo "  help             Show this help message"
    echo ""
}

case "$1" in
    auth)
        echo "🧪 Running Authentication Tests..."
        docker-compose exec -T app php artisan test tests/Feature/Auth/AuthenticationTest.php
        ;;
    unit)
        echo "🧪 Running Unit Tests..."
        docker-compose exec -T app php artisan test --testsuite=Unit
        ;;
    feature)
        echo "🧪 Running Feature Tests..."
        docker-compose exec -T app php artisan test --testsuite=Feature
        ;;
    user)
        echo "🧪 Running User Model Tests..."
        docker-compose exec -T app php artisan test tests/Unit/UserModelTest.php
        ;;
    coverage)
        echo "🧪 Running Tests with Coverage..."
        echo "⚠️  Note: Requires Xdebug to be installed"
        docker-compose exec -T app php artisan test --coverage
        ;;
    compact)
        echo "🧪 Running All Tests (Compact)..."
        docker-compose exec -T app php artisan test --compact
        ;;
    help)
        show_help
        ;;
    *)
        echo "🧪 Running All Tests..."
        docker-compose exec -T app php artisan test
        ;;
esac

echo ""
echo "✅ Test run complete!"
