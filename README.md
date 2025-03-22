Expense Tracker Application



🚀 Introduction

Expense Tracker is a powerful and easy-to-use web application built with Laravel 11.9 and PHP 8.2+. It helps users track their daily expenses, analyze spending habits, and manage finances effectively. With authentication, bulk expense management, and insightful analytics, this application is a perfect tool for personal and small expense tracking.

✨ Features

🔑 Authentication

Secure login system

Forgot password & reset functionality

Profile update

Two-Step Authentication using Google Authenticator

👉 **To enable authenticator verification, simply enable the two_fa_verification key from the users table.**


💰 Expense Management

Manage expense categories

Add, edit, delete expenses

Bulk date-wise expense management

View detailed transactions

📊 Analytics & Insights

Interactive chart-based data analysis

Monthly expense tracking

Category-wise expense breakdown

⚡ Other Features

Clean & responsive UI

Secure and scalable architecture

Built with Laravel's best practices

🛠️ Tech Stack

Framework: Laravel 11.9

Language: PHP 8.2+

Database: MySQL / PostgreSQL (configurable)

Authentication: Laravel Sanctum, Google Authenticator (2FA)

Frontend: Blade templates, Bootstrap

Charts & Graphs: Chart.js

## 📥 Installation Guide

1. Clone the repository:
   ```bash
   git clone https://github.com/vatsal-ajmera/Expense-Tracker-Application.git
   cd Expense-Tracker-Application
   ```
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```
3. Configure the environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Set up database & migrations:
   ```bash
   php artisan migrate --seed
   ```
5. Start the server:
   ```bash
   php artisan serve
   ```
6. Access the application at: `http://localhost:8000`


💡 Contribution

Contributions are welcome! Feel free to fork the repo and submit pull requests.

📄 License

This project is open-source and available under the MIT License.

🌟 Star this repository if you found it useful! 🚀

