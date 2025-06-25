# Skoolio - Learning Management System (LMS)

![PHP](https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=for-the-badge&logo=php)
![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)
![Testing](https://img.shields.io/badge/Testing-Pest-C5A13A?style=for-the-badge&logo=pest)
![License](https://img.shields.io/badge/License-MIT-blue.svg?style=for-the-badge)

Skoolio adalah sebuah prototipe Learning Management System (LMS) fungsional yang dibangun sepenuhnya menggunakan Laravel 12. Proyek ini dibuat dari nol dengan tujuan untuk menjelajahi fitur-fitur inti dan lanjutan dari framework Laravel secara mendalam, dengan fokus pada praktik terbaik dan alur kerja modern.

![Skoolio Screenshot Placeholder](https://i.imgur.com/TTOD7Yn.jpeg)


---

## 🚀 About The Project

Proyek ini mensimulasikan platform e-learning di mana pengajar (instructors) dapat membuat dan mengelola kursus serta pelajaran, dan siswa (students) dapat mendaftar, belajar, dan melacak kemajuan mereka.

Tujuan utamanya adalah untuk mendemonstrasikan implementasi dari berbagai konsep Laravel dalam satu aplikasi yang kohesif, termasuk:

-   Otentikasi manual dari dasar.
-   Sistem peran dan otorisasi yang fleksibel.
-   Manajemen sumber daya yang bersarang (Nested Resources).
-   Proses latar belakang menggunakan Queues dan Scheduled Tasks.
-   Pengujian otomatis untuk memastikan keandalan aplikasi.

---

## ✨ Key Features

-   ✅ **Manual Authentication:** Sistem registrasi, login, dan logout yang dibuat dari nol.
-   ✅ **Role-Based Access Control (RBAC):** Tiga peran (Student, Instructor, Admin) dilindungi oleh Middleware kustom.
-   ✅ **Ownership Authorization:** Laravel Policies memastikan instruktur hanya bisa mengelola konten miliknya.
-   ✅ **Course & Lesson Management:** Fungsionalitas CRUD penuh untuk instruktur mengelola kursus dan pelajaran.
-   ✅ **Interactive File Uploads:** Komponen upload thumbnail dengan pratinjau gambar langsung menggunakan Alpine.js.
-   ✅ **Course Enrollment System:** Relasi Many-to-Many antara pengguna dan kursus.
-   ✅ **Student Progress Tracking:** Siswa dapat menandai pelajaran sebagai selesai.
-   ✅ **Database Notifications:** Instruktur menerima notifikasi saat ada siswa baru yang mendaftar.
-   ✅ **Background Jobs:** Menggunakan Laravel Queues untuk menangani pengiriman notifikasi secara asinkron.
-   ✅ **Scheduled Tasks:** Menjalankan tugas pembersihan data secara periodik.
-   ✅ **Automated Testing:** Suite pengujian fitur yang komprehensif menggunakan Pest.

---

## 🛠️ Tech Stack

-   **Backend:** PHP 8.3, Laravel 12
-   **Frontend:** Blade Templates, Tailwind CSS, Alpine.js
-   **Database:** MySQL
-   **Testing:** Pest
-   **Development:** Vite, Laragon/XAMPP/MAMP

---

## ⚙️ Getting Started

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut.

### Prerequisites

Pastikan Anda sudah menginstal perangkat lunak berikut:

-   PHP (versi 8.3 atau lebih tinggi)
-   Composer
-   Node.js dan NPM
-   Database (misalnya MySQL, MariaDB)

### Local Setup

1.  **Clone the repository**

    ```bash
    git clone https://github.com/rakha00/Skoolio-Learning-Management-System.git
    cd skoolio
    ```

2.  **Install PHP dependencies**

    ```bash
    composer install
    ```

3.  **Install JavaScript dependencies**

    ```bash
    npm install
    ```

4.  **Setup environment file**
    Salin file `.env.example` menjadi `.env`.

    ```bash
    cp .env.example .env
    ```

5.  **Generate application key**

    ```bash
    php artisan key:generate
    ```

6.  **Configure your `.env` file**
    Buka file `.env` dan atur koneksi database Anda.

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=db_skoolio
    DB_USERNAME=root
    DB_PASSWORD=your_password
    ```

    Pastikan Anda sudah membuat database `db_skoolio`.

7.  **Run database migrations and seeders**
    Perintah ini akan membuat semua tabel dan mengisinya dengan data dummy (pengguna, kursus, dan pelajaran).

    ```bash
    php artisan migrate:fresh --seed
    ```

8.  **Link the storage directory**

    ```bash
    php artisan storage:link
    ```

9.  **Run the servers**
    Anda perlu menjalankan 3 proses ini di **3 terminal terpisah**:

    ```bash
    # Terminal 1: PHP Server
    php artisan serve

    # Terminal 2: Vite Server (for assets)
    npm run dev

    # Terminal 3: Queue Worker (for background jobs)
    php artisan queue:work
    ```

Aplikasi Anda sekarang berjalan di `http://localhost:8000`.

### Default Login Credentials

Setelah menjalankan seeder, Anda bisa menggunakan akun berikut untuk login:

-   **Role:** Instructor
-   **Email:** `instructor@skoolio.test` (atau cek email lain di database Anda)
-   **Password:** `password`

-   **Role:** Admin
-   **Email:** `admin@skoolio.test`
-   **Password:** `password`

---

## 🧪 Running Tests

Untuk menjalankan suite pengujian otomatis, gunakan perintah berikut:

```bash
php artisan test
```
