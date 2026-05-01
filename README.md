# Web Tech Final Project (PHP)

A PHP-based web application built using an MVC-style structure (**models**, **views**, **controllers**) with separate dashboards/pages for **Admin**, **Employee**, and **Customer** users.

---

## Table of Contents
- [Project Overview](#project-overview)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [User Roles & Main Features](#user-roles--main-features)
- [How to Run (Local Setup)](#how-to-run-local-setup)
- [Database Setup](#database-setup)
- [Notes](#notes)

---

## Project Overview
This project is a Web Technology final project developed in **PHP**.  
It follows an MVC pattern:
- **Controllers** handle requests and actions (logic)
- **Models** handle database queries and data operations
- **Views** contain UI pages (PHP templates)

---

## Tech Stack
- **Backend:** PHP
- **Frontend:** HTML/CSS (CSS stored inside `views/css` and role-based CSS folders)
- **Database:** MySQL (used via `models/dbConnect.php`)
- **Project Type:** MVC structured web app

---

## Project Structure

```text
Web_Tech_Final_Project/
├── controllers/                     # Handles requests (business logic / actions)
│   ├── authControl.php              # Login/authentication actions
│   ├── registerControl.php          # Registration actions
│   ├── passwordControl.php          # Change/reset password actions
│   ├── profileControl.php           # Profile update actions
│   ├── checkEmail.php               # Email checking (validation/AJAX style)
│   ├── checkLoginEmail.php          # Login email checking (validation)
│   ├── categoryControl.php          # Category CRUD actions
│   ├── productControl.php           # Product CRUD actions
│   ├── stockControl.php             # Stock update/manage actions
│   ├── priceControl.php             # Price update/manage actions
│   ├── offerControl.php             # Offers/discount actions
│   ├── orderControl.php             # Order placement/history actions
│   ├── wishlistControl.php          # Wishlist actions
│   └── employeeApprovalControl.php  # Admin approval for employees
│
├── models/                          # Database layer (queries + data operations)
│   ├── dbConnect.php                # Database connection configuration
│   ├── userModel.php                # User-related DB operations
│   ├── productModel.php             # Product-related DB operations
│   ├── categoryModel.php            # Category-related DB operations
│   ├── stockModel.php               # Stock-related DB operations
│   ├── orderModel.php               # Order-related DB operations
│   └── wishlistModel.php            # Wishlist-related DB operations
│
├── views/                           # UI pages (PHP templates)
│   ├── login.php                    # Login page
│   ├── register.php                 # Registration page
│   ├── logout.php                   # Logout handler/page
│   │
│   ├── admin_views/                 # Admin dashboard pages
│   │   ├── home.php
│   │   ├── profile.php
│   │   ├── changePassword.php
│   │   ├── addCategory.php
│   │   ├── manageCategories.php
│   │   ├── stockLogs.php
│   │   ├── employeeApproval.php
│   │   ├── viewAllUsers.php
│   │   └── css/                     # Admin-specific CSS
│   │
│   ├── employee_views/              # Employee dashboard pages
│   │   ├── home.php
│   │   ├── profile.php
│   │   ├── changePassword.php
│   │   ├── addProduct.php
│   │   ├── updateProduct.php
│   │   ├── manageProducts.php
│   │   ├── manageStock.php
│   │   ├── manageOffers.php
│   │   ├── addCustomer.php
│   │   ├── manageCustomers.php
│   │   └── css/                     # Employee-specific CSS
│   │
│   ├── customer_views/              # Customer-facing pages
│   │   ├── home.php
│   │   ├── browseProducts.php
│   │   ├── wishlist.php
│   │   ├── orderHistory.php
│   │   ├── profile.php
│   │   ├── changePassword.php
│   │   └── css/                     # Customer-specific CSS
│   │
│   └── css/
│       └── styles.css               # Global/common stylesheet
│
└── uploads/
    └── products/                    # Uploaded/static product images (jpg/png/webp)
```

---

## User Roles & Main Features

### Admin
- Dashboard (`views/admin_views/home.php`)
- Manage categories
- View all users
- View stock logs
- Approve employee accounts
- Manage admin profile & password

### Employee
- Dashboard (`views/employee_views/home.php`)
- Add / update / manage products
- Manage stock
- Manage offers
- Add / manage customers
- Manage employee profile & password

### Customer
- Dashboard (`views/customer_views/home.php`)
- Browse products
- Wishlist management
- Order history
- Manage customer profile & password

---

## How to Run (Local Setup)

### Option A: Using XAMPP 
1. Install **XAMPP** 
2. Copy the project folder into your web server directory:
   - XAMPP: `htdocs/`
3. Start:
   - **Apache**
   - **MySQL**
4. Open the project in browser, for example:
   - `http://localhost/Web_Tech_Final_Project/views/login.php`





## Database Setup
1. Create a MySQL database (example name: `web_tech_final_project`)
2. Import your `.sql` file into the database (if you have one)
3. Configure database credentials in:
   - `models/dbConnect.php`

Example values you may need to set:
- Host: `localhost`
- User: `root`
- Password: ``
- Database name: (your DB name)

---

## Notes
- Product images are stored in: `uploads/products/`
- CSS is separated into:
  - Global CSS: `views/css/styles.css`
  - Role-based CSS folders inside each role view directory

---

### Author
- GitHub: [faysal-khann](https://github.com/faysal-khann)
