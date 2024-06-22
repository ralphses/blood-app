# Blood Donation Management System

This project is a web application developed for managing donations and appointments related to blood donations.

## Technologies Used

- Laravel PHP Framework
- MySQLite
- HTML/CSS (if applicable)

## Prerequisites

Before you begin, ensure you have met the following requirements:

- PHP >= 8.2 installed globally on your machine.
- Composer installed globally on your machine. Get Composer here https://getcomposer.org/download/
- MySQL database server installed locally or remotely.

## Installation

1. **Clone the repository**

   ```
   git clone https://github.com/ralphses/blood-app.git
   cd blood-app

2. **Install Composer Dependencies**

   ```
   composer install
   
3. **Install Node.js dependencies**
    ```
   npm install
   
4. **Copy Environmental file**
    ```
    cp .env.example .env

5. **Generate Application Key**
    ```
   php artisan key:generate
   
6. **Run Database Migrations**
    ```
   php artisan migrate

7. **Start the Development Server**
    ```
   php artisan serve

8. **Access the Application**
   Open your web browser and navigate to http://localhost:8000 

