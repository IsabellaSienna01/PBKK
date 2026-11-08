# Tugas Mandiri: Dashboard & RBAC Implementation (Branch `w10`)

Proyek ini merupakan kelanjutan dari portal akademik mandiri berbasis **Laravel** dengan mengintegrasikan panel visual admin profesional (**AdminLTE**), sistem autentikasi (**Laravel Breeze**), otorisasi berbasis peran (**Spatie Laravel Permission**), form pencarian dinamis, pagination persisten, serta database dummy generator menggunakan **Faker**.

---

## 📌 Ringkasan Perubahan & Fitur Utama

### 1. Integrasi UI Backoffice AdminLTE
- Menggunakan master layouting **AdminLTE 4** berbasis Bootstrap 5 (`@extends('adminlte::page')`).
- Sidebar menu dinamis dengan penanda aktif, integrasi icon Bootstrap Icons (`bi`), serta filter hak akses menu via `GateFilter`.
- Profil pengguna dan badge avatar dinamis di navbar dan sidebar (`adminlte_image()`, `adminlte_desc()`, `adminlte_profile_url()`).

### 2. Sistem Autentikasi Laravel Breeze
- Seluruh rute `/dashboard/*` berada di bawah middleware autentikasi `auth` dan `verified`.
- Mengintegrasikan antarmuka login Breeze dengan kustomisasi tema portal akademik dan tombol demo instan.

### 3. Otorisasi Dinamis Spatie RBAC (Database Level)
Tersedia dua peran (*roles*) utama yang tersimpan dinamis di database fisik:
- 👑 **`Admin` (Akses Penuh)**: Memegang seluruh permissions: `view-dashboard`, `view-mahasiswa`, `create-mahasiswa`, `edit-mahasiswa`, `delete-mahasiswa`, `view-matakuliah`, `create-matakuliah`, `edit-matakuliah`, `delete-matakuliah`, `view-ide-agent`, `delete-ide-agent`, `manage-users`.
- 👤 **`Staf` (Akses Terbatas)**: Hanya memiliki izin melihat, menambah, dan mengedit data (`view-*`, `create-*`, `edit-*`). **Tidak memiliki izin menghapus data** maupun mengelola akun pengguna lain.

### 4. Hak Eksklusif 'Hapus Data' (Visual Blade + Controller Security)
- **Visual Blade**: Tombol `Hapus Data` dilindungi direktif `@can('delete-mahasiswa')` / `@role('Admin')`. Pengguna berstatus Staf tidak dapat melihat tombol aksi hapus (tampil ikon gembok non-aktif).
- **Pengaman Controller (Server-Side)**: Controller constructor melampirkan middleware `permission:delete-mahasiswa` dan pengecekan manual server-side `abort_if(!auth()->user()->can('delete-mahasiswa'), 403)`. Jika pengguna Staf mencoba menembak URL hapus via cURL / Postman / tamper request, server langsung menolak dengan status HTTP **`403 Forbidden`**.

### 5. Widget Dashboard Statistik Agregat Dinamis
Pada halaman beranda admin (`/dashboard`), ditampilkan 4 widget box utama berbasis kueri agregat model Eloquent `count()`:
1. **Total Mahasiswa**: `Mahasiswa::count()`
2. **Kurikulum Mata Kuliah**: `MataKuliah::count()`
3. **Proposal Ide Agentic AI**: `IdeAgent::count()`
4. **Pengguna Terdaftar & Hak Akses**: `User::count()`
Ditambah metrik distribusi mahasiswa (Aktif, Cuti, Lulus) dan rata-rata IPK: `Mahasiswa::avg('ipk')`.

### 6. Tantangan Tambahan / Challenge (Nilai Plus A+)
- 🔍 **Filter Pencarian & Kueri `when()`**: Form pencarian di halaman tabel data mahasiswa menggunakan kueri kondisional `when()` pada `MahasiswaController` sehingga kode tetap bersih (*clean code*) tanpa *if-else statement* bersarang.
- 🔗 **Pengunci Link Pagination `withQueryString()`**: Mempertahankan parameter filter (kata kunci `search`, filter `jurusan`, dan filter `status`) saat berpindah halaman data di pagination.
- ⚡ **Auto-Login Test Accounts**: Tersedia tombol login instan 1-klik di halaman login (`/login`) untuk akun Admin dan Staf guna mempermudah proses evaluasi demo dosen/asdos tanpa perlu mengetik kredensial manual.
- 🎲 **Auto-Seeder Faker Realistis**: Seeder otomatis (`AcademicSeeder` & `RolePermissionSeeder`) langsung menyiram puluhan data dummy realistis (40+ mahasiswa, 10 kurikulum mata kuliah, dan usulan ide agentic AI) saat migrasi database awal.
- 📐 **Kerapian Kode Standar PSR-12**: Seluruh controller, model, request, dan file konfigurasi diformat rapi dan divalidasi lolos menggunakan **Laravel Pint**.

