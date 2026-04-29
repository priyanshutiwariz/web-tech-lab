# 🚀 Priyanshu Tiwari — Full Stack Web Technology Project
**USN:** 24BTTCN001  

A complete full-stack web development system built using **HTML, CSS, JavaScript, PHP, and MySQL**, covering everything from static web design to dynamic backend-driven applications with authentication, sessions, and live deployment.

---

## 🌐 Live Deployment
👉 https://priyanshuworks.fwh.is  

## 📂 Source Code
👉 https://github.com/priyanshutiwariz/web-tech-lab.git

---

# 🧠 Project Overview

This project is a **comprehensive implementation of web technologies**, structured into multiple exercises that progressively build a fully functional system.

It demonstrates:

- Frontend UI/UX development
- Backend logic implementation
- Database connectivity and management
- Authentication systems
- Session and cookie handling
- Real-world deployment workflow

---

# ⚙️ Tech Stack

| Layer        | Technologies Used |
|-------------|-----------------|
| Frontend     | HTML5, CSS3 |
| Scripting    | JavaScript |
| Backend      | PHP |
| Database     | MySQL |
| Hosting      | InfinityFree |
| Versioning   | Git & GitHub |

---

# ✨ Key Features

### 🔐 Authentication System
- User Registration & Login (PHP + MySQL)
- Password handling with secure logic
- Session-based login persistence
- Logout system

### 🛒 E-Commerce System
- Product listing from database
- Category filtering and sorting
- Cart simulation
- Checkout flow (pseudo-functional)

### 🎨 UI/UX
- Multi-page structured website
- Clean and minimal interface
- Styled using inline, internal, and external CSS
- Responsive layout principles

### ⚡ JavaScript Features
- Form validation
- Event handling (search, filtering, sorting)
- Scientific calculator with advanced operations

### 🗄️ Database Integration
- MySQL-based product storage
- Dynamic data retrieval using PHP
- Structured schema for scalability

---

# 📁 Project Structure

```
lab-exercises/
│
├── exercise-1-personal-website/
│   ├── index.html
│   ├── about.html
│   ├── projects.html
│   └── contact.html
│
├── exercise-2-css-enhancement/
│
├── exercise-3-ecommerce/
│
├── exercise-4-ecommerce-css/
│
├── exercise-5-calculator/
│
├── exercise-6-login-validation/
│
├── exercise-7-event-handling/
│
├── exercise-8-php-forms/
│   ├── register.php
│   ├── login.php
│   └── contact.php
│
├── exercise-9-mysql-products/
│   ├── db.php
│   ├── index.php
│   └── add_product.php
│
├── exercise-10-sessions-cookies/
│   ├── login.php
│   ├── cart.php
│   ├── checkout.php
│   └── logout.php
│
└── index.html (Main Dashboard)
```

---

# 🧩 Exercise Breakdown

## 🔹 Exercise 1 — Personal Website
- Multi-page HTML website
- Navigation across pages
- Portfolio-style content

---

## 🔹 Exercise 2 — CSS Enhancement
- Applied:
  - Inline CSS
  - Internal CSS
  - External CSS
- Improved design and layout

---

## 🔹 Exercise 3 — Static E-Commerce
- Product listing using HTML
- Structured layout

---

## 🔹 Exercise 4 — Styled E-Commerce
- Enhanced UI with CSS
- Better layout and aesthetics

---

## 🔹 Exercise 5 — Scientific Calculator
- Built using JavaScript
- Supports:
  - Arithmetic operations
  - Trigonometric functions
  - Square root

---

## 🔹 Exercise 6 — Form Validation
- Login & Registration forms
- JavaScript validation

---

## 🔹 Exercise 7 — Event Handling
- Dynamic filtering and sorting
- Real-time UI updates

---

## 🔹 Exercise 8 — PHP Forms
- Backend form handling
- Data processing using POST

---

## 🔹 Exercise 9 — MySQL Integration
- Database connection using PHP
- Product storage and retrieval

---

## 🔹 Exercise 10 — Sessions & Cookies
- User session management
- Persistent login handling
- Logout system

---

# 🗄️ Database Schema

```sql
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    category VARCHAR(100),
    price DECIMAL(10,2),
    rating DECIMAL(3,1),
    stock VARCHAR(50),
    brand VARCHAR(100),
    inCart TINYINT(1)
);
```

# 🛠️ Installation & Setup

## 1. Clone Repository: git clone https://github.com/priyanshutiwari/web-technology-lab.git

## 2. Setup Database

* Create database in InfinityFree
* Update credentials in db.php

```
$host = "your_host";
$user = "your_user";
$password = "your_password";
$database = "your_database";
```

## 3. Upload Files

* Upload all folders to htdocs/
* Maintain structure

## 4. Run Project: https://yourdomain/

# 🎯 Learning Outcomes

* Full-stack development understanding
* Client-server architecture
* Database connectivity
* Authentication systems
* Deployment process
* Real-world project structuring

⸻

# 🚀 Future Improvements

* Payment gateway integration
* Admin dashboard
* Product image uploads
* API-based architecture
* Advanced security (JWT, CSRF)

⸻

# 👨‍💻 Author

## Priyanshu Tiwari

⸻

# ⭐ Final Note

This project represents a complete journey from basic HTML development to a deployed full-stack system, showcasing practical implementation of modern web technologies.

⸻

