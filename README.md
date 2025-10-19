# School - Learning Management System (LMS)

![PHP](https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=for-the-badge\&logo=php)
![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge\&logo=laravel)
![Testing](https://img.shields.io/badge/Testing-Pest-C5A13A?style=for-the-badge\&logo=pest)
![License](https://img.shields.io/badge/License-MIT-blue.svg?style=for-the-badge)

School is a functional prototype of a Learning Management System (LMS) built entirely using Laravel 12. This project was created from scratch with the goal of exploring the core and advanced features of the Laravel framework in depth, focusing on best practices and modern workflows.

![School Screenshot Placeholder](https://i.imgur.com/TTOD7Yn.jpeg)

---

## 🚀 About The Project

This project simulates an e-learning platform where instructors can create and manage courses and lessons, and students can register, learn, and track their progress.

The main purpose is to demonstrate the implementation of various Laravel concepts within a cohesive application, including:

* Manual authentication built from the ground up.
* Flexible role and authorization system.
* Nested resource management.
* Background processes using queues and scheduled tasks.
* Automated testing to ensure application reliability.

---

## ✨ Key Features

* ✅ **Manual Authentication:** Custom-built registration, login, and logout system.
* ✅ **Role-Based Access Control (RBAC):** Three roles (Student, Instructor, Admin) protected by custom middleware.
* ✅ **Ownership Authorization:** Laravel policies ensuring instructors can only manage their own content.
* ✅ **Course & Lesson Management:** Full CRUD functionality for instructors to manage courses and lessons.
* ✅ **Interactive File Uploads:** Thumbnail upload component with live image preview using Alpine.js.
* ✅ **Course Enrollment System:** Many-to-Many relationship between users and courses.
* ✅ **Student Progress Tracking:** Students can mark lessons as completed.
* ✅ **Database Notifications:** Instructors receive notifications when new students enroll.
* ✅ **Background Jobs:** Laravel queues to handle asynchronous notification sending.
* ✅ **Scheduled Tasks:** Periodic data cleanup tasks.
* ✅ **Automated Testing:** Comprehensive feature test suite using Pest.

---

## 🛠️ Tech Stack

* **Backend:** PHP 8.3, Laravel 12
* **Frontend:** Blade Templates, Tailwind CSS, Alpine.js
* **Database:** MySQL
* **Testing:** Pest
* **Development:** Vite, Laragon/XAMPP/MAMP

---

## ⚙️ Getting Started

To run this project locally, follow the steps below.

### Prerequisites

Make sure you have the following installed:

* PHP (version 8.3 or higher)
* Composer
* Node.js and NPM
* Database (e.g., MySQL, MariaDB)

### Local Setup

1. **Clone the repository**

```bash
git clone https://github.com/rakha00/School-Learning-Management-System.git
cd School
```

2. **Install PHP dependencies**

```bash
composer install
```

3. **Install JavaScript dependencies**

```bash
npm install
```

4. **Set up the environment file**
   Copy `.env.example` to `.env`

```bash
cp .env.example .env
```

5. **Generate the application key**

```bash
php artisan key:generate
```

6. **Configure your `.env` file**
   Open `.env` and set your database connection:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_School
DB_USERNAME=root
DB_PASSWORD=your_password
```

Make sure you have created the `db_School` database.

7. **Run migrations and seeders**
   This will create tables and populate dummy data (users, courses, lessons).

```bash
php artisan migrate:fresh --seed
```

8. **Link the storage directory**

```bash
php artisan storage:link
```

9. **Run the servers**
   You need to run these 3 commands in **3 separate terminals**:

```bash
# Terminal 1: PHP server
php artisan serve

# Terminal 2: Vite server (for assets)
npm run dev

# Terminal 3: Queue worker (for background jobs)
php artisan queue:work
```

Your application will now be accessible at `http://localhost:8000`.

### Default Login Credentials

After running seeders, you can log in using these accounts:

* **Role:** Instructor
  **Email:** `instructor@School.test` (or check other emails in your database)
  **Password:** `password`

* **Role:** Admin
  **Email:** `admin@School.test`
  **Password:** `password`

---

## 🧪 Running Tests

To run the automated test suite, use:

```bash
php artisan test
```