---

## 👥 Akun Uji Coba Demo (Test Accounts)

| Peran (*Role*) | Email Login | Password | Hak Akses Utama |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@academic.its.ac.id` | `password` | **Akses Penuh**: Melihat, Menambah, Mengedit, **Menghapus Data (Eksklusif)**, & Manajemen RBAC User |
| **Staf** | `staf@academic.its.ac.id` | `password` | **Akses Terbatas**: Melihat, Menambah, Mengedit Data. **Dilarang Menghapus Data** & Dilarang Akses Manajemen User |
| **Owner (Admin)** | `isabella@student.its.ac.id` | `password` | Akses Admin & Mahasiswa Pemilik Portofolio (NRP 5025241199) |

> 💡 **Tips Demo:** Pada halaman login (`http://127.0.0.1:8000/login`), cukup klik tombol hijau **"Login Admin"** atau tombol ungu **"Login Staf"** untuk langsung masuk ke sesi pengguna terkait.

---

## 🚀 Panduan Menjalankan Aplikasi

### Prasyarat Sistem
- PHP >= 8.2 (dengan ekstensi `pdo_sqlite`, `curl`, `mbstring`, `fileinfo`)
- Composer >= 2.0
- Node.js >= 18 & npm

### Langkah Instalasi

1. **Pastikan berada di branch `w10`**:
   ```bash
   git checkout w10
   ```

2. **Salin konfigurasi environment & buat file database SQLite**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   touch database/database.sqlite
   ```

3. **Install dependensi PHP & Node.js**:
   ```bash
   composer install
   npm install
   ```

4. **Jalankan migrasi database dan penyiraman data dummy (Seeding)**:
   ```bash
   php artisan migrate:fresh --seed
   ```
   *Perintah ini otomatis menginisialisasi tabel roles, permissions, membuat akun uji coba, serta menyiram 40+ data dummy mahasiswa & mata kuliah.*

5. **Build asset visual (Tailwind & CSS)**:
   ```bash
   npm run build
   ```

6. **Jalankan server aplikasi**:
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui peramban web di: **`http://127.0.0.1:8000`**

---

## 🎬 Panduan Teknis Live Demo di Kelas (Evaluation Script)

Ikuti alur pengujian berikut untuk menunjukkan pemenuhan seluruh kriteria tugas di depan Dosen/Asdos:

### Skenario 1: Evaluasi Tombol Auto-Login & Beranda Publik
1. Buka `http://127.0.0.1:8000/` (Website portofolio akademik mahasiswa).
2. Klik tombol **"Login Admin"** di navigasi atas untuk menuju ke `http://127.0.0.1:8000/login`.
3. Tunjukkan kotak **"Auto-Login Test Accounts (Quick Demo)"** dengan tombol login instan 1-klik.

---

### Skenario 2: Login sebagai `Admin` (Akses Penuh & Hak Eksklusif Hapus)
1. Klik tombol **"👑 Login Admin"**. Sistem akan mengarahkan ke `/dashboard`.
2. **Verifikasi Widget Dashboard**:
   - Tunjukkan 4 kotak statistik dinamis: Total Mahasiswa, Mata Kuliah, Ide Agentic, dan Pengguna Sistem.
   - Tunjukkan badge peran di header atas: `Peran: Admin (Akses Penuh)`.
3. **Verifikasi Akses Data Mahasiswa**:
   - Klik menu **"Data Mahasiswa"** di sidebar.
   - Tunjukkan pada kolom *Aksi* bahwa tombol merah berlogo tempat sampah (**Hapus**) **TERRENDER VISUAL**.
   - Coba klik tombol hapus pada salah satu data dummy, konfirmasi di modal, dan data berhasil terhapus.
