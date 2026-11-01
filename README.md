# Sistem Manajemen Inventaris Gudang

Aplikasi web full-stack berbasis server-side untuk mengelola inventaris gudang: data produk, kategori, supplier, serta pencatatan barang masuk dan keluar. Dibangun dengan **Laravel (arsitektur MVC)** dan **MySQL**, dengan autentikasi dan hak akses berdasarkan peran (admin dan staff).

Proyek ini dibuat untuk UAS Web Application Development, Universitas Cakrawala.

| | |
|---|---|
| **Nama** | M. Saiful Rohim |
| **NIM** | 25110300035 |
| **Studi kasus** | Sistem Manajemen Inventaris Gudang |
| **Aplikasi online** | https://inventaris-gudang-el.vercel.app |
| **Repository** | https://github.com/muhamadsaifrohim/UAS-WAD |

## Akun untuk mencoba

Akun berikut dibuat oleh seeder dan berlaku juga di aplikasi online.

| Role | Email | Password |
|---|---|---|
| Admin | `admin@gudang.test` | `hasil5+5=10` |
| Staff | `ilham@gudang.id` | `12345678` |

Pendaftaran lewat halaman Register selalu menghasilkan akun dengan role **staff**. Akun admin hanya dapat dibuat oleh admin lain melalui menu Pengguna.

## Fitur

- Autentikasi: registrasi, login, logout, dan manajemen session.
- Dashboard: total produk, total stok, daftar stok menipis, dan transaksi terakhir.
- CRUD kategori, supplier, dan produk (pencarian, filter kategori, pagination).
- Transaksi stok masuk dan keluar. Stok produk berubah otomatis, dan transaksi keluar ditolak jika stok tidak cukup.
- Manajemen pengguna dan role (khusus admin).
- Role-based access control: admin dan staff memiliki hak akses berbeda.
- Halaman error kustom (403, 404, 419, 429, 500).

## Teknologi

- PHP 8.3 atau lebih baru, Laravel, Eloquent ORM
- MySQL 8
- Blade, Bootstrap 5, Bootstrap Icons
- Composer, Git

## Prasyarat

- PHP 8.3+ dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `ctype`, `json`
- Composer
- Node.js (opsional, hanya jika ingin membangun aset Vite)
- MySQL 8 (misalnya lewat DBngin, XAMPP, atau Laragon)
- Git

## Instalasi di komputer lokal

1. **Clone repository**
   ```bash
   git clone https://github.com/muhamadsaifrohim/UAS-WAD.git
   cd UAS-WAD
   ```

2. **Pasang dependensi PHP**
   ```bash
   composer install
   ```

3. **Salin file environment dan buat application key**
   ```bash
   copy .env.example .env      # Windows
   # cp .env.example .env      # macOS / Linux
   php artisan key:generate
   ```

4. **Buat database MySQL kosong**, misalnya bernama `inventaris_gudang` (lewat HeidiSQL, phpMyAdmin, atau MySQL Workbench).

5. **Atur koneksi database di `.env`**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=inventaris_gudang
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   Sesuaikan `DB_PORT`, `DB_USERNAME`, dan `DB_PASSWORD` dengan MySQL di komputer Anda.

6. **Siapkan isi database.** Pilih salah satu:

   **a. Lewat migration dan seeder (disarankan)**
   ```bash
   php artisan migrate:fresh --seed
   ```

   **b. Lewat file SQL.** Impor file `database/inventaris_gudang.sql` ke database yang dibuat pada langkah 4 (HeidiSQL: *File, Run SQL file*; phpMyAdmin: tab *Import*).

7. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```
   Buka `http://127.0.0.1:8000` di browser, lalu login dengan akun di atas.

## Hak akses

| Fitur | Admin | Staff |
|---|:---:|:---:|
| Melihat dashboard | ya | ya |
| Melihat produk, kategori, supplier | ya | ya |
| Tambah, ubah, hapus produk / kategori / supplier | ya | tidak |
| Melihat dan mencatat transaksi stok | ya | ya |
| Mengelola pengguna dan role | ya | tidak |

Staff yang membuka halaman khusus admin (misalnya `/users` atau `/products/create`) akan menerima halaman **403 Akses Ditolak**.

