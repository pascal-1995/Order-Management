# Mini Order Management API

A REST API built with Laravel for managing products and customer orders.

## Technologies

- PHP 8+
- Laravel 10+
- MySQL
- Laravel Sanctum
- REST API

## Features

- User registration
- User login/logout
- Sanctum API authentication
- Product CRUD
- Product search and filtering
- Create orders
- View user orders
- View order details
- Stock validation
- Automatic stock deduction
- Order total calculation
- Database transactions
- Row locking to prevent stock race conditions
- API rate limiting
- Database seeders

## Installation

Clone the repository:

git clone YOUR_REPOSITORY_URL
- cd order-management

Install dependencies:
- composer install

Create environment file:
- cp .env.example .env

Run migrations and seed sample products:
- php artisan migrate --seed

Generate application key:
- php artisan key:generate

Configure MySQL in .env:
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=order_management
    DB_USERNAME=root
    DB_PASSWORD=

Start the application:
- php artisan serve

## Authentication

The application uses Laravel Sanctum token-based authentication.


## Authenticated endpoints require the following header:

| Method | Endpoint      | Description   |
| ------ | ------------- | ------------- |
| POST   | /api/register | Register user |
| POST   | /api/login    | Login user    |
| POST   | /api/logout   | Logout user   |

## Products endpoints

| Method | Endpoint           | Description    |
| ------ | ------------------ | -------------- |
| GET    | /api/products      | List products  |
| POST   | /api/products      | Create product |
| GET    | /api/products/{id} | Get product    |
| PATCH  | /api/products/{id} | Update product |
| DELETE | /api/products/{id} | Delete product |

## Orders

| Method | Endpoint         | Description                 |
| ------ | ---------------- | --------------------------- |
| POST   | /api/orders      | Create order                |
| GET    | /api/orders      | Get logged-in user's orders |
| GET    | /api/orders/{id} | Get order details           |


## Product Search

Products can be searched using query parameters.

- GET /api/products?search=T-shirt
- GET /api/products?min_price=1000&max_price=5000
- GET /api/products?in_stock=1


## Database Transaction and Stock Handling
 - Order creation uses:
    DB::transaction()

lockForUpdate() : 
    This prevents concurrent requests from ordering the same remaining stock at the same time.

## API Rate Limiting
Authentication endpoints are rate limited to reduce brute-force attempts.

Authenticated APIs also use rate limiting to prevent excessive API traffic.

## R&D Features

## Redis Caching
    Redis could be used to cache frequently accessed product data.

    For example:

     Cache::remember('products', 600, function () {
        return Product::all();
    });

## Queue Processing
    For larger order-processing workloads, Laravel queues could be used for operations that do not need to block the API response.

    Examples:

    Email notifications
    Invoice generation
    External service communication

## Email Notification

After successfully creating an order, an email notification could be queued using Laravel notifications or mailables.

Example flow:
    Create Order
        ↓
    Commit Database Transaction
        ↓
    Dispatch Job
        ↓
    Queue Worker
        ↓
    Send Confirmation Email


## Product Search

    Product searching and filtering has been implemented using Laravel query builder conditions.

    Supported filters:

   - Product name/description
   - Minimum price
   - Maximum price
   - Available stock