# AFK Game API - Quick Start Guide

## Configuration Done ✅

### Ports Updated:
- **API**: Port 9000 (changed from 8000)
- **MySQL**: Port 3308 (changed from 3306)
- **Redis**: Port 6379 (unchanged)

### Authentication System Implemented:
1. **AuthController** with endpoints:
   - `POST /api/auth/register` - Register new user
   - `POST /api/auth/login` - Login user
   - `POST /api/auth/logout` - Logout (requires auth)
   - `GET /api/auth/me` - Get current user (requires auth)

2. **Fake Users Seeder** created with 4 test users:
   - player1@example.com / password123
   - player2@example.com / password123  
   - admin@example.com / admin123
   - demo@example.com / demo123

3. **Comprehensive Unit Tests** (12 tests):
   - User registration (valid/invalid)
   - Login (correct/incorrect credentials)
   - Logout functionality
   - Profile retrieval
   - Validation checks
   - Authentication protection

## Next Steps

### 1. Start Docker Containers:
```bash
docker-compose up -d
```

### 2. Run Migrations:
```bash
docker-compose exec app php artisan migrate
```

### 3. Seed Test Users:
```bash
docker-compose exec app php artisan db:seed --class=UserSeeder
```

### 4. Run Tests:
```bash
docker-compose exec app php artisan test --filter=AuthenticationTest
```

### 5. Test the API:

**Register:**
```bash
curl -X POST http://localhost:9000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "New Player",
    "email": "newplayer@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

**Login:**
```bash
curl -X POST http://localhost:9000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "player1@example.com",
    "password": "password123"
  }'
```

**Get Profile (use token from login):**
```bash
curl -X GET http://localhost:9000/api/auth/me \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

## Files Created:
- ✅ `app/Http/Controllers/Api/AuthController.php`
- ✅ `app/Models/User.php` (updated with HasApiTokens)
- ✅ `database/seeders/UserSeeder.php`
- ✅ `database/seeders/DatabaseSeeder.php` (updated)
- ✅ `tests/Feature/Auth/AuthenticationTest.php` (12 comprehensive tests)
- ✅ `routes/api.php` (updated with auth routes)
- ✅ `docker-compose.yml` (ports updated)
- ✅ `.env.example` (ports updated)

## Project Status:
- Laravel 10.50.0 installed
- Laravel Sanctum configured
- Authentication system complete
- Unit tests ready
- Docker environment configured
