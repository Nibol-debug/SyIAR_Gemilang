# 📘 SyIAR Gemilang (Sistem Informasi Rumah Gemilang)

[![Laravel Version](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Status](https://img.shields.io/badge/status-Development-orange.svg)]()

**SyIAR Gemilang** adalah sistem informasi berbasis web yang dirancang khusus untuk lembaga pendidikan **Rumah Gemilang**. Sistem ini bertujuan untuk mengintegrasikan seluruh kegiatan akademik, manajemen pengguna, serta operasional lembaga secara terstruktur dan efisien.

---

## 🚀 Overview

SyIAR Gemilang hadir sebagai solusi digital untuk mengatasi kompleksitas pengelolaan data di lembaga pendidikan multi-cabang. Fokus utama sistem ini adalah validitas data akademik dan skalabilitas, memastikan operasional berjalan lancar dari level instruktur hingga manajemen pusat.

## 🛠 Teknologi yang Digunakan

- **Framework:** Laravel (PHP)
- **Database:** MySQL
- **Frontend:** Blade Templating (Optional: Vue.js for reactive components)
- **Authentication:** Laravel Breeze / Jetstream (Inertia/Livewire)
- **Server:** Nginx / Apache
- **Styling:** Tailwind CSS / Bootstrap

## 👥 Role & Hak Akses

Sistem menggunakan **Role-Based Access Control (RBAC)** yang ketat:

1.  **Admin (Super Admin):** Kendali penuh sistem, manajemen user pusat, dan setting global.
2.  **Admin Cabang:** Pengelola data spesifik cabang, manajemen peserta, instruktur, dan jadwal lokal.
3.  **Instruktur:** Manajemen materi, input nilai (tugas/ujian), absensi, dan jadwal mengajar.
4.  **Manajemen:** Akses laporan akademik, keuangan, dan monitoring performa (Analisis Data).
5.  **Peserta Didik:** Akses materi, melihat jadwal, cek nilai, dan absensi (check-in).

## ✨ Fitur Utama (Akademik)

### 📚 1. Manajemen Akademik
- Pengelolaan Program/Jurusan.
- Manajemen Kelas dan Kurikulum terintegrasi.
- Database Mata Pelajaran.

### 🗓️ 2. Penjadwalan
- Penjadwalan kelas otomatis.
- Kalender akademik lembaga.
- Monitoring ketersediaan instruktur.

### 📝 3. Penilaian & Raport
- Input nilai berbasis kompetensi (Tugas, Ujian, Praktik).
- Rekapitulasi nilai otomatis.
- **Export Raport ke PDF**.

### 📊 4. Absensi & Kehadiran
- Sistem absensi real-time untuk peserta dan instruktur.
- Rekapitulasi kehadiran bulanan/semester.

### 📂 5. Learning Management (LMS)
- Distribusi materi (PDF, Video, Docs).
- Akses materi berdasarkan level kelas.

## 🏗 Struktur Database (Simplified)

| Tabel | Deskripsi |
|---|---|
| `users` | Data autentikasi dan profil pengguna |
| `roles` | Definisi hak akses (RBAC) |
| `branches` | Data kantor cabang Rumah Gemilang |
| `programs` | Jurusan atau program pendidikan |
| `classes` | Detail rombongan belajar |
| `schedules` | Plotting waktu dan tempat |
| `grades` | Data nilai akademik |
| `materials` | File materi pembelajaran |

## 📐 Arsitektur & Struktur Folder

Proyek ini mengikuti *best practice* Laravel dengan memisahkan logika bisnis menggunakan **Service Layer** dan **Repository Pattern** untuk menjaga kode tetap bersih (Clean Code):

```text
app/
├── Http/Controllers/   # Menangani HTTP Request
├── Models/             # Definisi Eloquent Models
├── Services/           # Business Logic (Complex Operations)
├── Repositories/       # Data Access Layer (Optional)
resources/
├── views/              # UI (Blade Templates)
routes/
└── web.php             # Definisi Route Utama
```

## 🗺️ Roadmap Development

- [ ] **Phase 1: Core System** (Auth, Role, Branch Management)
- [ ] **Phase 2: Academic Core** (Class, Schedule, Attendance, Grading)
- [ ] **Phase 3: Reporting** (Materi, Dashboard Analytics, Export PDF)
- [ ] **Phase 4: Enhancement** (WA/Email Notification, API for Mobile)

## ⚙️ Instalasi

1. Clone repositori:
   ```bash
   git clone https://github.com/Nibol-debug/SyIAR_Gemilang.git
   ```
2. Install dependencies:
   ```bash
   composer install
   npm install && npm run dev
   ```
3. Copy `.env.example` ke `.env` dan konfigurasi database.
4. Jalankan migrasi dan seeder:
   ```bash
   php artisan migrate --seed
   ```
5. Jalankan server:
   ```bash
   php artisan serve
   ```

---

> **Kesimpulan:** SyIAR Gemilang dirancang untuk menjadi tulang punggung digital bagi Rumah Gemilang, mengutamakan integritas data akademik dan kemudahan penggunaan di setiap level user.


