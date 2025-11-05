# 📖 Panduan Instalasi Lengkap - Warung TM

Panduan step-by-step untuk setup sistem kasir Warung TM dari awal hingga siap digunakan.

## 🎯 Prerequisites

Pastikan semua requirements sudah terinstall di sistem Anda:

### Windows:
```bash
# Install menggunakan Chocolatey (recommended)
choco install php composer nodejs mysql

# Atau download manual:
# - PHP 8.2+ dari https://windows.php.net/download/
# - Composer dari https://getcomposer.org/download/
# - Node.js dari https://nodejs.org/
# - MySQL dari https://dev.mysql.com/downloads/installer/
```

### Linux (Ubuntu/Debian):
```bash
# Update package list
sudo apt update

# Install PHP 8.2 dan extensions
sudo apt install php8.2 php8.2-cli php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs

# Install MySQL
sudo apt install mysql-server
```

### macOS:
```bash
# Install menggunakan Homebrew
brew install php@8.2 composer node mysql

# Start MySQL service
brew services start mysql
```

## 🚀 Instalasi Step-by-Step

### Step 1: Download Source Code

```bash
# Option 1: Clone dari GitHub (recommended)
git clone https://github.com/ipamungkas88/Kasir-warungTM.git
cd Kasir-warungTM

# Option 2: Download ZIP
# - Download dari GitHub
# - Extract ke folder project
# - Buka terminal di folder project
```

### Step 2: Install Dependencies

```bash
# Install PHP dependencies
composer install

# Jika error, coba:
composer install --ignore-platform-reqs

# Install Node.js dependencies
npm install

# Build assets untuk production
npm run build
```

### Step 3: Environment Setup

```bash
# Copy environment template
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Database Configuration

#### 4.1 Buat Database:
```sql
-- Login ke MySQL
mysql -u root -p

-- Buat database
CREATE DATABASE warungtm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Buat user database (optional, untuk keamanan)
CREATE USER 'warungtm_user'@'localhost' IDENTIFIED BY 'password_kuat_123';
GRANT ALL PRIVILEGES ON warungtm.* TO 'warungtm_user'@'localhost';
FLUSH PRIVILEGES;

-- Exit MySQL
EXIT;
```

#### 4.2 Update .env File:
```env
# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=warungtm
DB_USERNAME=warungtm_user
DB_PASSWORD=password_kuat_123

# App Configuration  
APP_NAME="Warung TM"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Midtrans Configuration (Sandbox untuk testing)
MIDTRANS_SERVER_KEY=SB-Mid-server-GwUP_WGbJPMxIc4IA5KCHyab
MIDTRANS_CLIENT_KEY=SB-Mid-client-nKsqvar5cn60u2Lv
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

### Step 5: Database Migration & Seeding

```bash
# Test database connection
php artisan migrate:status

# Run migrations
php artisan migrate

# Seed sample data (users, menus)
php artisan db:seed

# Atau jika ingin fresh install
php artisan migrate:fresh --seed
```

### Step 6: Storage & Cache Setup

```bash
# Create storage link untuk file uploads
php artisan storage:link

# Set permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache

# Windows: Run CMD as Administrator
# icacls storage /grant Users:F /T
# icacls bootstrap/cache /grant Users:F /T
```

### Step 7: Test Installation

```bash
# Start Laravel server
php artisan serve

# Server akan berjalan di: http://127.0.0.1:8000
```

## 🧪 Verifikasi Instalasi

### Test 1: Akses Web Interface
1. Buka browser dan akses `http://127.0.0.1:8000`
2. Harus muncul halaman login
3. Tidak ada error 500 atau database connection error

### Test 2: Login System
```bash
# Login sebagai Owner
Username: owner
Password: owner123

# Login sebagai Kasir  
Username: kasir
Password: kasir123
```

### Test 3: Database Connection
```bash
php artisan tinker

# Di dalam tinker:
>>> DB::connection()->getPdo();
# Harus return PDO object

>>> App\Models\User::count();
# Harus return angka > 0

>>> exit
```

