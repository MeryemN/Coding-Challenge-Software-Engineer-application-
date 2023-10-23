# Fullstack Laravel-VueJS

This project is a full-stack web application template integrating Laravel 8 and Vue.js 3.

## Requirements

- PHP 7.4
- Node.js
- Vue 3
- Laravel 8
- MySQL

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/MeryemN/Coding-Challenge-Software-Engineer-application-.git
   cd Coding-Challenge-Software-Engineer-application-
   ```

2. **Set up the environment:**
   Copy the `.env.example` file to create your own `.env` file. Update your database credentials:

   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1                # localhost
   DB_PORT=3306                     # default port for MySQL Database
   DB_DATABASE=your_database_name
   DB_USERNAME=your_db_user
   DB_PASSWORD=your_db_password     # (if set)
   ```

3. **Install dependencies:**
   If you don't see directories like `node_modules/` and `vendor/`, install the project dependencies:

   ```bash
   composer install
   npm install
   ```

4. **Run the application:**

   - To start the PHP server:
     ```bash
     php artisan serve
     ```
   - To compile your Vue.js assets, run:
     ```bash
     npm run dev
     ```

5. **For creation of product from cli run this command with your params:**

   ```bash
    - php artisan product:create "Product by cli" "cli" 100 1 "C:\Users\lenovo\Downloads\images.png"
     ```