4. **Verifikasi Manajemen Hak Akses**:
   - Klik menu **"Manajemen Pengguna & RBAC"** di sidebar (`/dashboard/users`).
   - Tunjukkan daftar pengguna dan peran Spatie. Admin dapat mengubah peran akun Staf menjadi Admin atau sebaliknya.

---

### Skenario 3: Login sebagai `Staf` (Akses Terbatas & Penguncian Hak Hapus)
1. Logout melalui menu profil di pojok kanan atas, lalu kembali ke halaman login.
2. Klik tombol **"👤 Login Staf"**.
3. **Verifikasi Pembatasan Visual di Dashboard**:
   - Header menunjukkan badge: `Peran: Staf (Akses Terbatas)`.
   - Sidebar **TIDAK MENAMPILKAN** menu "Manajemen Pengguna & RBAC" (disembunyikan oleh `GateFilter`).
4. **Verifikasi Pembatasan Visual Blade**:
   - Buka menu **"Data Mahasiswa"**.
   - Perhatikan kolom *Aksi*: Tombol merah **Hapus** **TIDAK MUNCUL** (hanya ikon gembok terkunci abu-abu non-aktif).
5. **Verifikasi Pengaman Controller (Server-Side URL Tampering Prevention)**:
   - Jika Staf mencoba membuka paksa URL manajemen user: `http://127.0.0.1:8000/dashboard/users`, server langsung mengembalikan halaman **`403 Forbidden`**.
   - Jika Staf mencoba mengirim request HTTP DELETE ke endpoint mahasiswa, server menolak dengan pesan otorisasi server-side: *"Akses Ditolak: Hanya Admin dengan hak eksklusif yang berhak menghapus data Mahasiswa."*

---

### Skenario 4: Pengujian Modul Pencarian `when()` & Pagination `withQueryString()`
1. Masuk ke halaman **"Data Mahasiswa"** (`/dashboard/mahasiswa`).
2. Masukkan kata kunci pencarian, misalnya nama mahasiswa atau pilih jurusan `Teknik Informatika`.
3. Klik tombol **Filter**. Tabel akan menyaring data secara presisi menggunakan kueri `when()`.
4. Gulir ke bawah dan klik tombol halaman **2** atau **Next** pada pagination.
5. **Perhatikan URL di browser**:
   ```
   http://127.0.0.1:8000/dashboard/mahasiswa?search=...&jurusan=Teknik+Informatika&page=2
   ```
   Kata kunci dan filter **tidak hilang/ter-reset** saat berpindah halaman berkat method `withQueryString()`.

---

### Skenario 5: Menjalankan Pengujian Otomatis (Automated Tests)
Jalankan pengujian unit dan fungsional bawaan Laravel yang memvalidasi seluruh skenario RBAC di atas:
```bash
php artisan test
```
*Hasil: **31 test suite passed (94 assertions)**, termasuk pengujian otorisasi Spatie RBAC, penguncian rute, kueri `when()`, dan auto-login.*

Validasi kerapian kode standar PSR-12:
```bash
./vendor/bin/pint --test
```
*Hasil: **Passed** tanpa error styling.*

---

## 📂 Struktur Rute Utama

```
GET|HEAD   / ............................................ home (Portal Akademik)
GET|HEAD   /login ....................................... login (Form Login Breeze)
POST       /demo-login .................................. demo.login (Instant Auto-Login)
GET|HEAD   /dashboard ................................... dashboard (AdminLTE Dashboard)
GET|HEAD   /dashboard/mahasiswa ......................... dashboard.mahasiswa.index (Search when())
POST       /dashboard/mahasiswa ......................... dashboard.mahasiswa.store
GET|HEAD   /dashboard/mahasiswa/{id} .................... dashboard.mahasiswa.show
GET|HEAD   /dashboard/mahasiswa/{id}/edit ............... dashboard.mahasiswa.edit
DELETE     /dashboard/mahasiswa/{id} .................... dashboard.mahasiswa.destroy (Admin Only)
GET|HEAD   /dashboard/matakuliah ........................ dashboard.matakuliah.index
DELETE     /dashboard/matakuliah/{id} ................... dashboard.matakuliah.destroy (Admin Only)
GET|HEAD   /dashboard/ide-agent ......................... dashboard.ide-agent.index
GET|HEAD   /dashboard/users ............................. dashboard.users.index (Admin Only)
```

---
*Pengembangan Tugas Mandiri Pemrograman Berbasis Kerangka Kerja (PBKK) — Semester Genap 2026.*
