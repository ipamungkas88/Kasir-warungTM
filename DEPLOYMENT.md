# 🚀 Production Deployment Guide - Warung TM

Panduan lengkap untuk deploy sistem kasir Warung TM ke production server.

## 📋 Table of Contents

- [Server Requirements](#server-requirements)
- [Pre-deployment Checklist](#pre-deployment-checklist)
- [Deployment Methods](#deployment-methods)
- [SSL Configuration](#ssl-configuration)
- [Database Setup](#database-setup)
- [Environment Configuration](#environment-configuration)
- [Performance Optimization](#performance-optimization)
- [Security Hardening](#security-hardening)
- [Monitoring & Logging](#monitoring--logging)
- [Backup Strategy](#backup-strategy)
- [Troubleshooting](#troubleshooting)

## 🖥️ Server Requirements

### Minimum Production Requirements:
- **OS**: Ubuntu 20.04+ / CentOS 8+ / Debian 11+
- **CPU**: 2 vCPU
- **RAM**: 4GB
- **Storage**: 20GB SSD
- **Bandwidth**: 100Mbps

### Recommended Production:
- **OS**: Ubuntu 22.04 LTS
- **CPU**: 4 vCPU
- **RAM**: 8GB
- **Storage**: 50GB SSD
- **Bandwidth**: 1Gbps

### Software Stack:
- **Web Server**: Nginx 1.18+ atau Apache 2.4+
- **PHP**: 8.2+ dengan FPM
- **Database**: MySQL 8.0+ atau MariaDB 10.6+
- **Process Manager**: Supervisor (untuk queue)
- **SSL**: Let's Encrypt atau SSL certificate

## ✅ Pre-deployment Checklist

### 1. Domain & DNS Setup
```bash
# Pastikan domain sudah pointing ke server
nslookup yourdomain.com

# Subdomain untuk callback (optional)
api.yourdomain.com -> Server IP
```

### 2. Server Access
```bash
# SSH access dengan key-based authentication
ssh -i ~/.ssh/your-key.pem user@server-ip

# Sudo access untuk user
sudo visudo
# Add: username ALL=(ALL) NOPASSWD:ALL
```

### 3. Backup Strategy
- Database backup automation
- File backup automation  
- Recovery testing plan

## 🚀 Deployment Methods

## Method 1: Manual Deployment (Recommended untuk pemula)

### 1. Server Setup
```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install required packages
sudo apt install -y nginx mysql-server php8.2 php8.2-fpm php8.2-mysql \
php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd \
php8.2-bcmath php8.2-intl git composer supervisor certbot \
python3-certbot-nginx

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs
```

### 2. Clone & Setup Application
```bash
# Clone repository
cd /var/www
sudo git clone https://github.com/ipamungkas88/Kasir-warungTM.git warungtm
cd warungtm

# Set ownership
sudo chown -R www-data:www-data /var/www/warungtm
sudo chmod -R 755 /var/www/warungtm
sudo chmod -R 775 /var/www/warungtm/storage
sudo chmod -R 775 /var/www/warungtm/bootstrap/cache

# Install dependencies
sudo -u www-data composer install --optimize-autoloader --no-dev
sudo -u www-data npm install
sudo -u www-data npm run build
```

### 3. Environment Configuration
```bash
# Copy environment file
sudo -u www-data cp .env.example .env

# Generate app key
sudo -u www-data php artisan key:generate

# Edit environment file
sudo nano .env
```

```env
# Production Environment Configuration
APP_NAME="Warung TM"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=warungtm_prod
DB_USERNAME=warungtm_user
DB_PASSWORD=secure_password_here

# Midtrans Production
MIDTRANS_SERVER_KEY=Mid-server-YOUR_PRODUCTION_SERVER_KEY
MIDTRANS_CLIENT_KEY=Mid-client-YOUR_PRODUCTION_CLIENT_KEY
MIDTRANS_IS_PRODUCTION=true
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true

# Session & Cache
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database

# Security
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
```

### 4. Database Setup
```bash
# Secure MySQL installation
sudo mysql_secure_installation

# Create database and user
sudo mysql -u root -p
```

```sql
CREATE DATABASE warungtm_prod CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'warungtm_user'@'localhost' IDENTIFIED BY 'secure_password_here';
GRANT ALL PRIVILEGES ON warungtm_prod.* TO 'warungtm_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

```bash
# Run migrations
sudo -u www-data php artisan migrate --force

# Seed initial data
sudo -u www-data php artisan db:seed --force
```

## Method 2: Docker Deployment

### 1. Create Dockerfile
```dockerfile
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    supervisor

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . .

# Install dependencies
RUN composer install --optimize-autoloader --no-dev
RUN npm install && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 80

CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]
```

### 2. Docker Compose
```yaml
version: '3.8'

services:
  app:
    build: .
    container_name: warungtm-app
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - ./:/var/www
      - ./docker/nginx:/etc/nginx/conf.d
    networks:
      - warungtm-network

  database:
    image: mysql:8.0
    container_name: warungtm-db
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: warungtm
      MYSQL_USER: warungtm
      MYSQL_PASSWORD: password
      MYSQL_ROOT_PASSWORD: rootpassword
    volumes:
      - db-data:/var/lib/mysql
    networks:
      - warungtm-network

  nginx:
    image: nginx:alpine
    container_name: warungtm-nginx
    restart: unless-stopped
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./:/var/www
      - ./docker/nginx:/etc/nginx/conf.d
      - ./docker/ssl:/etc/ssl/certs
    networks:
      - warungtm-network

volumes:
  db-data:

networks:
  warungtm-network:
    driver: bridge
```

## 🔒 SSL Configuration

### Let's Encrypt (Recommended)
```bash
# Install Certbot
sudo certbot --nginx -d yourdomain.com

# Auto-renewal
sudo crontab -e
# Add: 0 12 * * * /usr/bin/certbot renew --quiet
```

### Manual SSL Certificate
```bash
# Copy certificates
sudo mkdir -p /etc/ssl/certs/warungtm
sudo cp your-domain.crt /etc/ssl/certs/warungtm/
sudo cp your-domain.key /etc/ssl/certs/warungtm/
sudo cp ca-bundle.crt /etc/ssl/certs/warungtm/
```

## 🌐 Nginx Configuration

### Site Configuration
```nginx
# /etc/nginx/sites-available/warungtm
server {
    listen 80;
    server_name yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name yourdomain.com;
    root /var/www/warungtm/public;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self' http: https: data: blob: 'unsafe-inline'" always;

    # Basic Configuration
    index index.php;
    charset utf-8;
    
    # File Upload Size
    client_max_body_size 100M;

    # Main Location
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP-FPM Configuration
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    # Static Files
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # Security
    location ~ /\.(?!well-known).* {
        deny all;
    }
    
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
}
```

### Enable Site
```bash
# Enable site
sudo ln -s /etc/nginx/sites-available/warungtm /etc/nginx/sites-enabled/

# Test configuration
sudo nginx -t

# Restart services
sudo systemctl restart nginx
sudo systemctl restart php8.2-fpm
```

## ⚡ Performance Optimization

### 1. Laravel Optimization
```bash
# Cache configurations
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache

# Optimize autoloader
sudo -u www-data composer dump-autoload --optimize

# Optimize for production
sudo -u www-data php artisan optimize
```

### 2. Database Optimization
```sql
-- MySQL Configuration (/etc/mysql/mysql.conf.d/mysqld.cnf)
[mysqld]
innodb_buffer_pool_size = 2G
innodb_log_file_size = 256M
innodb_flush_log_at_trx_commit = 2
innodb_flush_method = O_DIRECT
max_connections = 200
query_cache_size = 64M
query_cache_type = 1
```

### 3. PHP-FPM Tuning
```ini
; /etc/php/8.2/fpm/pool.d/www.conf
[www]
user = www-data
group = www-data
listen = /var/run/php/php8.2-fpm.sock
listen.owner = www-data
listen.group = www-data
pm = dynamic
pm.max_children = 20
pm.start_servers = 4
pm.min_spare_servers = 2
pm.max_spare_servers = 6
pm.max_requests = 500
```

## 🔐 Security Hardening

### 1. Firewall Configuration
```bash
# Install UFW
sudo ufw enable

# Allow SSH, HTTP, HTTPS
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp

# Allow MySQL (only from localhost)
sudo ufw allow from 127.0.0.1 to any port 3306
```

### 2. File Permissions
```bash
# Set proper permissions
sudo find /var/www/warungtm -type f -exec chmod 644 {} \;
sudo find /var/www/warungtm -type d -exec chmod 755 {} \;
sudo chmod -R 775 /var/www/warungtm/storage
sudo chmod -R 775 /var/www/warungtm/bootstrap/cache
sudo chmod 600 /var/www/warungtm/.env
```

### 3. Disable Directory Browsing
```nginx
# In nginx config
location ~* /(?:\.git|storage|tests|database|resources/views) {
    deny all;
    return 404;
}
```

## 📊 Monitoring & Logging

### 1. Application Monitoring
```bash
# Laravel Log Monitoring
sudo tail -f /var/www/warungtm/storage/logs/laravel.log

# Nginx Access Logs
sudo tail -f /var/log/nginx/access.log

# Nginx Error Logs
sudo tail -f /var/log/nginx/error.log
```

### 2. System Monitoring (Optional)
```bash
# Install monitoring tools
sudo apt install htop iotop nethogs

# Monitor system resources
htop
iotop
nethogs
```

### 3. Log Rotation
```bash
# Laravel logs
sudo nano /etc/logrotate.d/laravel
```

```
/var/www/warungtm/storage/logs/*.log {
    daily
    missingok
    rotate 30
    compress
    notifempty
    copytruncate
}
```

## 💾 Backup Strategy

### 1. Database Backup Script
```bash
#!/bin/bash
# /home/user/scripts/backup-db.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/home/user/backups/database"
DB_NAME="warungtm_prod"
DB_USER="warungtm_user"
DB_PASS="secure_password_here"

mkdir -p $BACKUP_DIR

# Create backup
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/warungtm_$DATE.sql

# Compress backup
gzip $BACKUP_DIR/warungtm_$DATE.sql

# Remove old backups (keep last 30 days)
find $BACKUP_DIR -name "warungtm_*.sql.gz" -mtime +30 -delete

echo "Database backup completed: warungtm_$DATE.sql.gz"
```

### 2. File Backup Script
```bash
#!/bin/bash
# /home/user/scripts/backup-files.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/home/user/backups/files"
APP_DIR="/var/www/warungtm"

mkdir -p $BACKUP_DIR

# Backup application files (exclude vendor and node_modules)
tar -czf $BACKUP_DIR/warungtm_files_$DATE.tar.gz \
    --exclude="vendor" \
    --exclude="node_modules" \
    --exclude="storage/logs" \
    --exclude=".git" \
    -C /var/www warungtm

# Remove old backups (keep last 7 days)
find $BACKUP_DIR -name "warungtm_files_*.tar.gz" -mtime +7 -delete

echo "Files backup completed: warungtm_files_$DATE.tar.gz"
```

### 3. Automated Backup
```bash
# Add to crontab
sudo crontab -e

# Daily database backup at 2 AM
0 2 * * * /home/user/scripts/backup-db.sh

# Weekly file backup on Sunday at 3 AM
0 3 * * 0 /home/user/scripts/backup-files.sh
```

## 🔧 Troubleshooting

### Common Issues:

#### 1. 500 Internal Server Error
```bash
# Check Laravel logs
sudo tail -f /var/www/warungtm/storage/logs/laravel.log

# Check Nginx error logs
sudo tail -f /var/log/nginx/error.log

# Check PHP-FPM logs
sudo tail -f /var/log/php8.2-fpm.log

# Fix permissions
sudo chown -R www-data:www-data /var/www/warungtm
sudo chmod -R 775 storage bootstrap/cache
```

#### 2. Database Connection Error
```bash
# Test MySQL connection
mysql -u warungtm_user -p warungtm_prod

# Check MySQL status
sudo systemctl status mysql

# Restart MySQL
sudo systemctl restart mysql
```

#### 3. SSL Certificate Issues
```bash
# Test SSL certificate
sudo certbot certificates

# Renew certificate
sudo certbot renew --dry-run

# Check certificate expiry
openssl x509 -in /etc/letsencrypt/live/yourdomain.com/cert.pem -text -noout
```

#### 4. High Memory Usage
```bash
# Check memory usage
free -h

# Check processes
ps aux --sort=-%mem | head

# Optimize PHP-FPM
sudo nano /etc/php/8.2/fpm/pool.d/www.conf
# Reduce pm.max_children
```

### Performance Issues:

#### Slow Database Queries:
```sql
-- Enable slow query log
SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 2;

-- Check slow queries
SHOW VARIABLES LIKE 'slow_query_log_file';
```

#### High CPU Usage:
```bash
# Check CPU usage by process
top -c

# Check Laravel queue workers
ps aux | grep "php artisan queue"

# Optimize database queries
php artisan telescope:install # For debugging (dev only)
```

## 🚀 Deployment Automation (Advanced)

### GitHub Actions Workflow
```yaml
# .github/workflows/deploy.yml
name: Deploy to Production

on:
  push:
    branches: [ main ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v2
    
    - name: Deploy to server
      uses: appleboy/ssh-action@v0.1.4
      with:
        host: ${{ secrets.HOST }}
        username: ${{ secrets.USERNAME }}
        key: ${{ secrets.SSH_KEY }}
        script: |
          cd /var/www/warungtm
          git pull origin main
          composer install --optimize-autoloader --no-dev
          npm ci && npm run build
          php artisan migrate --force
          php artisan config:cache
          php artisan route:cache
          php artisan view:cache
          sudo systemctl reload php8.2-fpm
```

---

## ✅ Post-Deployment Checklist

- [ ] Application accessible via HTTPS
- [ ] SSL certificate valid and auto-renewing
- [ ] Database connected and migrations ran
- [ ] QRIS payment testing successful
- [ ] All user roles working properly
- [ ] Backup scripts configured and tested
- [ ] Monitoring and alerting set up
- [ ] Security hardening completed
- [ ] Performance optimization applied
- [ ] Error logging working properly

**🎉 Congratulations! Your Warung TM system is now live in production!**

For ongoing maintenance and support, refer to the monitoring and backup sections above.