A comprehensive receipt management system built with Laravel, featuring JWT authentication and complete CRUD operations. This application demonstrates modern web development practices with GraphQL integration and a well-structured database design.

## ✨ Features

- **User Authentication**: Secure JWT-based authentication system
- **Receipt Management**: Full CRUD operations (Create, Read, Update, Delete)
- **GraphQL API**: Modern API architecture with GraphQL schemas
- **Database Structure**: Complete migration system with seeders
- **RESTful API**: Traditional REST endpoints alongside GraphQL
- **Data Validation**: Comprehensive input validation and error handling

## 🛠 Tech Stack

- **Framework**: Laravel 10.x
- **Authentication**: JWT (JSON Web Tokens)
- **API**: GraphQL + REST
- **Database**: MySQL
- **PHP**: 8.1+

## 📋 Requirements

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js & NPM (for frontend assets)

## 🚀 Installation

1. **Clone the repository**
    
    `git clone https://github.com/ciottamauricio/laravel12-api`
    `cd laravel12-api`
    
2. **Install PHP dependencies**
    
    `composer install`
    
3. **Environment setup**
    
    `cp .env.example .env`
    `php artisan key:generate`
    
4. **Configure database**
    - Update **`.env`** file with your database credentials
    
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=receipt_management
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    
5. **Run migrations and seeders**
    
    `php artisan migrate`
    `php artisan db:seed`
    
6. **JWT Secret**
    
    `php artisan jwt:secret`
    
7. **Start the development server**
    
    `php artisan serve`
    

## 📊 Database Structure

The application includes:

- **Users table**: User authentication and profile management
- **Receipts table**: Receipt data with relationships
- **Migrations**: Structured database schema
- **Seeders**: Sample data for testing and development

## 🔗 API Endpoints

## Authentication

- **`POST /api/auth/register`** - User registration
- **`POST /api/auth/login`** - User login
- **`POST /api/auth/logout`** - User logout
- **`POST /api/auth/refresh`** - Token refresh

## Receipts (CRUD)

- **`GET /api/receipts`** - List all receipts
- **`POST /api/receipts`** - Create new receipt
- **`GET /api/receipts/{id}`** - Get specific receipt
- **`PUT /api/receipts/{id}`** - Update receipt
- **`DELETE /api/receipts/{id}`** - Delete receipt

## Customers (CRUD)

- **`GET /api/customers`** - List all customers
- **`POST /api/customers`** - Create new customer
- **`GET /api/customers/{id}`** - Get specific customer
- **`PUT /api/customers/{id}`** - Update customer
- **`DELETE /api/customers/{id}`** - Delete customer

## Products (CRUD)

- **`GET /api/products`** - List all products
- **`POST /api/products`** - Create new product
- **`GET /api/products/{id}`** - Get specific product
- **`PUT /api/products/{id}`** - Update product
- **`DELETE /api/products/{id}`** - Delete product

## GraphQL

- **`POST /graphql`** - GraphQL endpoint
- **`GET /graphiql`** - GraphQL playground (development only)

### Postman Collection
A complete Postman collection with all API endpoints is available in the project root:

📁 **`laravel12-api.postman_collection.json`**


## 📖 Documentation

Complete API documentation will be available soon!

## 📚 Key Learning Outcomes

This project demonstrates:

- Laravel framework proficiency
- JWT authentication implementation
- GraphQL API development
- Database design and migrations
- RESTful API principles
- Modern PHP development practices


## 👤 Author

**Maurício Ciotta Oliveira** - https://www.linkedin.com/in/mauricio-ciotta/