### Test 4: Midtrans Configuration
```bash
php artisan tinker

# Test Midtrans config:
>>> config('midtrans.server_key');
# Harus return server key

>>> config('midtrans.client_key');  
# Harus return client key

>>> exit
```

## 🏪 Setup Data Warung

### 1. Login sebagai Owner
```
URL: http://127.0.0.1:8000/login
Username: owner  
Password: owner123
```

### 2. Setup Menu Items
1. Navigate ke **Manajemen Menu**
2. Tambah kategori menu (contoh: Makanan, Minuman, Snack)
3. Tambah menu items dengan harga dan deskripsi

### 3. Setup User Kasir (Optional)
1. Navigate ke **Manajemen Pengguna**
2. Tambah kasir baru atau edit yang existing
3. Set username dan password yang mudah diingat

### 4. Test Transaksi
1. Logout dan login sebagai kasir
2. Navigate ke **Transaksi**
3. Test transaksi tunai
4. Test transaksi QRIS (gunakan Midtrans simulator)

## 🔧 Troubleshooting Installation

### Error: "composer command not found"
```bash
# Pastikan Composer ter-install dan ada di PATH
composer --version

# Jika belum install:
# Windows: Download dari getcomposer.org
# Linux: curl -sS https://getcomposer.org/installer | php
# Mac: brew install composer
```

### Error: "npm command not found"
```bash
# Install Node.js dari nodejs.org
node --version
npm --version
```

### Error: Database Connection
```bash
# Check MySQL service
# Windows: services.msc -> MySQL
# Linux: sudo systemctl status mysql
# Mac: brew services list | grep mysql

# Test manual connection
mysql -u root -p -h 127.0.0.1
```

### Error: Permission Denied (Linux/Mac)
```bash
# Fix ownership
sudo chown -R $USER:$USER .

# Fix permissions
chmod -R 755 .
chmod -R 775 storage bootstrap/cache
```

### Error: "Key path does not exist"
```bash
# Regenerate app key
php artisan key:generate

# Clear config cache
php artisan config:clear
```

### Error: "Class not found"
```bash
# Regenerate autoload
composer dump-autoload

# Clear all cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 📦 Development Tools (Optional)

### Install Development Dependencies:
```bash
# Install dev dependencies
composer install

# Install debugging tools
composer require --dev barryvdh/laravel-debugbar
composer require --dev barryvdh/laravel-ide-helper

# Generate IDE helper files
php artisan ide-helper:generate
php artisan ide-helper:models
```

### VS Code Extensions (Recommended):
- PHP Intelephense
- Laravel Blade Snippets
- Laravel Artisan
- Tailwind CSS IntelliSense
- MySQL (for database management)

## 🚀 Next Steps

Setelah instalasi berhasil:

1. **Customize Settings**: Edit `.env` sesuai kebutuhan
2. **Add Real Data**: Input menu dan harga sesuai warung
3. **Test All Features**: Coba semua fitur sistem
4. **Setup Backup**: Setup backup database rutin
5. **Monitor Logs**: Check `storage/logs/laravel.log` untuk error

## 📚 Useful Commands

```bash
# Development
php artisan serve              # Start server
npm run dev                    # Watch file changes
php artisan tinker            # Interactive console

# Database
php artisan migrate           # Run migrations  
php artisan migrate:rollback  # Rollback last migration
php artisan db:seed          # Seed data

# Cache Management
php artisan cache:clear       # Clear application cache
php artisan config:clear      # Clear config cache
php artisan route:clear       # Clear route cache
php artisan view:clear        # Clear view cache

# Production
php artisan optimize          # Optimize for production
php artisan config:cache      # Cache configurations
npm run build                 # Build production assets
```

---

**🎉 Selamat! Sistem Kasir Warung TM sudah siap digunakan!**

Untuk panduan penggunaan sistem, lihat [README.md](README.md) atau hubungi support jika ada kendala.