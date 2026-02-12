# 📚 GLS Convocations System

> **Professional exam convocation management & PDF generation system for GLS Sprachenzentrum**

![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php&logoColor=white)
![Mysql](https://img.shields.io/badge/MySQL-Database-003B57?logo=mysql&logoColor=white)
![PDF](https://img.shields.io/badge/PDF-Browsershot-FF6B6B?logo=adobe&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green)

---

## 🎯 Project Overview

**GLS Convocations** is a Laravel-based application designed to streamline the management and distribution of exam convocation letters for students at GLS Sprachenzentrum (Centre Marrakech).

The system allows administrators to:

- **Import student data** via JSON
- **Generate professional exam convocation PDFs** for individual students or bulk export
- **Manage exam details** (dates, times, venues, student information)
- **Export multi-page PDF documents** with all convocations combined

Perfect for educational institutions that need to send official exam invitations to hundreds of students efficiently.

---

## ✨ Features

### 📋 Core Features

✅ **JSON Data Import**

- Bulk import student data via structured JSON payloads
- Automatic data validation and error handling
- Support for required fields: `full_name`, `student_code`
- Optional fields: `class_name`, `reference`
- Atomic transactions (all-or-nothing imports)

✅ **Student Management**

- Store student convocation data in MySql database
- Pagination support (30 students per page)
- Search & filter by name, student code, class, or reference
- Unique student code enforcement

✅ **Individual PDF Export**

- Generate single-page professional PDF convocation
- A4 format with professional layout
- Includes: student name, code, class, exam dates/times, venue
- Pre-formatted with GLS logo and institutional branding
- Automatic background color preservation for printing

✅ **Bulk Multi-Page PDF Export**

- Export all filtered students to single PDF document
- Combined multi-page PDF (138+ students in one file)
- Same professional design as individual PDFs
- Instant download (synchronous generation)
- No queue/job delays

✅ **Advanced Filtering**

- Filter by class/room assignment
- Full-text search across student names, codes, and references
- Filters persist in export actions

✅ **Error Handling & Validation**

- JSON structure validation
- Required field enforcement
- User-friendly error messages
- Automatic logging of all operations

---

## 🛠️ Tech Stack

### Backend

- **Framework**: Laravel 12.0
- **Language**: PHP 8.2+
- **Database**: MySql (lightweight, file-based)
- **PDF Generation**: Spatie Browsershot (Chrome/Chromium-based)
- **Server**: Laravel Development Server

### Frontend

- **Templating**: Blade (Laravel native)
- **Styling**: Tailwind CSS 4.0
- **Build Tool**: Vite 7.0
- **Icons & UI**: Modern HTML5 + CSS3

### Development Tools

- **Package Manager**: Composer (PHP), npm (JavaScript)
- **Testing**: PHPUnit 11.5
- **Code Quality**: Laravel Pint (PHP linter)
- **Development CLI**: Artisan

### Key Dependencies

- `spatie/browsershot` (^5.2) - PDF rendering via headless Chrome
- `barryvdh/laravel-dompdf` (^3.1) - Alternative PDF library
- `laravel/tinker` (^2.10.1) - Laravel REPL for debugging
- `puppeteer` (^24.37.2) - Headless browser automation

---

## 📦 Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js 18+ (for npm)
- Chrome/Chromium browser (for PDF generation via Browsershot)
- Git (for version control)

### Quick Start

#### 1. Clone Repository

```bash
git clone https://github.com/Rochdi7/gls-convocation.git
cd gls-convocation
```

#### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

#### 3. Setup Environment

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create MySql database
php artisan migrate --force
```

#### 4. Build Assets

```bash
# Production build
npm run build

# Development with hot reload
npm run dev
```

#### 5. Start Development Server

```bash
# Start Laravel development server (port 8000)
php artisan serve

# In another terminal, monitor logs
php artisan pail
```

#### Alternative: One-Command Setup

```bash
composer run setup
```

---

## 🔧 Environment Setup

### .env Configuration

Create `.env` file with the following essential variables:

```bash
APP_NAME="GLS Convocations"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database (MySql)
DB_CONNECTION=MySql
DB_DATABASE=database/database.MySql

# Queue Configuration
QUEUE_CONNECTION=sync

# Session Configuration
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Cache Configuration
CACHE_DRIVER=file

# Log Configuration
LOG_CHANNEL=single
LOG_LEVEL=debug
```

### For Production

```bash
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_DATABASE=gls_convocations
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password
```

---

## 📊 Project Structure

```
gls-convocations/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ExamConvocationController.php      # Main CRUD
│   │   │   └── Convocations/
│   │   │       └── ConvocationExportController.php  # PDF exports
│   │   └── Middleware/
│   ├── Models/
│   │   └── ExamStudent.php                        # Student model
│   ├── Services/
│   │   └── ConvocationPdfService.php              # PDF service
│   └── Providers/
│       └── AppServiceProvider.php
├── database/
│   ├── migrations/
│   │   └── 2026_02_12_143044_create_exam_students_table.php
│   └── seeders/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       └── convocations/
│           ├── index.blade.php
│           └── pdf.blade.php
├── routes/
│   └── web.php
├── storage/
│   ├── app/convocations/
│   └── logs/
├── tests/
├── composer.json
├── package.json
└── vite.config.js
```

---

## 🚀 Usage Guide

### Starting the Application

```bash
# Development mode
php artisan serve
npm run dev

# Access: http://localhost:8000/convocations
```

### Workflow: Import → Filter → Export

#### Step 1: Import Student Data

**Prepare JSON**:

```json
[
    {
        "full_name": "Sara Benali",
        "student_code": "GLS-A2-0001",
        "class_name": "Salle 1",
        "reference": "E1"
    }
]
```

**Required Fields**: `full_name`, `student_code`  
**Optional Fields**: `class_name`, `reference`

1. Paste JSON into textarea
2. Click **"Importer JSON"**
3. Success message appears

#### Step 2: View Student List

Students are displayed with pagination, search, and individual PDF options.

#### Step 3: Export Individual PDF

Click **"PDF"** button next to any student to download their convocation.

#### Step 4: Export Bulk PDF

Click **"Exporter toutes les convocations (PDF)"** to download all students in a single multi-page PDF.

---

## 📋 API Routes

| Method | Endpoint                       | Controller                               | Description        |
| ------ | ------------------------------ | ---------------------------------------- | ------------------ |
| `GET`  | `/convocations`                | ExamConvocationController@index          | List all students  |
| `POST` | `/convocations/import-json`    | ExamConvocationController@importJson     | Import JSON data   |
| `GET`  | `/convocations/{student}/pdf`  | ExamConvocationController@exportPdf      | Single student PDF |
| `GET`  | `/convocations/export/all-pdf` | ConvocationExportController@exportAllPdf | Bulk PDF export    |

---

## 🧠 Core Components

### ExamStudent Model

```php
// Location: app/Models/ExamStudent.php

$fillable = ['full_name', 'student_code', 'class_name', 'reference'];
$casts = ['letter_date' => 'date'];
```

### ConvocationPdfService

```php
// Location: app/Services/ConvocationPdfService.php

public function generate(ExamStudent $student): string
// Returns: path to generated PDF file
```

### ExamConvocationController

```php
public function index()              // List students
public function importJson()         // Import from JSON
public function exportPdf()          // Single student PDF
```

### ConvocationExportController

```php
public function exportAllPdf()      // Bulk PDF export
// Fetches filtered students
// Generates combined PDF
// Streams download
```

---

## 📋 Database Schema

### exam_students Table

| Column        | Type         | Description                |
| ------------- | ------------ | -------------------------- |
| id            | BIGINT       | Primary key                |
| full_name     | VARCHAR(255) | Student name (required)    |
| student_code  | VARCHAR(255) | Unique ID (required)       |
| class_name    | VARCHAR(255) | Room assignment (optional) |
| reference     | VARCHAR(255) | Reference code (optional)  |
| level         | VARCHAR(255) | Exam level (A2)            |
| center_name   | VARCHAR(255) | Center name                |
| exam_dates    | VARCHAR(255) | Exam dates                 |
| exam_time     | VARCHAR(255) | Exam time                  |
| address_block | TEXT         | Venue address              |
| created_at    | TIMESTAMP    | Created date               |
| updated_at    | TIMESTAMP    | Updated date               |

---

## 🎚️ Configuration

### Application Configuration (`config/app.php`)

```php
'name' => env('APP_NAME', 'GLS Convocations')
'env' => env('APP_ENV', 'production')
'debug' => env('APP_DEBUG', false)
'timezone' => 'UTC'
'locale' => 'fr'  // French
```

### Database Configuration (`config/database.php`)

```php
'default' => env('DB_CONNECTION', 'MySql')
'database' => env('DB_DATABASE', database_path('database.MySql'))
```

### Queue Configuration (`config/queue.php`)

```php
'default' => env('QUEUE_CONNECTION', 'sync')
// Options: sync, database, redis
```

---

## 🐛 Troubleshooting

### Browsershot PDF Generation Fails

**Solution**:

```bash
npm install --save puppeteer
```

For Windows, ensure Chrome/Chromium is installed or use Puppeteer's bundled version.

---

### JSON Import Errors

**Check**:

1. Valid JSON syntax ([jsonlint.com](https://jsonlint.com))
2. Required fields: `full_name`, `student_code`
3. Array format: `[{}, {}]` or `{"students": [{}, {}]}`

**Example**:

```json
[
    {
        "full_name": "John Doe",
        "student_code": "A001"
    }
]
```

---

### Storage Directory Permissions

**Linux/Mac**:

```bash
chmod -R 775 storage bootstrap/cache
```

**Windows**: Ensure IIS/Apache user has write permissions.

---

### Port Already in Use

**Solution**:

```bash
php artisan serve --port=8001
```

---

### Vite Hot Module Reload Not Working

**Solution**:

```bash
npm run dev
```

Or clear cache:

```bash
rm -rf node_modules/.vite
npm run dev
```

---

## 🚀 Production Deployment

### Pre-Deployment Checklist

```bash
# 1. Clone repository
git clone https://github.com/Rochdi7/gls-convocation.git
cd gls-convocation

# 2. Install dependencies
composer install --optimize-autoloader --no-dev
npm install --omit=dev
npm run build

# 3. Configure environment
cp .env.example .env
# Edit .env for production

# 4. Generate app key
php artisan key:generate

# 5. Run migrations
php artisan migrate --force

# 6. Set permissions
chmod -R 775 storage bootstrap/cache

# 7. Clear caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Environment Variables (Production)

```bash
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxx

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=gls_convocations
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password

QUEUE_CONNECTION=database
SESSION_DRIVER=cookie
CACHE_DRIVER=redis
LOG_LEVEL=warning
```

### Server Requirements

- PHP 8.2+ with `pdo`, `MySql`, `gd`, `fileinfo`
- Web server: Apache, Nginx
- Chrome/Chromium installed
- 2GB+ RAM recommended
- 1GB+ disk space

---

## 📖 Development Workflow

### Local Development

```bash
# Terminal 1: Web server
php artisan serve

# Terminal 2: Asset watcher
npm run dev

# Terminal 3: Log monitoring
php artisan pail

# Terminal 4 (if using queue): Process jobs
php artisan queue:work --tries=1
```

### Running Tests

```bash
# All tests
php artisan test

# Specific test
php artisan test tests/Feature/ExampleTest.php

# With coverage
php artisan test --coverage
```

### Code Quality

```bash
# PHP linting
./vendor/bin/pint

# Fix issues
./vendor/bin/pint --repair
```

### Database Migrations

```bash
# Create migration
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Rollback
php artisan migrate:rollback

# Fresh migration
php artisan migrate:fresh --seed
```

### Artisan Tinker (REPL)

```bash
php artisan tinker

# In tinker:
>>> $students = App\Models\ExamStudent::all();
>>> $students->count();
```

---

## 📚 Additional Resources

- **Laravel Documentation**: https://laravel.com/docs
- **Spatie Browsershot**: https://github.com/spatie/browsershot
- **Vite Documentation**: https://vitejs.dev
- **Tailwind CSS**: https://tailwindcss.com
- **Eloquent ORM**: https://laravel.com/docs/eloquent

---

## 🤝 Contributing

Contributions are welcome! Follow the standard Git workflow:

```bash
# Create feature branch
git checkout -b feature/your-feature

# Make changes
git add .
git commit -m "Add your feature"

# Push
git push origin feature/your-feature

# Create pull request
```

---

## 📝 License

This project is licensed under the **MIT License** - see LICENSE file for details.

MIT License © 2026 GLS Sprachenzentrum

---

## 📞 Support & Contact

For issues or questions:

- **GitHub Issues**: [Create an issue](https://github.com/Rochdi7/gls-convocation/issues)
- **Documentation**: See project wiki

---

## 🎉 Credits

**Project by**: Rochdi7  
**Institution**: GLS Sprachenzentrum  
**Location**: Centre Marrakech, Morocco

**Built with**:

- Laravel - PHP web framework
- Spatie Browsershot - PDF rendering
- Tailwind CSS - Modern styling

---

<div align="center">

### Made with ❤️ for Educational Excellence

**Last Updated**: February 12, 2026  
**Version**: 1.0

[⬆ back to top](#-gls-convocations-system)

</div>
