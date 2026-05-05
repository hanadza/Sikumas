# 🌴 SIKUMAS — Sistem Jual Beli Kelapa Sawit

<div align="center">

![SIKUMAS Banner](https://img.shields.io/badge/SIKUMAS-Kelapa%20Sawit-16a34a?style=for-the-badge&logo=leaflet&logoColor=white)
[![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-38bdf8?style=flat-square&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479a1?style=flat-square&logo=mysql&logoColor=white)](https://mysql.com)
[![Railway](https://img.shields.io/badge/Railway-Deployed-0B0D0E?style=flat-square&logo=railway)](https://railway.app)

Platform marketplace untuk jual beli produk kelapa sawit antara penjual dan pembeli,
dengan sistem pembayaran **QRIS**.

[🌐 Live Demo](#) · [📦 Source Code](https://github.com/hanadza/Sikumas)

</div>

---

## 📋 Daftar Isi

- [Tentang](#-tentang)
- [Fitur](#-fitur)
- [Tech Stack](#️-tech-stack)
- [Screenshot](#-screenshot)
- [Instalasi](#-instalasi)
- [Deploy ke Railway](#️-deploy-ke-railway)
- [Setup Database](#️-setup-database)
- [Akun Default](#-akun-default-seeding)
- [Struktur Project](#-struktur-project)
- [Lisensi](#-lisensi)

---

## 🌴 Tentang

**SIKUMAS** adalah platform e-commerce berbasis web yang dirancang khusus untuk transaksi produk kelapa sawit. Platform ini memungkinkan penjual untuk mendaftarkan produk mereka, dan pembeli dapat melihat, memesan, serta melakukan pembayaran melalui QRIS.

---

## ✨ Fitur

### Untuk Pembeli

- 🔐 Registrasi & Login
- 🛒 Keranjang Belanja
- 📦 Checkout & Pemesanan
- 💳 Pembayaran via QRIS (Gopay, OVO, DANA, LinkAja, dll.)
- 📍 Tracking Status Pesanan
- ⭐ Review & Rating Produk

### Untuk Penjual

- 📊 Dashboard Penjual
- ➕ Tambah, Edit, Hapus Produk
- 📈 Monitoring Penjualan
- ✅ Konfirmasi Pembayaran
- 🚚 Input Nomor Resi Pengiriman

### Umum

- 📚 Halaman Edukasi Kelapa Sawit
- 🔍 Daftar & Detail Produk
- 📱 Responsive Design (Mobile Friendly)
- 🌙 Dark Mode Toggle

---

## 🛠️ Tech Stack

| Teknologi       | Keterangan        |
| --------------- | ----------------- |
| Laravel 13      | PHP Framework     |
| Blade           | Template Engine   |
| Tailwind CSS v4 | Styling           |
| Vite            | Build Tool        |
| MySQL           | Database          |
| Railway         | Cloud Hosting     |
| QRIS            | Sistem Pembayaran |

---

## 📸 Screenshot

> Tambahkan screenshot aplikasi di sini.

```md
![Homepage](screenshots/homepage.png)
![Products](screenshots/products.png)
![Dashboard](screenshots/dashboard.png)
```

---

## 🚀 Instalasi

### Prasyarat

```
PHP       >= 8.2
Composer
Node.js   >= 20
MySQL     >= 8.0
```

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/hanadza/Sikumas.git
cd Sikumas

# 2. Install dependencies
composer install
npm install

# 3. Copy environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate
```

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sikumas
DB_USERNAME=root
DB_PASSWORD=your_password
```

```bash
# 5. Jalankan migration & seeder
php artisan migrate:fresh --seed

# 6. Link storage
php artisan storage:link

# 7. Build assets
npm run build

# 8. Jalankan server lokal
php artisan serve
```

Buka [http://localhost:8000](http://localhost:8000) di browser.

---

## ☁️ Deploy ke Railway

### Prasyarat

- Akun [Railway](https://railway.app)
- Akun GitHub

### Langkah Deploy

**1. Fork & Connect**

- Fork repository ini ke akun GitHub kamu
- Buat project baru di Railway → **Deploy from GitHub repo** → pilih repository Sikumas

**2. Tambahkan MySQL Database**

- Di Railway: **New → Database → Add MySQL**
- Klik service web → **Variables → Add Reference → MySQL**

**3. Setup Environment Variables**

```env
APP_NAME=SIKUMAS
APP_ENV=production
APP_DEBUG=false
APP_KEY=          # generate dari lokal: php artisan key:generate --show
APP_URL=https://your-app-name.up.railway.app

FILESYSTEM_DISK=public

DB_CONNECTION=mysql
DB_HOST=mysql.railway.internal
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=      # dari MySQL service Railway
DB_PASSWORD=      # dari MySQL service Railway
```

**4. Buat file `railway.json` di root project**

```json
{
    "$schema": "https://railway.app/railway.schema.json",
    "build": {
        "builder": "NIXPACKS"
    },
    "deploy": {
        "startCommand": "npm install && npm run build && php artisan migrate:fresh --seed && php artisan storage:link && php artisan serve --host 0.0.0.0 --port $PORT",
        "restartPolicyType": "ON_FAILURE",
        "restartPolicyMaxRetries": 10
    }
}
```

**5. Push & Deploy**

```bash
git add railway.json
git commit -m "ci: add railway deployment config"
git push origin main
```

Railway akan otomatis mendeteksi perubahan dan mulai deploy. Tunggu hingga status **Online**.

---

## 🗄️ Setup Database

### Opsi 1 — Import dari Backup SQL

1. Buka **phpMyAdmin** atau **TablePlus**
2. Koneksikan ke database Railway menggunakan host, port, user, dan password dari Railway Variables
3. Import file `database/backup/sikumas_database.sql`

### Opsi 2 — Jalankan Migration Otomatis

```bash
railway run php artisan migrate:fresh --seed
```

---

## 👥 Akun Default (Seeding)

Setelah menjalankan `php artisan migrate:fresh --seed`, akun berikut tersedia:

| Role    | Email               | Password |
| ------- | ------------------- | -------- |
| Pembeli | buyer@sikumas.test  | password |
| Penjual | seller@sikumas.test | password |
| Dual    | dual@sikumas.test   | password |

---

## 📁 Struktur Project

```
sikumas/
│
├── app/
│   ├── Http/
│   │   └── Controllers/        # Controller logic
│   └── Models/                 # Eloquent Models
│
├── database/
│   ├── migrations/             # Database migrations
│   └── backup/                 # SQL backup files
│
├── public/
│   ├── build/                  # Compiled assets (Vite)
│   └── images/                 # Static images
│
├── resources/
│   ├── views/
│   │   ├── layouts/            # Layout files
│   │   ├── pages/              # Page views
│   │   ├── orders/             # Order views
│   │   ├── profile/            # Profile views
│   │   └── seller/             # Seller dashboard views
│   ├── css/                    # CSS source
│   └── js/                     # JavaScript source
│
├── routes/
│   └── web.php                 # Web routes
│
├── storage/
│   └── app/public/             # File storage
│
├── .env.example
├── .gitignore
├── railway.json                # Railway config
├── package.json
├── vite.config.js
└── composer.json
```

---

## 📖 Lisensi

Project ini bebas digunakan untuk keperluan belajar dan pengembangan.
Untuk penggunaan komersial, silakan hubungi pemilik project.

---

## 👨‍💻 Kontributor

- **Hanadza** — Development

---

<div align="center">

Dibuat dengan ❤️ menggunakan **Laravel** & **Tailwind CSS**

</div>
