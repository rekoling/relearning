# 🎓 Modern E-Learning System

A secure, modern PHP e-learning management system built with clean architecture principles and containerized deployment.

## 🚀 Features

- **User Authentication** - Secure login system for students and teachers
- **Course Materials** - Upload and manage learning materials
- **Interactive Quizzes** - Create and take quizzes with instant results
- **Discussion Forums** - Engage in course discussions
- **File Management** - Secure file uploads and downloads
- **Responsive Design** - Works on all devices

## 🏗️ Architecture

This application has been completely refactored from a legacy PHP codebase to modern standards:

- **MVC Pattern** - Clean separation of concerns
- **PSR-4 Autoloading** - Modern PHP class loading
- **Security First** - CSRF protection, prepared statements, input validation
- **Dockerized** - Easy deployment with Docker containers
- **Environment Configuration** - Secure configuration management

## 📁 Project Structure

```
project-root/
├── public/                 # Web-accessible files
│   ├── index.php          # Application entry point
│   ├── assets/            # CSS, JS, images
│   └── .htaccess          # Apache security rules
├── src/                   # Application source code
│   ├── Controllers/       # Request handlers
│   ├── Models/           # Data access layer
│   ├── Views/            # HTML templates
│   ├── Services/         # Business logic
│   ├── Database/         # Database utilities
│   ├── Utils/            # Helper classes
│   └── bootstrap.php     # Application initialization
├── config/               # Configuration files
│   ├── database.php      # Database settings
│   └── app.php          # Application settings
├── uploads/              # User uploaded files
├── logs/                 # Application logs
├── docker/               # Docker configuration
├── tests/                # Unit tests
├── composer.json         # PHP dependencies
├── Dockerfile           # Container build instructions
├── docker-compose.yml   # Multi-container setup
└── README.md            # This file
```

## 🔧 Installation & Setup

### Option 1: Docker (Recommended)

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd relearning
   ```

2. **Configure environment**
   ```bash
   cp .env.example .env
   # Edit .env with your settings
   ```

3. **Build and start containers**
   ```bash
   docker-compose up -d
   ```

4. **Access the application**
   - Main App: http://localhost:8080
   - phpMyAdmin: http://localhost:8081
   - Database: localhost:3307

### Option 2: Manual Setup

1. **Requirements**
   - PHP 8.1+
   - MySQL 8.0+
   - Composer
   - Web server (Apache/Nginx)

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure database**
   - Import `database/db_relearning.sql`
   - Configure `.env` file

4. **Set permissions**
   ```bash
   chmod -R 755 uploads logs
   ```

## 🔒 Security Features

### Fixed Security Issues:
- ✅ **SQL Injection** - All queries use prepared statements
- ✅ **CSRF Protection** - Token validation on all forms
- ✅ **XSS Prevention** - Input sanitization and output escaping
- ✅ **File Upload Security** - Type validation and secure storage
- ✅ **Session Security** - Secure session configuration
- ✅ **Input Validation** - Comprehensive validation framework

### Security Headers:
- X-Content-Type-Options: nosniff
- X-Frame-Options: DENY
- X-XSS-Protection: 1; mode=block
- Strict-Transport-Security (HTTPS)
- Content Security Policy

## 🛠️ Development

### Running Tests
```bash
composer test
```

### Code Quality
```bash
composer phpstan    # Static analysis
composer cs-check   # Code style check
composer cs-fix     # Fix code style
```

### Database Migrations
```bash
php artisan migrate
```

## 🐳 Docker Commands

```bash
# Start development environment
docker-compose up -d

# View logs
docker-compose logs -f app

# Execute commands in container
docker-compose exec app php validate-setup.php

# Stop all services
docker-compose down

# Production deployment
docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d
```

## 📊 Before/After Comparison

### Before (Legacy Code):
- ❌ Mixed HTML and PHP logic
- ❌ SQL injection vulnerabilities
- ❌ No input validation
- ❌ Hardcoded database credentials
- ❌ No error handling
- ❌ Inconsistent code structure

### After (Modern PHP):
- ✅ Clean MVC architecture
- ✅ All security vulnerabilities fixed
- ✅ Comprehensive input validation
- ✅ Environment-based configuration
- ✅ Proper error handling and logging
- ✅ PSR-4 autoloading and modern PHP standards

## 🚀 Deployment

### Development
```bash
docker-compose up -d
```

### Production
```bash
# Build production image
docker build --target production -t elearning-app .

# Deploy with production settings
docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d
```

## 🔍 Monitoring

- **Application Logs**: `logs/app.log`
- **Error Logs**: `logs/error.log`
- **Database**: phpMyAdmin interface
- **Health Check**: `/health` endpoint

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

If you encounter any issues:

1. Check the [validation script](#validation): `php validate-setup.php`
2. Review the logs: `docker-compose logs -f app`
3. Verify your `.env` configuration
4. Ensure all ports are available (8080, 3307, 8081)

## 🏆 Acknowledgments

- Built with modern PHP best practices
- Containerized with Docker
- Security-first approach
- Clean architecture patterns

---

**🔧 Generated with [Claude Code](https://claude.ai/code)**
