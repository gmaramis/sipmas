# SIPMAS - Sistem Pengaduan Masyarakat Polres Minahasa

[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 📋 Deskripsi

SIPMAS (Sistem Pengaduan Masyarakat) adalah aplikasi web yang dikembangkan untuk Polres Minahasa dalam mengelola pengaduan masyarakat secara digital. Aplikasi ini memungkinkan masyarakat untuk melaporkan berbagai jenis pengaduan dengan mudah, sementara petugas dan admin dapat mengelola dan menindaklanjuti pengaduan tersebut secara efisien.

## ✨ Fitur Utama

### 👥 Multi-Role System

-   **Admin**: Manajemen sistem, statistik, dan pengaturan
-   **Petugas**: Penanganan pengaduan dan update status
-   **Masyarakat**: Pelaporan pengaduan dan tracking

### 📊 Dashboard & Analytics

-   Dashboard real-time dengan statistik pengaduan
-   Grafik statistik bulanan dan kategori pengaduan
-   Monitoring performa petugas
-   Laporan detail pengaduan

### 🚨 Manajemen Pengaduan

-   Sistem pelaporan pengaduan online
-   Upload bukti foto
-   Tracking status pengaduan
-   Penugasan petugas
-   Notifikasi real-time

### 👮‍♂️ Manajemen Petugas

-   Registrasi dan manajemen petugas
-   Penugasan pengaduan
-   Monitoring kinerja
-   Profil dan data lengkap

### 🔐 Keamanan

-   Autentikasi multi-role
-   Enkripsi data sensitif
-   Validasi input
-   Session management

## 🛠️ Teknologi yang Digunakan

-   **Backend**: Laravel 10.x
-   **Frontend**: Blade Templates, Tailwind CSS
-   **Database**: MySQL
-   **Authentication**: Laravel Sanctum
-   **Charts**: Chart.js
-   **Real-time**: Socket.IO
-   **Icons**: Font Awesome

## 📋 Prasyarat

Sebelum menjalankan aplikasi, pastikan sistem Anda memenuhi persyaratan berikut:

-   PHP >= 8.1
-   Composer
-   MySQL >= 8.0
-   Node.js & NPM
-   Git

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/sipmas.git
cd sipmas
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sipmas
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrasi Database

```bash
php artisan migrate
php artisan db:seed
```

### 6. Setup Storage

```bash
php artisan storage:link
```

### 7. Build Assets

```bash
npm run build
```

### 8. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 👤 Akun Default

Setelah menjalankan seeder, Anda dapat login dengan akun berikut:

### Admin

-   **Email**: admin@sipmas.com
-   **Password**: password

### Petugas

-   **Email**: petugas@sipmas.com
-   **Password**: password

### User

-   **Email**: user@sipmas.com
-   **Password**: password

## 📁 Struktur Project

```
sipmas/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/           # Authentication
│   │   ├── Backend/        # Admin controllers
│   │   ├── User/           # User controllers
│   │   └── Petugas/        # Petugas controllers
│   ├── Models/             # Eloquent models
│   └── Providers/          # Service providers
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/           # Database seeders
├── resources/
│   └── views/
│       ├── layouts/        # Layout templates
│       ├── admin/          # Admin views
│       ├── user/           # User views
│       └── petugas/        # Petugas views
├── routes/                 # Route definitions
└── public/                 # Public assets
```

## 🔧 Konfigurasi

### Environment Variables

Pastikan mengatur variabel environment berikut di file `.env`:

```env
APP_NAME="SIPMAS - Polres Minahasa"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sipmas
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@sipmas.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## 📊 Database Schema

### Tabel Utama

-   `users` - Data pengguna (admin, petugas, masyarakat)
-   `petugas` - Data petugas kepolisian
-   `complaints` - Data pengaduan
-   `roles` & `permissions` - Sistem role dan permission

## 🔒 Keamanan

### Fitur Keamanan yang Diimplementasikan

-   Password hashing dengan bcrypt
-   CSRF protection
-   SQL injection prevention
-   XSS protection
-   Role-based access control
-   Session security

### Best Practices

-   Selalu update dependencies
-   Gunakan HTTPS di production
-   Backup database secara berkala
-   Monitor log aplikasi

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=UserTest
```

## 📈 Deployment

### Production Checklist

-   [ ] Set `APP_ENV=production`
-   [ ] Set `APP_DEBUG=false`
-   [ ] Konfigurasi database production
-   [ ] Setup SSL certificate
-   [ ] Konfigurasi web server (Apache/Nginx)
-   [ ] Setup backup system
-   [ ] Monitor performance

### Server Requirements

-   PHP >= 8.1
-   MySQL >= 8.0
-   Apache/Nginx
-   SSL Certificate
-   2GB RAM minimum

## 🤝 Kontribusi

1. Fork repository
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📝 Changelog

### v1.0.0 (2025-01-XX)

-   Initial release
-   Multi-role authentication
-   Complaint management system
-   Dashboard with analytics
-   Real-time notifications

## 📄 Lisensi

Project ini dilisensikan di bawah [MIT License](LICENSE).

## 📞 Kontak

**Polres Minahasa**

-   Email: polres.minahasa@polri.go.id
-   Website: https://minahasa.polri.go.id
-   Address: Jl. Raya Manado - Tomohon, Tondano, Minahasa

## 🙏 Ucapan Terima Kasih

Terima kasih kepada semua pihak yang telah berkontribusi dalam pengembangan sistem SIPMAS ini.

---

**SIPMAS** - Sistem Pengaduan Masyarakat Polres Minahasa  
_Membangun Kepercayaan Masyarakat Melalui Pelayanan Digital_
