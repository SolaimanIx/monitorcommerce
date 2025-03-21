# E-Commerce Web Application

This repository contains a Laravel-based e-commerce platform with a modern, responsive design. This application provides a complete solution for online retail businesses with user authentication, product management, shopping cart functionality, wishlist management, and more.

## Features

### Customer Features
- **User Authentication**: Registration, login, and password recovery
- **Product Browsing**: 
  - Browse products by category
  - Filter products by price, size, and other attributes
  - Search functionality with live results
- **Shopping Cart**: 
  - Add/remove items
  - Update quantities
  - Apply coupon codes
- **Wishlist Management**: Save products for later
- **Checkout Process**: 
  - Multiple payment method integration
  - Address management
- **Order Tracking**: View order history and status
- **User Profile**: Manage personal information and preferences
- **Responsive Design**: Mobile-friendly interface

### Admin Features
- **Dashboard**: Overview of sales, users, and inventory
- **Product Management**: Add, edit, and delete products
- **Category Management**: Organize products into categories
- **Order Management**: Process and track orders
- **User Management**: View and manage user accounts
- **Coupon Management**: Create and manage promotional codes
- **Content Management**: Update site content

## Technical Stack

- **Backend**: Laravel PHP Framework
- **Frontend**: 
  - HTML5, CSS3, JavaScript
  - jQuery
  - Bootstrap
- **Database**: MySQL
- **Additional Libraries**:
  - Swiper.js for carousels
  - Sweet Alert for notifications
  - NoUiSlider for range sliders

## Installation

1. Clone the repository
```bash
gh repo clone SolaimanIx/monitorcommerce
cd e-commerce
```

2. Install dependencies
```bash
composer install
npm install
```

3. Create environment file
```bash
cp .env.example .env
```

4. Generate application key
```bash
php artisan key:generate
```

5. Configure database settings in `.env` file
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

6. Run migrations and seed the database
```bash
php artisan migrate
php artisan db:seed
```

7. Create symbolic link to storage
```bash
php artisan storage:link
```

8. Build assets
```bash
npm run dev
```

9. Run the application
```bash
php artisan serve
```

## Directory Structure

- **app/**: Contains the core code of the application
  - **Http/Controllers/**: Application controllers
  - **Models/**: Eloquent models
  - **Providers/**: Service providers
- **config/**: Configuration files
- **database/**: Migrations and seeders
- **public/**: Publicly accessible files
  - **assets/**: CSS, JS, and images
  - **uploads/**: User-uploaded content
- **resources/**: Views and uncompiled assets
  - **views/**: Blade templates
- **routes/**: Application routes

## Key Features Documentation

### Search Functionality
The application includes a dynamic search feature that shows results as you type:
- Triggers after 3+ characters are entered
- Displays product images and names in real-time
- Links directly to product details

### Shopping Cart
The shopping cart uses Laravel's cart instance functionality to:
- Store items in sessions
- Calculate totals
- Track quantities
- Persist cart contents between sessions

### User Authentication
Multi-role authentication system with:
- Customer accounts
- Admin accounts with enhanced privileges
- Secure password handling

## License

This project is licensed under the MIT License

## Credits

- Design based on the Uomo template
- Icons from various sources including Font Awesome
- Ahmed Hesham for development


