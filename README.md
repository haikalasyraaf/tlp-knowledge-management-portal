# Laravel Project Setup Guide

This document explains how to set up and run the Laravel project on your local machine.

---

## ✅ Prerequisites

Make sure you have these installed:

- [PHP 8.1+](https://windows.php.net/download/)
- [Composer](https://getcomposer.org/download/)
- [Git](https://git-scm.com/downloads)
- [MySQL](https://dev.mysql.com/downloads/installer/) or MariaDB
- [VS Code](https://code.visualstudio.com/)

---

## 🚀 Getting Started

### 1. Clone the repository
```bash
git clone https://github.com/haikalasyraaf/tlp-kmp-project.git
cd tlp-kmp-project
```

### 2. Install PHP dependencies
```bash
composer install
```

### 3. Configure environment
Copy `.env.example` to `.env`:

```bash
cp .env.example .env
```

On **Windows PowerShell**:
```powershell
copy .env.example .env
```

Edit `.env` file with your database and app details:
```dotenv
APP_NAME="Your App"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Generate app key
```bash
php artisan key:generate
```

### 5. Run migrations (with seed if available)
```bash
php artisan migrate --seed
```

### 6. Start the Laravel server
```bash
php artisan serve
```

Now open: 👉 http://127.0.0.1:8000

---

## 🔑 First Login (Admin Account)

After setting up the project and running migrations/seeds, you can log in using the default admin credentials:

| Field      | Value             |
|------------|-----------------|
| **Staff ID** | `500000`        |
| **Role**   | `Admin`           |

---

## 🧹 Useful Artisan Commands

- Clear caches:
  ```bash
  php artisan cache:clear
  php artisan config:clear
  php artisan route:clear
  php artisan view:clear
  ```

- Rollback last migration:
  ```bash
  php artisan migrate:rollback
  ```

- Refresh database:
  ```bash
  php artisan migrate:fresh --seed
  ```

---

## 📦 Deployment (Basic Steps)

1. Upload project files to server.
2. Run:
   ```bash
   composer install --optimize-autoloader --no-dev
   php artisan migrate --force
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
3. Set correct folder permissions:
   - `storage/`
   - `bootstrap/cache/`

---

## 👨‍💻 Author
- Developed by [Haikal Asyraaf](https://github.com/haikalasyraaf/)
