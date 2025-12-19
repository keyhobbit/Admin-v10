# AFK Game CMS

A modern Content Management System built with Laravel 10 for managing AFK-style games with blog integration.

## Features

### Admin Panel
- **Dashboard**: Overview of system statistics and recent activities
- **User Management**: Manage administrators with role-based access control
- **Blog Management**: 
  - Full CRUD operations for blog posts
  - Rich text editor (Quill.js) with live preview
  - Category and status management (draft/published)
  - Auto-sync feature to import articles from external sources (genk.vn)
  - Image URL support with preview
  - SEO-friendly slugs
- **Authentication**: Secure admin login with session management

### User Frontend
- **Product Shop Style Homepage**: Modern landing page with hero section, features, and game showcase
- **User Authentication**: Separate login/registration system for end users
- **Blog System**: Public blog listing and article detail pages
- **Responsive Design**: Bootstrap 5-based UI optimized for all devices

### Technical Stack
- **Framework**: Laravel 10.50.0
- **Database**: MySQL 8.0
- **Cache**: Redis 7
- **Frontend**: Bootstrap 5.3.0, Quill.js
- **Authentication**: Laravel Sanctum, Session-based guards
- **Queue**: Laravel Horizon (configured)
- **Containerization**: Docker Compose

## Installation

### Prerequisites
- Docker and Docker Compose
- Git

### Setup

1. Clone the repository:
```bash
git clone git@github.com:keyhobbit/Admin-v10.git
cd Admin-v10
```

2. Start Docker containers:
```bash
docker-compose up -d
```

3. Install dependencies:
```bash
docker-compose exec app composer install
```

4. Copy environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
docker-compose exec app php artisan key:generate
```

6. Run migrations and seeders:
```bash
docker-compose exec app php artisan migrate --seed
```

## Usage

### Access Points

- **User Frontend**: http://localhost:9000
- **User Login**: http://localhost:9000/login
- **User Register**: http://localhost:9000/register
- **Blog**: http://localhost:9000/blogs
- **Admin Panel**: http://localhost:9000/admin/login

### Default Credentials

**Super Admin**:
- Email: `superadmin@example.com`
- Password: `superadmin123`

**Admin**:
- Email: `admin@example.com`
- Password: `admin123`

### Docker Services

- **App (PHP-FPM)**: Port 9000
- **MySQL**: Port 3308 (host) → 3306 (container)
- **Redis**: Port 6380 (host) → 6379 (container)
- **Nginx**: Port 9000

### Common Commands

```bash
# View logs
docker-compose logs -f app

# Run migrations
docker-compose exec app php artisan migrate

# Clear cache
docker-compose exec app php artisan cache:clear

# Access MySQL
docker-compose exec mysql mysql -u laravel -p

# Stop containers
docker-compose down
```

## Blog Management

### Creating Posts
1. Navigate to Admin Panel → Content Management → Blogs
2. Click "Create New Blog"
3. Use the Quill editor to format content
4. Switch to Preview tab to see how it will appear
5. Save as draft or publish immediately

### Auto-Sync Feature
- Click "Sync from Genk.vn" to automatically import top 10 articles
- Imported posts are saved as drafts for review
- Duplicate detection by source URL

## Development

### Project Structure
```
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Admin panel controllers
│   │   └── Auth/           # Authentication controllers
│   └── Models/             # Eloquent models
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/           # Database seeders
├── resources/
│   └── views/
│       ├── admin/         # Admin panel views
│       └── home/          # User frontend views
├── routes/
│   ├── web.php           # User routes
│   └── admin.php         # Admin routes
└── docker-compose.yml    # Docker configuration
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
