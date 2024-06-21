# Blood Donation Management System

This project is a web application developed for managing donations and appointments related to blood donations.

## Technologies Used

- Laravel PHP Framework
- MySQL Database
- JavaScript (if applicable)
- HTML/CSS (if applicable)

## Prerequisites

Before you begin, ensure you have met the following requirements:

- PHP >= 8.2 installed globally on your machine.
- Composer installed globally on your machine.
- MySQL database server installed locally or remotely.

## Installation

1. **Clone the repository**

   ```bash
   git clone <repository-url>
   cd blood-app

2. **Install Composer Dependencies**

   ```bash
   composer install
   
3. **Copy Environmental file**
    ```bash
    cp .env.example .env

4. **Generate Application Key**
    ```
   php artisan key:generate
   
5. **Run Database Migrations**
    ```
   php artisan migrate

6. **Start the Development Server**
    ```
   php artisan serve

7. **Access the Application**
   Open your web browser and navigate to http://localhost:8000 

