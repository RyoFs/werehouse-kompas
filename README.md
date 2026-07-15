# 📦 Werehouse-Kompas

Werehouse-Kompas is a web-based equipment borrowing and inventory management system developed for organizational use. The application streamlines equipment inventory, borrowing, returns, availability tracking, and report generation through an intuitive interface.

Built with Laravel, the system provides efficient asset management with Excel/CSV export capabilities and comprehensive filtering for borrowing history.

---

## ✨ Features

### 🔐 Authentication
- Secure user login
- Session-based authentication

### 📦 Equipment Management
- Add, edit, and delete equipment
- Equipment categories
- Search and filter equipment
- Equipment image upload
- Equipment availability tracking

### 👤 Borrower Management
- Borrower information management
- Borrowing history

### 📋 Borrowing Management
- Create borrowing transactions
- Borrow multiple equipment
- Borrow status management
- Due date management

### 🔄 Return Management
- Equipment return process
- Actual return date recording
- Automatic stock availability update

### 📊 Reports
- Filter reports by:
  - Borrow Date
  - Due Date
  - Actual Return Date
- Export to Excel (.xlsx)
- Export to CSV

### ⚙️ Dashboard
- Total equipment
- Active borrowings
- Returned equipment
- Equipment availability summary

---

## 🛠️ Tech Stack

| Category | Technology |
|----------|------------|
| Framework | Laravel 12 |
| Programming Language | PHP 8.3 |
| Database | MySQL |
| Frontend | Blade Template Engine |
| Styling | HTML5, CSS3, Bootstrap 5 |
| JavaScript | JavaScript, jQuery |
| Icons | Bootstrap Icons |
| Data Export | Laravel Excel (PhpSpreadsheet) |
| Development Environment | Laragon |
| Dependency Manager | Composer |
| Package Manager | NPM |
| Version Control | Git & GitHub |

---

## 📸 Application Preview

### Login

![Login](images/login.png)

### Dashboard

![Dashboard](images/dashboard.png)

### Equipment Management

![Equipment](images/alat.png)

### Borrowing

![Borrowing](images/peminjaman.png)

---

## 📂 Project Structure

```
app/
├── Http/
├── Models/
├── Exports/
├── Providers/

resources/
├── views/
├── css/
├── js/

routes/
├── web.php

database/
├── migrations/
```

---

## 📋 Requirements

- PHP 8.3+
- Composer
- Node.js
- NPM
- MySQL
- Laragon (recommended)

## 🚀 Installation

### 1. Clone the repository

```bash
git clone https://github.com/yourusername/werehouse-kompas.git
```

### 2. Open the project

```bash
cd werehouse-kompas
```

### 3. Install dependencies

```bash
composer install
npm install
```

### 4. Copy environment file

```bash
cp .env.example .env
```

### 5. Generate application key

```bash
php artisan key:generate
```

### 6. Configure database

Edit the `.env` file.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Run migrations

```bash
php artisan migrate
```

### 8. Build frontend assets

```bash
npm run build
```

### 9. Start the application

Using Laragon, simply start Apache and MySQL, then open:

```
http://localhost/werehouse-kompas/public
```

---

## 📊 Report Export

The reporting module supports:

- Excel (.xlsx)
- CSV (.csv)

Available filters:

- Borrow Date
- Due Date
- Actual Return Date

Designed to simplify administrative reporting and documentation.

---

## 🚀 Key Highlights

- Responsive web application
- Equipment inventory management
- Borrowing & return workflow
- Excel & CSV export
- Advanced report filtering
- User authentication
- Clean and responsive Bootstrap interface
- Built with Laravel MVC architecture

## 📁 License

This project is intended for educational and portfolio purposes.

---

## 👨‍💻 Author

**Ryo Fahrezi**

* Laravel Developer
* PHP Developer
* Web Application Developer

If you find this project helpful, feel free to give it a ⭐ on GitHub.

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?logo=bootstrap&logoColor=white)
![jQuery](https://img.shields.io/badge/jQuery-0769AD?logo=jquery&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green)
