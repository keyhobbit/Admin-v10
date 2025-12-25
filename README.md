# AFK Game CMS - Deployment Ready

A modern Content Management System built with Laravel 10 for managing AFK-style games with blog integration.

## Project Structure

```
.
├── source_code/          # Laravel application code
│   ├── app/
│   ├── config/
│   ├── database/
│   ├── public/
│   ├── resources/
│   └── routes/
├── docker/               # Docker configuration
│   ├── docker-compose-local.yml    # Local development (port 9000)
│   ├── docker-compose-vps.yml      # VPS production (port 80)
│   ├── Dockerfile                   # Application container definition
│   ├── mysql/                       # MySQL configuration
│   ├── nginx/                       # Nginx configuration
│   └── php/                         # PHP configuration
├── ansible/              # Ansible deployment automation
│   ├── playbooks/        # Deployment playbooks (auto-selects docker-compose)
│   ├── inventory/        # Server inventory
│   ├── group_vars/       # Environment variables
│   └── templates/        # Configuration templates
├── deploy-vps.sh         # Quick deployment script
└── scripts/              # Helper scripts
```

## Quick Start (Local Development)

### Prerequisites
- Docker and Docker Compose v2+
- Git

### Option 1: Use Quick Start Script

```bash
chmod +x start.sh
./start.sh
```

### Option 2: Manual Setup

#### 1. Start the Application

```bash
# From project root
cd docker
sudo docker compose -f docker-compose-local.yml up -d
```

#### 2. Install Dependencies (First Time Only)

```bash
sudo docker compose -f docker-compose-local.yml exec app composer install
```

#### 3. Configure Environment (First Time Only)

```bash
# Copy environment file (if not exists)
cp source_code/.env.example source_code/.env

# Generate application key
sudo docker compose -f docker-compose-local.yml exec app php artisan key:generate

# Run migrations and seed database
sudo docker compose -f docker-compose-local.yml exec app php artisan migrate --seed

# Create storage link
sudo docker compose -f docker-compose-local.yml exec app php artisan storage:link
```

### 4. Access the Application

- **Frontend**: http://localhost:9000
- **Admin Panel**: http://localhost:9000/admin/login
- **Blog**: http://localhost:9000/blogs

### Default Admin Credentials

- **Super Admin**: superadmin@example.com / superadmin123
- **Admin**: admin@example.com / admin123

## Deployment to VPS

### Quick Deploy

Use the deployment script for easy deployment:

```bash
# Deploy to production (uses docker-compose-vps.yml with port 80)
./deploy-vps.sh production

# Deploy specific branch
./deploy-vps.sh production develop
```

### Manual Deployment with Ansible

```bash
# Deploy to production
ansible-playbook -i ansible/inventory/hosts ansible/playbooks/deploy.yml -e "target=production"

# Deploy to staging
ansible-playbook -i ansible/inventory/hosts ansible/playbooks/deploy.yml -e "target=staging"
```

### What the Deployment Does

The Ansible deployment automatically:
- Pulls latest code from GitHub
- Uses `docker-compose-vps.yml` for production (port 80)
- Uses `docker-compose-local.yml` for staging (port 9000)
- Installs composer dependencies (production mode)
- Sets proper permissions for storage and cache
- Creates cache and session tables
- Runs database migrations
- Caches config, routes, and views for performance
- Restarts containers

### Production Server

- **URL**: http://51.79.138.246
- **Admin Panel**: http://51.79.138.246/admin/login
- **SSH**: `ssh vps` (configured in SSH config)

### Server Setup (One-time)

```bash
cd ansible
ansible-playbook playbooks/setup.yml --extra-vars "target=production"
```

### Deploy Application (Legacy Method)

```bash
cd ansible
ansible-playbook playbooks/deploy.yml --extra-vars "target=staging"
```

### Rollback

```bash
cd ansible
ansible-playbook playbooks/rollback.yml --extra-vars "target=staging"
```

See [ansible/README.md](ansible/README.md) for detailed deployment documentation.

## Development

### Common Commands

```bash
# View logs
cd docker
sudo docker compose -f docker-compose-local.yml logs -f app

# Run artisan commands
sudo docker compose -f docker-compose-local.yml exec app php artisan <command>

# Access database
sudo docker compose -f docker-compose-local.yml exec mysql mysql -u game_user -pgame_password afk_game_db

# Clear cache
sudo docker compose -f docker-compose-local.yml exec app php artisan cache:clear

# Stop containers
sudo docker compose -f docker-compose-local.yml down

# Or use the stop script
./stop.sh

# Restart containers
sudo docker compose -f docker-compose-local.yml restart
```

### Running Tests

```bash
cd docker
sudo docker compose -f docker-compose-local.yml exec app php artisan test
```

## Technical Stack

- **Framework**: Laravel 10.50.0
- **Database**: MySQL 8.0
- **Cache**: Redis 7
- **Web Server**: Nginx (Alpine)
- **PHP**: 8.2-FPM
- **Frontend**: Bootstrap 5.3.0, Quill.js
- **Authentication**: Laravel Sanctum
- **Deployment**: Ansible

## Features

### Admin Panel
- User Management with RBAC
- Blog Management (CRUD, Rich Text Editor)
- Auto-sync from external sources
- Dashboard with statistics

### User Frontend
- Modern landing page
- User authentication
- Blog listing and detail pages
- Responsive design

## CI/CD Integration

The project includes Ansible playbooks for automated deployment. Integrate with:

- **GitHub Actions**: See `ansible/README.md`
- **GitLab CI**: See `ansible/README.md`
- **Jenkins**: Custom pipeline using Ansible playbooks

## Services

- **App (PHP-FPM)**: Port 9000 (internal)
- **Nginx**: Port 9000 (http://localhost:9000)
- **MySQL**: Port 3308 (host) → 3306 (container)
- **Redis**: Port 6380 (host) → 6379 (container)

## License

MIT License