## Struktur proyek (bagian utama)

```
app/
  Http/
    Controllers/      AuthController, DashboardController, ProductController,
                      CategoryController, SupplierController,
                      StockTransactionController, UserController
    Middleware/       RoleMiddleware
    Requests/         LoginRequest, RegisterRequest, ProductRequest, CategoryRequest,
                      SupplierRequest, StockTransactionRequest, UserRequest
  Models/             User, Category, Supplier, Product, StockTransaction
database/
  migrations/         skema tabel
  seeders/            DatabaseSeeder (data contoh)
  inventaris_gudang.sql   ekspor database
docs/                 ERD, flowchart, dan diagram arsitektur MVC (PNG)
resources/views/
  layouts/            app.blade.php
  partials/           flash.blade.php
  auth/ products/ categories/ suppliers/ stock/ users/ errors/
routes/web.php        definisi rute
Dockerfile.vercel     image container untuk deployment di Vercel
Caddyfile             konfigurasi web server (FrankenPHP)
vercel.json           konfigurasi layanan Vercel
```

## Basis data

Lima tabel berelasi:

- `users` (id, name, email, password, role)
- `categories` (id, name)
- `suppliers` (id, name, phone, address)
- `products` (id, category_id, supplier_id, sku, name, price, stock, min_stock)
- `stock_transactions` (id, product_id, user_id, type, quantity, note, transaction_date)

Relasi: satu kategori dan satu supplier memiliki banyak produk, satu produk memiliki banyak transaksi stok, dan satu user mencatat banyak transaksi stok. Diagram ERD tersedia di folder `docs/`.

## Keamanan

- **CSRF**: semua form memakai `@csrf`, diverifikasi oleh middleware Laravel.
- **XSS**: keluaran Blade memakai `{{ }}` yang meng-escape HTML.
- **SQL Injection**: seluruh query memakai Eloquent / Query Builder (parameterized).
- **Validasi server-side**: setiap input diperiksa lewat FormRequest sebelum disimpan.
- **Password**: disimpan dalam bentuk hash (bcrypt).
- **Session**: ID session diganti setelah login (`regenerate`) dan dihapus saat logout (`invalidate`).
- **Pembatasan percobaan login**: maksimal 5 kali per menit (`throttle`).
- **Role-based access**: middleware `role:admin` pada rute khusus admin, ditambah penyembunyian tombol di tampilan.
- **Mass assignment**: hanya kolom di `$fillable` yang dapat diisi.
- **Integritas transaksi stok**: pencatatan dan perubahan stok berjalan dalam satu `DB::transaction` dengan `lockForUpdate`.

## Deployment

Aplikasi online berjalan di **Vercel** (Container Runtime) dengan database MySQL di **Aiven**.

- Image dibangun dari `Dockerfile.vercel` (build aset Vite, `composer install --no-dev`, dijalankan dengan FrankenPHP). Layanan didefinisikan di `vercel.json`.
- Setiap `git push` ke branch `main` memicu deployment baru.
- Migrasi dijalankan manual sekali ke database online (`php artisan migrate --seed --force`) dengan nilai koneksi diberikan lewat environment variable sementara. Migrasi tidak dijalankan saat container start.
- Konfigurasi produksi diatur lewat Environment Variables di dashboard Vercel, bukan lewat file di repository:

  ```
  APP_ENV=production
  APP_DEBUG=false
  APP_KEY=base64:...
  APP_URL=https://inventaris-gudang-el.vercel.app
  LOG_CHANNEL=stderr
  DB_CONNECTION=mysql
  DB_HOST=...
  DB_PORT=...
  DB_DATABASE=...
  DB_USERNAME=...
  DB_PASSWORD=...
  MYSQL_ATTR_SSL_CA=/app/ca.pem
  CACHE_STORE=database
  SESSION_DRIVER=database
  QUEUE_CONNECTION=database
  ```

- Aiven mewajibkan koneksi SSL, sehingga sertifikat CA publik (`ca.pem`) disertakan di repository. Password dan `APP_KEY` tidak pernah disimpan di repository.
- Karena memakai paket gratis, container yang lama tidak diakses akan tidur, sehingga kunjungan pertama bisa terasa lambat.
