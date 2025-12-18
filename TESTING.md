# Testing Guide - AFK Game API

## 📊 Current Test Status

```
✅ 11 tests passing
✅ 30 assertions
✅ 0.46s execution time
```

## 🚀 Quick Start

### Run All Tests
```bash
./run-tests.sh
# or
docker-compose exec app php artisan test
```

### Run Specific Test Suites
```bash
./run-tests.sh auth      # Authentication tests only
./run-tests.sh unit      # Unit tests only
./run-tests.sh feature   # Feature tests only
./run-tests.sh compact   # Compact output
```

## 📁 Test Structure

```
tests/
├── Feature/
│   ├── Auth/
│   │   └── AuthenticationTest.php    ✅ 5 tests (register, login, logout, profile)
│   ├── CharacterTest.php              📋 Placeholder (for future game features)
│   ├── GameProfileTest.php            📋 Placeholder (for future game features)
│   ├── IdleProgressionTest.php        📋 Placeholder (for future game features)
│   └── ExampleTest.php                ✅ 1 test
└── Unit/
    ├── UserModelTest.php               ✅ 4 tests (model, tokens, revocation)
    └── ExampleTest.php                 ✅ 1 test
```

## ✅ Implemented Tests

### Authentication Tests (5 tests)

**File:** `tests/Feature/Auth/AuthenticationTest.php`

| Test | Endpoint | Status |
|------|----------|--------|
| User registration | `POST /api/auth/register` | ✅ |
| User login | `POST /api/auth/login` | ✅ |
| Invalid credentials | `POST /api/auth/login` | ✅ |
| User logout | `POST /api/auth/logout` | ✅ |
| Get user profile | `GET /api/auth/me` | ✅ |

### User Model Tests (4 tests)

**File:** `tests/Unit/UserModelTest.php`

- ✅ User can be created with factory
- ✅ User can create API tokens (Sanctum)
- ✅ User can have multiple tokens
- ✅ User tokens can be revoked

## 🧪 Test Examples

### Running Specific Tests

```bash
# Run only authentication tests
docker-compose exec app php artisan test tests/Feature/Auth/AuthenticationTest.php

# Run only user model tests
docker-compose exec app php artisan test tests/Unit/UserModelTest.php

# Run a specific test method
docker-compose exec app php artisan test --filter=test_user_can_login_with_valid_credentials
```

### Test Output Format

```bash
# Standard output
docker-compose exec app php artisan test

# Compact output (dots only)
docker-compose exec app php artisan test --compact

# Parallel execution (faster)
docker-compose exec app php artisan test --parallel
```

## 🔐 Test Authentication

All authentication tests use Laravel Sanctum with Bearer tokens:

```php
// Example from AuthenticationTest.php
$user = User::factory()->create();
$token = $user->createToken('test-token')->plainTextToken;

$response = $this->withHeaders([
    'Authorization' => 'Bearer ' . $token,
])->getJson('/api/auth/me');

$response->assertStatus(200);
```

## 🗄️ Test Database

Tests use `RefreshDatabase` trait:
- Database is reset before each test
- Migrations run automatically
- SQLite in-memory database (fast)
- No test data pollution

```php
use Illuminate\Foundation\Testing\RefreshDatabase;

class MyTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_example(): void
    {
        // Fresh database for each test
    }
}
```

## 📋 Test Data

### Seeded Users (for manual API testing)

| Email | Password | Purpose |
|-------|----------|---------|
| player1@example.com | password123 | Player account |
| player2@example.com | password123 | Player account |
| admin@example.com | admin123 | Admin account |
| demo@example.com | demo123 | Demo account |

### Factory Usage in Tests

```php
// Create user with factory
$user = User::factory()->create([
    'email' => 'test@example.com',
    'name' => 'Test User',
]);

// Create multiple users
$users = User::factory()->count(10)->create();
```

## 📝 Writing New Tests

### Feature Test Template

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MyFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_my_feature_works(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/my-endpoint', [
            'data' => 'value',
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }
}
```

### Unit Test Template

```php
<?php

namespace Tests\Unit;

use App\Models\MyModel;
use Tests\TestCase;

class MyModelTest extends TestCase
{
    public function test_model_method(): void
    {
        $model = new MyModel(['attribute' => 'value']);
        
        $result = $model->someMethod();
        
        $this->assertEquals('expected', $result);
    }
}
```

## 🎯 Testing Best Practices

1. **Descriptive Names**: Use clear test method names
   ```php
   public function test_user_can_login_with_valid_credentials(): void
   ```

2. **Arrange-Act-Assert**: Structure tests clearly
   ```php
   // Arrange
   $user = User::factory()->create();
   
   // Act
   $response = $this->postJson('/api/login', [/*...*/]);
   
   // Assert
   $response->assertStatus(200);
   ```

3. **Test One Thing**: Each test should verify one behavior

4. **Use Factories**: Don't manually create test data

5. **Clean Database**: Always use `RefreshDatabase` trait

## 🚦 Continuous Integration

### GitHub Actions Example

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Run tests
        run: |
          docker-compose up -d
          docker-compose exec -T app php artisan test
```

## 📊 Coverage (Future)

To enable code coverage, install Xdebug:

```dockerfile
# Add to Dockerfile
RUN pecl install xdebug && docker-php-ext-enable xdebug
```

Then run:
```bash
docker-compose exec app php artisan test --coverage
docker-compose exec app php artisan test --coverage-html coverage
```

## 🔮 Future Tests

### Game Profile Tests (Planned)
- View game profile
- Profile creation on first access
- Update profile data
- Level progression

### Character Tests (Planned)
- View character templates
- Recruit characters
- Upgrade characters
- Resource validation

### Idle Progression Tests (Planned)
- Calculate offline rewards
- Collect offline rewards
- Verify reward caps
- Income rate scaling

## 📚 Resources

- [Laravel Testing Docs](https://laravel.com/docs/10.x/testing)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [Laravel Sanctum Docs](https://laravel.com/docs/10.x/sanctum)
- [Testing Best Practices](https://laravel.com/docs/10.x/http-tests)

## 🛠️ Troubleshooting

### Tests not found
```bash
# Rebuild autoload
docker-compose exec app composer dump-autoload
```

### Database issues
```bash
# Clear and re-migrate
docker-compose exec app php artisan migrate:fresh
```

### Permission errors
```bash
# Fix permissions
sudo chmod -R 777 tests/ storage/ bootstrap/cache/
```

---

**Last Updated**: December 18, 2025  
**Test Framework**: PHPUnit 10.5.60  
**Laravel Version**: 10.50.0
